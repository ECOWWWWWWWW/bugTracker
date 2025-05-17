<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Calculate trends (example: compared to last week)
        $lastWeekBugs = Bug::where('created_at', '>=', now()->subWeek())->count();
        $previousWeekBugs = Bug::where('created_at', '>=', now()->subWeeks(2))
                              ->where('created_at', '<', now()->subWeek())
                              ->count();
        $bugsTrend = $lastWeekBugs - $previousWeekBugs;
        $users = User::where('role', 'user')
                 ->orderBy('name')
                 ->get();

        return view('admin.dashboard', [
            'totalBugs' => Bug::count(),
            'openBugs' => Bug::where('status', 'open')->count(),
            'resolvedBugs' => Bug::where('status', 'resolved')->count(),
            'bugsTrend' => ($bugsTrend >= 0 ? '+' : '') . $bugsTrend,
            'openBugsPercent' => Bug::count() > 0 
                ? round((Bug::where('status', 'open')->count() / Bug::count()) * 100) 
                : 0,
            'resolvedBugsPercent' => Bug::count() > 0 
                ? round((Bug::where('status', 'resolved')->count() / Bug::count()) * 100) 
                : 0,
            'priorityLow' => Bug::where('priority', 'low')->count(),
            'priorityMedium' => Bug::where('priority', 'medium')->count(),
            'priorityHigh' => Bug::where('priority', 'high')->count(),
            'statusOpen' => Bug::where('status', 'open')->count(),
            'statusInProgress' => Bug::where('status', 'in_progress')->count(),
            'statusResolved' => Bug::where('status', 'resolved')->count(),
            'recentBugs' => Bug::latest()->take(5)->get(),
            'unassignedBugsCount' => Bug::whereNull('assigned_to')->count(),
            'unassignedBugs' => Bug::whereNull('assigned_to')->get(),
            'users' => $users
        ]);
    }
    
    public function users()
    {
        $users = User::latest()
                     ->paginate(10);
                     
        return view('admin.users', compact('users'));
    }
    
    public function updateRole(Request $request, User $user)
    {
        if($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $validated = $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->update(['role' => $validated['role']]);

        $action = $validated['role'] === 'admin' ? 'promoted to admin' : 'demoted to user';
        return back()->with('success', "User has been {$action} successfully.");
    }
    
    public function bugs()
    {
        $bugs = Bug::with(['user', 'assignedUser'])
                   ->latest()
                   ->paginate(10);
                   
        $users = User::where('role', 'user')
                     ->orderBy('name')
                     ->get();
        
        return view('admin.bugs', compact('bugs', 'users'));
    }
    
    public function assignBug(Request $request, Bug $bug)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);
        
        $bug->update(['assigned_to' => $validated['assigned_to']]);
        
        return redirect()->route('admin.bugs')->with('success', 'Bug assigned successfully');
    }
    
    public function roles()
    {
        $roles = ['user', 'admin', 'team_member']; // or fetch from your roles table if you have one
        $users = User::all();
        
        return view('admin.roles.index', compact('roles', 'users'));
    }

    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:user,admin,team_member'
        ]);

        $user = User::findOrFail($validated['user_id']);
        $user->role = $validated['role'];
        $user->save();

        return back()->with('success', 'User role updated successfully');
    }
    
    public function unassignedBugs()
    {
        $bugs = Bug::whereNull('assigned_to')
                   ->with('user')
                   ->get();
               

        // Get all users except admins
        $users = User::where('role', 'user')
                     ->orderBy('name')
                     ->get();
    
        return view('admin.bugs.unassigned', compact('bugs', 'users'));
    }
}