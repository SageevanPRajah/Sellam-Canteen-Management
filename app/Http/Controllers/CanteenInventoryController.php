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
    // Show a list of shows so the user can select one for inventory management
    public function selectShow() {
        $shows = Show::orderBy('date', 'desc')->get();
        return view('canteen.inventory.select_show', compact('shows'));
    }

    // For a given show, display the products and any existing inventory record
    public function showInventory(Request $request, $showId) {
        $show = Show::findOrFail($showId);
        $products = Product::all();
        // Get inventory records keyed by product_id
        $inventories = CanteenInventory::where('show_id', $showId)->get()->keyBy('product_id');
        return view('canteen.inventory.inventory', compact('show', 'products', 'inventories'));
    }

    // Update inventory records for the selected show
    public function updateInventory(Request $request, $showId) {
        $data = $request->validate([
            'inventories' => 'required|array', // expects [product_id => ['initial_stock'=>.., 'refill_stock'=>.., 'final_stock'=>..], ...]
        ]);

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

                // Calculate sold units: (initial + refill) - final
                $soldCount = ($inventory->initial_stock + $inventory->refill_stock) - $inventory->final_stock;

                // Deduct sold units from the overall product stock (ensuring stock does not go negative)
                $product->stock_count = max(0, $product->stock_count - $soldCount);
                $product->save();

                // Calculate revenue from sold items
                $revenue = $soldCount * $product->selling_price;
                if ($soldCount > 0) {
                    CanteenTransaction::create([
                        'amount'             => $revenue,
                        'transaction_type'   => 'credit',
                        'description'        => "Sold {$soldCount} units of {$product->name} during show {$showId}",
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('canteen.inventory.selectShow')->with('success', 'Inventory updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Canteen Inventory Update Error: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to update inventory: ' . $e->getMessage());
        }
    }
}
