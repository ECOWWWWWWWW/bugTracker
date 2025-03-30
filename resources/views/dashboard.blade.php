@extends('layouts.calm-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i data-feather="pie-chart" class="me-2"></i>
                    Bug Tracker Dashboard
                </div>

                <div class="card-body">
                    <div id="loading-view">
                        <div class="row">
                            <!-- Summary Cards Loading -->
                            <div class="col-md-4 mb-4">
                                <div class="skeleton-loader card" style="height: 150px;"></div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="skeleton-loader card" style="height: 150px;"></div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="skeleton-loader card" style="height: 150px;"></div>
                            </div>
                            
                            <!-- Charts Loading -->
                            <div class="col-md-6 mb-4">
                                <div class="skeleton-loader card" style="height: 300px;"></div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="skeleton-loader card" style="height: 300px;"></div>
                            </div>
                            
                            <!-- Recent Bugs Loading -->
                            <div class="col-md-12">
                                <h5 class="mb-3">Recent Bugs</h5>
                                <div class="skeleton-loader text"></div>
                                <div class="skeleton-loader text"></div>
                                <div class="skeleton-loader text"></div>
                                <div class="skeleton-loader text"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="content-view" style="display: none;">
                        <!-- Dashboard Stats Summary -->
                        <div class="row mb-4">
                            <!-- Total Bugs Card -->
                            <div class="col-md-4 mb-4">
                                <div class="stats-card">
                                    <div class="stats-card__icon">
                                        <i data-feather="alert-circle"></i>
                                    </div>
                                    <div class="stats-card__content">
                                        <h3 class="stats-card__title">{{ $totalBugs ?? 0 }}</h3>
                                        <p class="stats-card__description">Total Bugs</p>
                                    </div>
                                    <div class="stats-card__chart">
                                        <div class="stats-card__trend">
                                            <i data-feather="trending-up" class="text-success"></i>
                                            <span>{{ $bugsTrend ?? '0%' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Open Bugs Card -->
                            <div class="col-md-4 mb-4">
                                <div class="stats-card">
                                    <div class="stats-card__icon stats-card__icon--blue">
                                        <i data-feather="clock"></i>
                                    </div>
                                    <div class="stats-card__content">
                                        <h3 class="stats-card__title">{{ $openBugs ?? 0 }}</h3>
                                        <p class="stats-card__description">Open Bugs</p>
                                    </div>
                                    <div class="stats-card__chart">
                                        <div class="stats-card__progress">
                                            <div class="progress">
                                                <div class="progress-bar bg-info" role="progressbar" 
                                                     style="width: {{ $openBugsPercent ?? 0 }}%" 
                                                     aria-valuenow="{{ $openBugsPercent ?? 0 }}" 
                                                     aria-valuemin="0" aria-valuemax="100">
                                                    {{ $openBugsPercent ?? 0 }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Resolved Bugs Card -->
                            <div class="col-md-4 mb-4">
                                <div class="stats-card">
                                    <div class="stats-card__icon stats-card__icon--green">
                                        <i data-feather="check-circle"></i>
                                    </div>
                                    <div class="stats-card__content">
                                        <h3 class="stats-card__title">{{ $resolvedBugs ?? 0 }}</h3>
                                        <p class="stats-card__description">Resolved Bugs</p>
                                    </div>
                                    <div class="stats-card__chart">
                                        <div class="stats-card__progress">
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: {{ $resolvedBugsPercent ?? 0 }}%" 
                                                     aria-valuenow="{{ $resolvedBugsPercent ?? 0 }}" 
                                                     aria-valuemin="0" aria-valuemax="100">
                                                    {{ $resolvedBugsPercent ?? 0 }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Charts -->
                        <div class="row mb-4">
                            <!-- Bug Priority Distribution Chart -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <i data-feather="pie-chart" class="me-2"></i>
                                        Bug Priority Distribution
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <canvas id="priorityChart" height="220"></canvas>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bug Status Distribution Chart -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <i data-feather="bar-chart" class="me-2"></i>
                                        Bug Status Distribution
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <canvas id="statusChart" height="220"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recent Bugs -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <i data-feather="list" class="me-2"></i>
                                        Recent Activity
                                    </div>
                                    <div class="card-body">
                                        @if(isset($recentBugs) && count($recentBugs) > 0)
                                            <div class="activity-timeline">
                                                @foreach($recentBugs as $bug)
                                                    <div class="activity-item">
                                                        <div class="activity-item__icon">
                                                            @if($bug->status == 'open')
                                                                <i data-feather="alert-circle"></i>
                                                            @elseif($bug->status == 'in progress')
                                                                <i data-feather="clock"></i>
                                                            @else
                                                                <i data-feather="check-circle"></i>
                                                            @endif
                                                        </div>
                                                        <div class="activity-item__content">
                                                            <div class="activity-item__date">{{ $bug->updated_at->diffForHumans() }}</div>
                                                            <div class="activity-item__title">
                                                                <a href="{{ route('bugs.edit', $bug->id) }}">{{ $bug->title }}</a>
                                                                <span class="badge badge-{{ strtolower($bug->priority) }} ms-2">{{ ucfirst($bug->priority) }}</span>
                                                            </div>
                                                            <div class="activity-item__description">
                                                                {{ Str::limit($bug->description, 100) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="empty-state">
                                                <div class="empty-state__icon">
                                                    <i data-feather="inbox"></i>
                                                </div>
                                                <p class="empty-state__message">No recent bug activity.</p>
                                                <a href="{{ route('bugs.create') }}" class="btn btn-primary">Report Bug</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Stats Card Styling */
    .stats-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 10px var(--shadow-color);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px var(--shadow-color);
    }
    
    .stats-card__icon {
        width: 50px;
        height: 50px;
        background-color: rgba(126, 181, 166, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }
    
    .stats-card__icon--blue {
        background-color: rgba(71, 145, 255, 0.2);
        color: #4791ff;
    }
    
    .stats-card__icon--green {
        background-color: rgba(102, 184, 132, 0.2);
        color: #66b884;
    }
    
    .stats-card__title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 0.2rem;
    }
    
    .stats-card__description {
        color: var(--light-text);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .stats-card__chart {
        margin-top: auto;
    }
    
    .stats-card__trend {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: var(--light-text);
    }
    
    .stats-card__trend svg {
        width: 16px;
        height: 16px;
        margin-right: 5px;
    }
    
    .stats-card__progress {
        margin-top: 0.5rem;
    }
    
    .progress {
        height: 6px;
        border-radius: 3px;
        background-color: #f0f0f0;
    }
    
    /* Activity Timeline */
    .activity-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        height: 100%;
        width: 2px;
        background-color: var(--secondary-color);
    }
    
    .activity-item {
        position: relative;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.05);
    }
    
    .activity-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .activity-item__icon {
        position: absolute;
        left: -30px;
        top: 0;
        width: 30px;
        height: 30px;
        background-color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .activity-item__icon svg {
        width: 16px;
        height: 16px;
    }
    
    .activity-item__content {
        padding-left: 15px;
    }
    
    .activity-item__date {
        font-size: 0.8rem;
        color: var(--light-text);
        margin-bottom: 5px;
    }
    
    .activity-item__title {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 5px;
    }
    
    .activity-item__title a {
        color: var(--text-color);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .activity-item__title a:hover {
        color: var(--primary-color);
    }
    
    .activity-item__description {
        font-size: 0.9rem;
        color: var(--light-text);
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simulate loading time
        setTimeout(() => {
            document.getElementById('loading-view').style.display = 'none';
            document.getElementById('content-view').style.display = 'block';
            
            // Initialize charts
            initializeCharts();
        }, 800);
        
        function initializeCharts() {
            // Priority Chart - Using actual bug data counts
            const priorityData = {
                labels: ['Low', 'Medium', 'High'],
                datasets: [{
                    data: [{{ $priorityLow ?? 0 }}, {{ $priorityMedium ?? 0 }}, {{ $priorityHigh ?? 0 }}],
                    backgroundColor: ['#a8d5ba', '#f8e3a3', '#f3c6c3'],
                    borderWidth: 0
                }]
            };
            
            // Status Chart - Using actual bug data counts
            const statusData = {
                labels: ['Open', 'In Progress', 'Resolved'],
                datasets: [{
                    data: [{{ $statusOpen ?? 0 }}, {{ $statusInProgress ?? 0 }}, {{ $statusResolved ?? 0 }}],
                    backgroundColor: ['#d1ecf1', '#e2e3ff', '#d4edda'],
                    borderWidth: 0
                }]
            };
            
            // Create Priority Chart
            const priorityChart = new Chart(document.getElementById('priorityChart'), {
                type: 'doughnut',
                data: priorityData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: 'Inter',
                                    size: 12
                                },
                                padding: 20
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
            
            // Create Status Chart
            const statusChart = new Chart(document.getElementById('statusChart'), {
                type: 'bar',
                data: {
                    labels: ['Open', 'In Progress', 'Resolved'],
                    datasets: [{
                        label: 'Bug Status',
                        data: [{{ $statusOpen ?? 0 }}, {{ $statusInProgress ?? 0 }}, {{ $statusResolved ?? 0 }}],
                        backgroundColor: ['#d1ecf1', '#e2e3ff', '#d4edda'],
                        borderWidth: 0,
                        borderRadius: 8,
                        maxBarThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    family: 'Inter'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: 'Inter'
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 1000
                    }
                }
            });
        }
    });
</script>
@endsection