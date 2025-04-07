<x-app-layout>
    <h1>Inside Inventory Consumption</h1>
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="error-messages">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('canteen.inside_inventory.store') }}" method="POST">
        @csrf
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Current Stock</th>
                    <th>Quantity Taken</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock_count }}</td>
                        <td>
                            <!-- Input name as items[product_id] -->
                            <input type="number" name="items[{{ $product->id }}]" value="0" min="0">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>
        <button type="submit">Update Inside Inventory</button>
    </form>
</x-app-layout>
