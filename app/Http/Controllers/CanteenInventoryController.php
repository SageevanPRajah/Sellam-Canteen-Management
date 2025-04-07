<?php
namespace App\Http\Controllers;
use App\Models\CanteenInventory;
use App\Models\Product;
use App\Models\Show;
use App\Models\CanteenTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CanteenInventoryController extends Controller {
    
    public function selectShow(Request $request)
{
    $date = $request->input('date');
    if ($date) {
        $shows = Show::whereDate('date', $date)->orderBy('time')->get();
    } else {
        $shows = Show::orderBy('date', 'desc')->get();
    }
    return view('canteen.inventory.select_show', compact('shows'));
}


    public function showInventory(Request $request, $showId) {
        $show = Show::findOrFail($showId);
        $products = Product::all();
        
        $inventories = CanteenInventory::where('show_id', $showId)->get()->keyBy('product_id');
        return view('canteen.inventory.inventory', compact('show', 'products', 'inventories'));
    }

    public function updateInventory(Request $request, $showId)
    {
        $data = $request->validate([
            'inventories' => 'required|array', 
        ]);

        $action = $request->input('action'); 

        DB::beginTransaction();
        try {
            foreach ($data['inventories'] as $productId => $inventoryData) {
                $product = Product::findOrFail($productId);
                // Find or create the inventory record for this show and product
                $inventory = CanteenInventory::firstOrNew([
                    'show_id'    => $showId,
                    'product_id' => $productId
                ]);

                $inventory->initial_stock = $inventoryData['initial_stock'];
                $inventory->refill_stock  = $inventoryData['refill_stock'] ?? 0;
                $inventory->final_stock   = $inventoryData['final_stock'];
                $inventory->save();

                if ($action === 'update_stock') {
                    // Simply update the product stock count to the final stock value.
                    $product->stock_count = $inventory->final_stock;
                    $product->save();
                } elseif ($action === 'update_inventory') {
                    // Calculate sold units: (initial + refill) - final
                    $soldCount = ($inventory->initial_stock + $inventory->refill_stock) - $inventory->final_stock;
                    // Update product stock: subtract soldCount from current stock (or set to final stock, as needed)
                    $product->stock_count = max(0, $product->stock_count - $soldCount);
                    $product->save();

                    // Calculate revenue from sold items
                    $revenue = $soldCount * $product->selling_price;
                    if ($soldCount > 0) {
                        \App\Models\CanteenTransaction::create([
                            'credit'             => $revenue,
                            'debit'              => 0,
                            'balance'            => $this->calculateNewBalance($revenue),
                            'transaction_type'   => 'credit',
                            'username'           => auth()->user()->name,
                            'inside_transaction' => false, // or adjust based on your needs
                            'description'        => "Sold {$soldCount} units of {$product->name} during show {$showId}",
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('canteen.inventory.selectShow')->with('success', 'Inventory updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Canteen Inventory Update Error: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to update inventory: ' . $e->getMessage());
        }
    }

    // Helper method to calculate new balance for transactions
    private function calculateNewBalance($creditAmount)
    {
        $lastTransaction = \App\Models\CanteenTransaction::orderBy('created_at', 'desc')->first();
        $previousBalance = $lastTransaction ? $lastTransaction->balance : 0;
        return $previousBalance + $creditAmount;
    }
}
