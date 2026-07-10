<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternMnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Auth::user()->mentorProfile;
        $interns = $data->interns()->with('user');
        $currentInterns = $interns->count();


        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $interns->where(function ($query) use ($search) {
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('email', 'like', "%{$search}%");
                    });
            });
        }

        // Status
        if ($request->filled('status')) {
            $interns->where('status', $request->status);
        }

        $interns = $interns->paginate(5);

        return view('frontend.mentor.interns.index', compact('data', 'interns', 'currentInterns'));
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
        $intern = Auth::user()->mentorProfile->interns()->with('user', 'tasks', 'weeklyReports')->findOrFail($id);

        $tasks = $intern->tasks()->paginate(5);
        $weeklyReports = $intern->weeklyReports()->paginate(5);

        return view('frontend.mentor.interns.detail', compact('intern', 'tasks', 'weeklyReports'));
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
