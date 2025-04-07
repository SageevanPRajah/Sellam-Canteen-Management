<x-app-layout>
    <h1>Select Show for Inventory Management</h1>
    <ul>
        @foreach($shows as $show)
        <li>
            {{ $show->date }} - {{ $show->time }} - {{ $show->movie_name }}
            <a href="{{ route('canteen.inventory.show', $show->id) }}">Manage Inventory</a>
        </li>
        @endforeach
    </ul>
</x-app-layout>
