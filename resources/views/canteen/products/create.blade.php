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
            <select name="category" id="category" required>
                <option value="">Select Category</option>
                <option value="soda">Soda</option>
                <option value="popcorn">Popcorn</option>
                <option value="chips">Chips</option>
                <option value="water">Water Bottle</option>
            </select>
        </div>
        <!-- Soda Details: show only if category is soda -->
        <div id="soda-details" style="display:none;">
            <div>
                <label>Soda Name:</label>
                <input type="text" name="soda_name">
            </div>
            <div>
                <label>Brand:</label>
                <input type="text" name="brand">
            </div>
            <div>
                <label>Size (ml):</label>
                <input type="number" name="size_ml">
            </div>
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>
        <button type="submit">Create Product</button>
    </form>

    <script>
      // Toggle soda details based on category selection
      const categorySelect = document.getElementById('category');
      const sodaDetails = document.getElementById('soda-details');
      
      categorySelect.addEventListener('change', function() {
          sodaDetails.style.display = (this.value === 'soda') ? 'block' : 'none';
      });
    </script>
</x-app-layout>
