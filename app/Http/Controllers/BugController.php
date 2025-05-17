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
        $bugs = Bug::with(['user', 'assignedUser'])
                   ->where(function($query) {
                       $query->where('assigned_to', auth()->id())
                             ->orWhere('user_id', auth()->id());
                   })
                   ->latest()
                   ->get();
                   
        return view('bugs.index', compact('bugs'));
    }

    public function create()
    {
        return view('bugs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:open,in_progress,resolved'  // Add this validation
        ]);

        Bug::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],  // Add this line
            'user_id' => auth()->id()
        ]);

        return redirect()->route('bugs.index')
            ->with('success', 'Bug reported successfully.');
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
            'status' => 'required|in:open,in progress,resolved', // Changed from in_progress to "in progress"
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
