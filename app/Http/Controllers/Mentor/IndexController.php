<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $mentor = Auth::user()->mentorProfile;

        $internsList = $mentor->interns->take(5);
        $currentInterns = $mentor->interns->count();
        $maxInterns = $mentor->max_interns;


        $totalTasks = $mentor->tasks()->WhereNotIn('status', ['Done', 'Review'])->count();

        $reviewTasks = $mentor->tasks->where('status', 'Review')->count();
        $doneTasks = $mentor->tasks->where('status', 'Done')->count();
        $nearDeadlineTasks = $mentor->tasks()
            ->where('status', '!=', 'Done')
            ->whereDate('deadline', '>=', now()->toDateString())
            ->whereDate('deadline', '<=', now()->addDays(3)->toDateString())
            ->orderBy('deadline')
            ->take(5)
            ->get();

        $reportQuery = $mentor->weeklyReports();
        $totalPendingReports = $reportQuery->where('weekly_reports.status', 'pending')->count();
        $pendingReportsList = $reportQuery->where('weekly_reports.status', 'pending')->orderBy('updated_at')->take(5)->get();


         $stats = [
            [
                'title' => 'My Interns',
                'value' => $currentInterns . ' / ' . $maxInterns,
                'icon'  => 'mdi mdi-account-multiple',
                'color' => 'cyan',
            ],

            [
                'title' => 'Assigned Tasks',
                'value' => $totalTasks,
                'icon'  => 'mdi mdi-format-list-bulleted',
                'color' => 'info',
            ],

            [
                'title' => 'Pending Tasks',
                'value' => $reviewTasks,
                'icon'  => 'mdi mdi-timer-sand',
                'color' => 'warning',
            ],

            [
                'title' => 'Completed Tasks',
                'value' => $doneTasks,
                'icon'  => 'mdi mdi-check-circle',
                'color' => 'success',
            ],

            [
                'title' => 'Pending Reports',
                'value' => $totalPendingReports,
                'icon'  => 'mdi mdi-file-outline',
                'color' => 'danger',
            ]
        ];
        return view('frontend_fn.mentor.dashboard.index', compact('stats', 'internsList', 'nearDeadlineTasks', 'pendingReportsList'));
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
