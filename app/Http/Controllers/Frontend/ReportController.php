<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\frontend\CreateReport;
use App\Models\Weekly_report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Auth::user()->internProfile->weeklyReports()->get();
        return view('frontend.intern.reports.reports', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('frontend.intern.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateReport $request)
    {
        $intern = Auth::user()->internProfile;

        // Kiểm tra khoảng thời gian nằm trong thời gian thực tập
        if (
            $request->week_start_date < $intern->start_date ||
            $request->week_end_date > $intern->end_date
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'week_start_date' => 'Khoảng thời gian báo cáo phải nằm trong thời gian thực tập.'
                ]);
        }

        // Kiểm tra báo cáo bị trùng khoảng thời gian
        $exists = Weekly_report::where('intern_id', $intern->id)
            ->where('week_start_date', $request->week_start_date)
            ->where('week_end_date', $request->week_end_date)
            ->exists();

        // Kiểm tra khoảng thời gian bị chồng lấn
        $exists = Weekly_report::where('intern_id', $intern->id)
            ->where(function ($query) use ($request) {
                $query->where('week_start_date', '<=', $request->week_end_date)
                    ->where('week_end_date', '>=', $request->week_start_date);
            })
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'week_start_date' => 'Bạn đã nộp báo cáo cho khoảng thời gian này / khoảng thời gian này chồng lấn với báo cáo đã nộp trước đó.'
                ]);
        }

        Weekly_report::create([
            'intern_id' => $intern->id,
            'week_start_date' => $request->week_start_date,
            'week_end_date' => $request->week_end_date,
            'completed_tasks' => $request->completed_tasks,
            'difficulties' => $request->difficulties,
            'next_plan' => $request->next_plan,
            'reference_links' => $request->reference_links,
        ]);

        return redirect()
            ->route('frontend.intern.reports')
            ->with('success', 'Nộp báo cáo thành công.');
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
