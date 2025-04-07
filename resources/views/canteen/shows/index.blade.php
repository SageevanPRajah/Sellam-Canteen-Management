<x-app-layout>
    <h1>Shows</h1>
    <a href="{{ route('canteen.shows.create') }}">Add New Show</a>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shows as $show)
                <tr>
                    <td>{{ $show->id }}</td>
                    <td>{{ $show->date }}</td>
                    <td>{{ $show->time }}</td>
                    <td>
                        <a href="{{ route('canteen.shows.edit', $show->id) }}">Edit</a>
                        <form action="{{ route('canteen.shows.destroy', $show->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this show?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
