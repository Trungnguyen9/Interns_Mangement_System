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
                'icon' => 'fa-solid fa-users',
                'color' => 'si-primary',
                'label' => 'Interns phụ trách',
                'value' => $currentInterns . ' / ' . $maxInterns,
                'sub' => 'Slot hiện tại'
            ],

            [
                'icon' => 'fa-solid fa-list-check',
                'color' => 'si-primary',
                'label' => 'Tasks đã giao',
                'value' => $totalTasks,
                'sub' => 'Tổng cộng'
            ],

            [
                'icon' => 'fa-solid fa-hourglass-half',
                'color' => 'si-warning',
                'label' => 'Tasks chờ duyệt',
                'value' => $reviewTasks,
                'sub' => 'Task ở trạng thái review'
            ],

            [
                'icon' => 'fa-solid fa-circle-check',
                'color' => 'si-success',
                'label' => 'Tasks hoàn thành',
                'value' => $doneTasks,
                'sub' => 'Đã Done'
            ],

            [
                'icon' => 'fa-solid fa-file-circle-exclamation',
                'color' => 'si-danger',
                'label' => 'Báo cáo chưa duyệt',
                'value' => $totalPendingReports,
                'sub' => 'Cần nhận xét'
            ],

        ];
        return view('frontend.mentor.dashboard', compact('stats', 'internsList', 'nearDeadlineTasks', 'pendingReportsList'));
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
