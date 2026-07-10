<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportMnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Auth::user()->mentorProfile;
        $reports = $data->weeklyReports()->with('intern')->latest('week_start_date');

        $interns = $data->interns()->where('status', 'Đang thực tập')->get();
        // Intern_id
        if (request()->filled('intern_id')) {
            $reports = $reports->where('intern_id', request()->intern_id);
        }

        // Status
        if (request()->filled('status')) {
            $reports = $reports->where('weekly_reports.status', request()->status);
        }
        $reports = $reports->paginate(4);

        return view('frontend.mentor.reports.reports', compact('reports', 'interns'));
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
        $report = Auth::user()->mentorProfile->weeklyReports()->findOrFail($id);

        $report->mentor_comment = $request->mentor_comment;
        if ($report->status === 'pending' && filled($request->mentor_comment)) {
            $report->status = 'reviewed';
        }

        $report->save();

        return redirect()
            ->back()
            ->with('success', 'Cập nhật báo cáo thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
