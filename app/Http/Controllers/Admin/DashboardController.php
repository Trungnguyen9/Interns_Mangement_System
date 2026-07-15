<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern_profiles;
use App\Models\Mentor_profiles;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Weekly_report;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ==========================
        // Tổng quan
        // ==========================
        $totalInterns = Intern_profiles::count();

        $ongoingInterns = Intern_profiles::where('status', 'Đang thực tập')->count();

        $totalMentors = Mentor_profiles::count();

        // ==========================
        // Task
        // ==========================
        $totalTasks = Task::count();

        $pendingReviewTasks = Task::where('status', 'Review')->count();

        $completedTasks = Task::where('status', 'Done')->count();

        // ==========================
        // Weekly Report
        // ==========================
        $pendingReports = Weekly_report::where('status', 'pending')->count();

        // ==========================
        // Task gần deadline
        // ==========================
        $nearDeadlineQuery = Task::with([
            'intern',
            'intern.mentor'
        ])
            ->where('status', '!=', 'Done')
            ->whereBetween('deadline', [
                now(),
                now()->addDays(3)
            ]);

        $nearDeadlineTasksCount = (clone $nearDeadlineQuery)->count();

        $nearDeadlineTasksList = $nearDeadlineQuery
            ->orderBy('deadline')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalInterns',
            'ongoingInterns',
            'totalMentors',
            'totalTasks',
            'pendingReviewTasks',
            'completedTasks',
            'pendingReports',
            'nearDeadlineTasksCount',
            'nearDeadlineTasksList'
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
