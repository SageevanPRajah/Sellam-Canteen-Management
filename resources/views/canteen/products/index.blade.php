<x-app-layout>
    <h1>Products</h1>
    <a href="{{ route('canteen.products.create') }}">Add New Product</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Stock Count</th>
                <th>Original Price</th>
                <th>Selling Price</th>
                <th>Category</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->stock_count }}</td>
                <td>{{ number_format($product->original_price, 2) }}</td>
                <td>{{ number_format($product->selling_price, 2) }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ $product->description }}</td>
                <td>
                    <a href="{{ route('canteen.products.edit', $product->id) }}">Edit</a>
                    <form action="{{ route('canteen.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this product?');">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
