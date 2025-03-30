<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BugController extends Controller
{
    public function index()
    {
        $bugs = Bug::where('user_id', auth()->id())->get();
        return view('bugs.index', compact('bugs'));
        
    }

    public function create()
    {
        return view('bugs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        Bug::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('bugs.index')->with('success', 'Bug created successfully.');
    }

    public function edit(Bug $bug)
    {
        return view('bugs.edit', compact('bug'));
    }

    public function update(Request $request, Bug $bug)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:open,in_progress,resolved',
        ]);

        $bug->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => str_replace(' ', '_', $request->status),
        ]);
        return redirect()->route('bugs.index')->with('success', 'Bug updated successfully.');
    }

    public function destroy(Bug $bug)
    {
        $bug->delete();

        return redirect()->route('bugs.index')->with('success', 'Bug deleted successfully.');
    }
}
