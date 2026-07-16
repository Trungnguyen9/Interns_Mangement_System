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
        $internQ = Intern_profiles::query();
        $mentorQ = Mentor_profiles::query();
        $taskQ = Task::query();
        $reportQ = Weekly_report::query();

        $totalInterns = (clone $internQ)->count();

        $ongoingInterns = (clone $internQ)
            ->where('status', 'Đang thực tập')
            ->count();

        $totalMentors = (clone $mentorQ)->count();

        $totalTasks = (clone $taskQ)->count();

        $pendingReviewTasks = (clone $taskQ)
            ->where('status', 'Review')
            ->count();

        $completedTasks = (clone $taskQ)
            ->where('status', 'Done')
            ->count();

        $pendingReports = (clone $reportQ)
            ->where('status', 'pending')
            ->count();

        $nearDeadlineTaskQ = Task::with([
            'intern',
            'intern.mentor'
        ])
            ->where('status', '!=', 'Done')
            ->whereDate('deadline', '>=', now()->toDateString())
            ->whereDate('deadline', '<=', now()->addDays(3)->toDateString());

        $nearDeadlineTasksCount = (clone $nearDeadlineTaskQ)->count();

        $nearDeadlineTasksList = (clone $nearDeadlineTaskQ)
            ->orderBy('deadline')
            ->take(5)
            ->get();

        $stats = [
            [
                'title' => 'Tổng số Mentor',
                'value' => $totalMentors,
                'icon'  => 'ti-crown',
                'color' => 'purple',
            ],

            [
                'title' => 'Tổng số Intern',
                'value' => $totalInterns,
                'icon'  => 'mdi mdi-account-card-details',
                'color' => 'info',
            ],

            [
                'title' => 'Đang thực tập',
                'value' => $ongoingInterns,
                'icon'  => 'mdi mdi-av-timer',
                'color' => 'cyan',
            ],

            [
                'title' => 'Báo cáo chưa review',
                'value' => $pendingReports,
                'icon'  => 'ti-file',
                'color' => 'warning',
            ],

            [
                'title' => 'Tổng số Task',
                'value' => $totalTasks,
                'icon'  => 'ti-clipboard',
                'color' => 'primary',
            ],

            [
                'title' => 'Task chờ review',
                'value' => $pendingReviewTasks,
                'icon'  => 'ti-eye',
                'color' => 'orange',
            ],

            [
                'title' => 'Task đã hoàn thành',
                'value' => $completedTasks,
                'icon'  => 'ti-check',
                'color' => 'success',
            ],

            [
                'title' => 'Task gần deadline',
                'value' => $nearDeadlineTasksCount,
                'icon'  => 'ti-alarm-clock',
                'color' => 'danger',
            ],
        ];

        return view('admin.dashboard.index', compact(
            'totalInterns',
            'ongoingInterns',
            'totalMentors',
            'totalTasks',
            'pendingReviewTasks',
            'completedTasks',
            'pendingReports',
            'nearDeadlineTasksCount',
            'nearDeadlineTasksList',
            'stats'
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
