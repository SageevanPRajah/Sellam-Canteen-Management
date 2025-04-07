<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function index()
    {
        // Order by date and time (latest first, if needed)
        $shows = Show::orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        return view('canteen.shows.index', compact('shows'));
    }

    public function create()
    {
        return view('canteen.shows.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        Show::create($data);
        return redirect()->route('canteen.shows.index')->with('success', 'Show created successfully.');
    }

    public function edit(Show $show)
    {
        return view('canteen.shows.edit', compact('show'));
    }

    public function update(Request $request, Show $show)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $show->update($data);
        return redirect()->route('canteen.shows.index')->with('success', 'Show updated successfully.');
    }

    public function destroy(Show $show)
    {
        $show->delete();
        return redirect()->route('canteen.shows.index')->with('success', 'Show deleted successfully.');
    }
}
