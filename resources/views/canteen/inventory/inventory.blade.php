<x-app-layout>
    <h1>Inventory for Show: {{ $show->movie_name }} on {{ $show->date }} at {{ $show->time }}</h1>
    <form action="{{ route('canteen.inventory.update', $show->id) }}" method="POST">
        @csrf
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Current Stock</th>
                    <th>Initial Stock (Before Show)</th>
                    <th>Refill Stock (Before Show)</th>
                    <th>Final Stock (After Show)</th>
                    <th>Sold Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                @php
                    $inventory = $inventories->get($product->id);
                    $initial = $inventory ? $inventory->initial_stock : $product->stock_count;
                    $refill  = $inventory ? $inventory->refill_stock : 0;
                    $final   = $inventory ? $inventory->final_stock : $product->stock_count;
                    $sold    = ($initial + $refill) - $final;
                @endphp
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->stock_count }}</td>
                    <td>
                        <input type="number" name="inventories[{{ $product->id }}][initial_stock]" value="{{ $initial }}" required>
                    </td>
                    <td>
                        <input type="number" name="inventories[{{ $product->id }}][refill_stock]" value="{{ $refill }}" required>
                    </td>
                    <td>
                        <input type="number" name="inventories[{{ $product->id }}][final_stock]" value="{{ $final }}" required>
                    </td>
                    <td>{{ $sold }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit">Update Inventory</button>
    </form>
</x-app-layout>
