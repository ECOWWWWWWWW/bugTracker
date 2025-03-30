<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total bugs count
        $totalBugs = Bug::count();
        
        // Get open bugs count and percentage
        $openBugs = Bug::where('status', 'open')->count();
        $openBugsPercent = $totalBugs > 0 ? round(($openBugs / $totalBugs) * 100, 1) : 0;
        
        // Get resolved bugs count and percentage
        $resolvedBugs = Bug::where('status', 'resolved')->count();
        $resolvedBugsPercent = $totalBugs > 0 ? round(($resolvedBugs / $totalBugs) * 100, 1) : 0;
        
        // Get in progress bugs count
        $inProgressBugs = Bug::where('status', 'in_progress')->count();
        
        // Get bug trend (percentage increase/decrease in last 30 days)
        $bugsLastMonth = Bug::where('created_at', '<=', now()->subDays(30))->count();
        $bugsThisMonth = Bug::where('created_at', '>', now()->subDays(30))->count();
        $bugsTrend = $bugsLastMonth > 0 
            ? round((($bugsThisMonth - $bugsLastMonth) / $bugsLastMonth) * 100, 1) . '%'
            : '100%';
        
        // Get bugs by priority
        $priorityLow = Bug::where('priority', 'low')->count();
        $priorityMedium = Bug::where('priority', 'medium')->count();
        $priorityHigh = Bug::where('priority', 'high')->count();
        
        // Get bugs by status for charts
        $statusOpen = $openBugs;
        $statusInProgress = $inProgressBugs;
        $statusResolved = $resolvedBugs;
        
        // Get recent bugs (last 10)
        $recentBugs = Bug::with('user')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();
        
        return view('dashboard', compact(
            'totalBugs',
            'openBugs',
            'openBugsPercent',
            'resolvedBugs',
            'resolvedBugsPercent',
            'bugsTrend',
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