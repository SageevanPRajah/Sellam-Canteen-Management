<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function index() {
        $products = Product::all();
        return view('canteen.products.index', compact('products'));
    }

    public function create() {
        return view('canteen.products.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name'            => 'required|string',
            'stock_count'     => 'required|integer|min:0',
            'original_price'  => 'required|numeric|min:0',
            'selling_price'   => 'required|numeric|min:0',
            'category'        => 'nullable|string',
            'description'     => 'nullable|string',
        ]);
        Product::create($data);
        return redirect()->route('canteen.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product) {
        return view('canteen.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        $data = $request->validate([
            'name'            => 'required|string',
            'stock_count'     => 'required|integer|min:0',
            'original_price'  => 'required|numeric|min:0',
            'selling_price'   => 'required|numeric|min:0',
            'category'        => 'nullable|string',
            'description'     => 'nullable|string',
        ]);
        $product->update($data);
        return redirect()->route('canteen.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('canteen.products.index')->with('success', 'Product deleted successfully.');
    }
}
