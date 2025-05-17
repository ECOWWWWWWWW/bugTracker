<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get bugs assigned to or created by current user
        $userBugs = Bug::where('assigned_to', auth()->id())
                       ->orWhere('user_id', auth()->id())
                       ->get();

        // Calculate statistics based on user's bugs
        $totalBugs = $userBugs->count();
        $openBugs = $userBugs->where('status', 'open')->count();
        $resolvedBugs = $userBugs->where('status', 'resolved')->count();
        
        // Calculate bug trend (compare to last week)
        $lastWeekBugs = $userBugs->where('created_at', '>=', now()->subWeek())->count();
        $previousWeekBugs = $userBugs->where('created_at', '>=', now()->subWeeks(2))
                                     ->where('created_at', '<', now()->subWeek())
                                     ->count();
        $bugsTrend = $lastWeekBugs - $previousWeekBugs;

        // Calculate percentages
        $openBugsPercent = $totalBugs > 0 ? round(($openBugs / $totalBugs) * 100) : 0;
        $resolvedBugsPercent = $totalBugs > 0 ? round(($resolvedBugs / $totalBugs) * 100) : 0;

        // Get priority distribution
        $priorityLow = $userBugs->where('priority', 'low')->count();
        $priorityMedium = $userBugs->where('priority', 'medium')->count();
        $priorityHigh = $userBugs->where('priority', 'high')->count();

        // Get status distribution
        $statusOpen = $userBugs->where('status', 'open')->count();
        $statusInProgress = $userBugs->where('status', 'in_progress')->count();
        $statusResolved = $userBugs->where('status', 'resolved')->count();

        // Get recent bugs
        $recentBugs = $userBugs->sortByDesc('created_at')->take(5);

        return view('dashboard', compact(
            'totalBugs',
            'openBugs',
            'resolvedBugs',
            'bugsTrend',
            'openBugsPercent',
            'resolvedBugsPercent',
            'priorityLow',
            'priorityMedium',
            'priorityHigh',
            'statusOpen',
            'statusInProgress',
            'statusResolved',
            'recentBugs'
        ));
    }
}