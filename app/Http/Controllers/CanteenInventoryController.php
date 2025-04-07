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
            'inventories' => 'required|array', // expects [product_id => ['initial_stock'=>.., 'refill_stock'=>.., 'final_stock'=>..], ...]
        ]);

        $action = $request->input('action'); // "update_stock" or "update_inventory"

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

                // Always update the product's current stock to match the final stock value
                $product->stock_count = $inventory->final_stock;
                $product->save();

                if ($action === 'update_inventory') {
                    // Calculate sold units: (initial + refill) - final
                    $soldCount = ($inventory->initial_stock + $inventory->refill_stock) - $inventory->final_stock;
                    
                    // Calculate revenue from sold items
                    $revenue = $soldCount * $product->selling_price;
                    if ($soldCount > 0) {
                        \App\Models\CanteenTransaction::create([
                            'credit'             => $revenue,
                            'debit'              => 0,
                            'balance'            => $this->calculateNewBalance($revenue),
                            'transaction_type'   => 'credit',
                            'username'           => auth()->user()->name,
                            'inside_transaction' => false, // Adjust as needed
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


    // Inside CanteenInventoryController.php
    public function insideIndex()
    {
        // Fetch all products (you can add filters if needed)
        $products = \App\Models\Product::all();
        return view('canteen.inside_inventory.index', compact('products'));
    }

    public function insideStore(Request $request)
    {
        // Validate that 'items' is an array of product IDs with quantities
        $data = $request->validate([
            'items'       => 'required|array', // Example: items[product_id] = quantity_taken
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            foreach ($data['items'] as $productId => $quantity) {
                if ($quantity > 0) {
                    $product = \App\Models\Product::findOrFail($productId);
                    // Deduct the taken quantity from the product's current stock
                    $product->stock_count = max(0, $product->stock_count - $quantity);
                    $product->save();

                    // Calculate the debit amount using the product's original price
                    $debitAmount = $quantity * $product->original_price;

                    // Create a transaction record with inside_transaction set to true
                    \App\Models\CanteenTransaction::create([
                        'credit'             => 0,
                        'debit'              => $debitAmount,
                        'balance'            => $this->calculateNewBalanceDebit($debitAmount),
                        'transaction_type'   => 'debit',
                        'username'           => auth()->user()->name,
                        'inside_transaction' => true,
                        'description'        => $data['description'] ?? "Inside consumption: Removed {$quantity} units of {$product->name}",
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('canteen.inside_inventory.index')->with('success', 'Inside inventory updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Inside Inventory Update Error: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to update inside inventory: ' . $e->getMessage());
        }
    }

    // Helper method to calculate the new balance when deducting money:
    private function calculateNewBalanceDebit($debitAmount)
    {
        $lastTransaction = \App\Models\CanteenTransaction::orderBy('created_at', 'desc')->first();
        $previousBalance = $lastTransaction ? $lastTransaction->balance : 0;
        return $previousBalance - $debitAmount;
    }


}
