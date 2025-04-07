<x-app-layout>
    <h1>Create Show</h1>

    @if($errors->any())
        <div class="error-messages">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('canteen.shows.store') }}" method="POST">
        @csrf
        <div>
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required>
        </div>
        <div>
            <label for="time">Time:</label>
            <input type="time" name="time" id="time" required>
        </div>
        <button type="submit">Create Show</button>
    </form>
</x-app-layout>
