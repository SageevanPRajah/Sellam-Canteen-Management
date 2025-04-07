<x-app-layout>
    <h1>Create Product</h1>
    <form action="{{ route('canteen.products.store') }}" method="POST">
        @csrf
        <div>
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Stock Count:</label>
            <input type="number" name="stock_count" value="0" required>
        </div>
        <div>
            <label>Original Price:</label>
            <input type="number" step="0.01" name="original_price" required>
        </div>
        <div>
            <label>Selling Price:</label>
            <input type="number" step="0.01" name="selling_price" required>
        </div>
        <div>
            <label>Category:</label>
            <input type="text" name="category">
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>
        <button type="submit">Create Product</button>
    </form>
</x-app-layout>
