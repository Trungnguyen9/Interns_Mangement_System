<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskQuery = Auth::user()->internProfile->tasks();

        $totalTask = (clone $taskQuery)
            ->whereNotIn('status', ['Done', 'Review'])
            ->count();

        $taskDoing = (clone $taskQuery)
            ->where('status', 'Doing')
            ->count();

        $taskReview = (clone $taskQuery)
            ->where('status', 'Review')
            ->count();

        $taskDone = (clone $taskQuery)
            ->where('status', 'Done')
            ->count();

        $taskNearDeadline = (clone $taskQuery)
            ->whereNotIn('status', ['Done', 'Review'])
            ->whereDate('deadline', '>=', now()->toDateString())
            ->whereDate('deadline', '<=', now()->copy()->addDays(3)->toDateString())
            ->get();

        $reportQuery = Auth::user()->internProfile->weeklyReports();

        $reportNew = (clone $reportQuery)
            ->latest('created_at')
            ->first();

        $commentNew = (clone $reportQuery)
            ->whereNotNull('mentor_comment')
            ->latest('updated_at')
            ->first();

        $stats = [
            [
                'title' => 'Total Tasks',
                'value' => $totalTask,
                'icon'  => 'mdi mdi-format-list-bulleted',
                'color' => 'cyan',
            ],

            [
                'title' => 'In Progress',
                'value' => $taskDoing,
                'icon'  => 'mdi mdi-settings',
                'color' => 'warning',
            ],

            [
                'title' => 'Pending Review',
                'value' => $taskReview,
                'icon'  => 'mdi mdi-eye',
                'color' => 'info',
            ],

            [
                'title' => 'Completed Tasks',
                'value' => $taskDone,
                'icon'  => 'mdi mdi-check-circle',
                'color' => 'success',
            ],
        ];



        $intern = Auth::user()->internProfile;

        $totalWeeks = Carbon::parse($intern->start_date)
            ->diffInWeeks(Carbon::parse($intern->end_date));

        $currentWeeks = min(
            Carbon::parse($intern->start_date)->diffInWeeks(now()),
            $totalWeeks
        );

        $percent = $totalWeeks > 0
            ? round(($currentWeeks / $totalWeeks) * 100)
            : 0;

        $progress = [
            'current_week' => $currentWeeks,
            'total_weeks' => $totalWeeks,
            'weeks_left' => max(0, $totalWeeks - $currentWeeks),
            'percent' => $percent,
        ];


        return view('frontend_fn.intern.dashboard.dashboard', compact(
            'totalTask',
            'taskDoing',
            'taskReview',
            'taskDone',
            'taskNearDeadline',
            'reportNew',
            'commentNew',
            'stats',
            'progress',
            'intern'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
