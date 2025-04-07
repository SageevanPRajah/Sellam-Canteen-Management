<x-app-layout>
    <h1>Select Show for Inventory Management</h1>
    <form action="{{ route('canteen.inventory.selectShow') }}" method="GET">
        <label for="date">Select Date:</label>
        <input type="date" name="date" id="date">
        <button type="submit">Filter Shows</button>
    </form>

    <ul>
        @foreach($shows as $show)
            <li>
                {{ $show->date }} - {{ $show->time }}
                <a href="{{ route('canteen.inventory.show', $show->id) }}">Manage Inventory</a>
            </li>
        @endforeach
    </ul>
</x-app-layout>
