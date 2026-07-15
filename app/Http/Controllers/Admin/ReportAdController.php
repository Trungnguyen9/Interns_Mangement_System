<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern_profiles;
use App\Models\Mentor_profiles;
use App\Models\Weekly_report;
use Illuminate\Http\Request;

class ReportAdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mentors = Mentor_profiles::with('user')->get();
        $interns = Intern_profiles::with('user')->get();

        $reports = Weekly_report::with([
            'intern.user',
            'intern.mentor.user',
        ])
            ->when($request->filled('mentor_id'), function ($query) use ($request) {
                $query->whereHas('intern', function ($q) use ($request) {
                    $q->where('mentor_id', $request->mentor_id);
                });
            })
            ->when($request->filled('intern_id'), function ($query) use ($request) {
                $query->where('intern_id', $request->intern_id);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest('created_at')
            ->paginate(10)
            ->appends($request->query());

        $stats = [
            'total'     => Weekly_report::count(),
            'this_week' => Weekly_report::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count(),
            'pending'   => Weekly_report::where('status', 'pending')->count(),
            'reviewed'  => Weekly_report::where('status', 'reviewed')->count(),
        ];

        return view(
            'admin.reports.reports',
            compact('reports', 'mentors', 'interns', 'stats')
        );
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
        $report = Weekly_report::with([
            'intern.user',
            'intern.mentor.user',
        ])->findOrFail($id);

        return view('admin.reports.detail', compact('report'));
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
