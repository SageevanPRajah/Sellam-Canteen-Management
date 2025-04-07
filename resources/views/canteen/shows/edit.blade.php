<x-app-layout>
    <h1>Edit Show</h1>

    @if($errors->any())
        <div class="error-messages">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('canteen.shows.update', $show->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" value="{{ $show->date }}" required>
        </div>
        <div>
            <label for="time">Time:</label>
            <input type="time" name="time" id="time" value="{{ $show->time }}" required>
        </div>
        <button type="submit">Update Show</button>
    </form>
</x-app-layout>
