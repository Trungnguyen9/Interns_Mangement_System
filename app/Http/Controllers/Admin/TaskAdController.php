<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern_profiles;
use App\Models\Mentor_profiles;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskAdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mentors = Mentor_profiles::with('user')->get();
        $interns = Intern_profiles::with('user')->get();
        $taskQ = Task::query();
        $stats = [
            'total' => (clone $taskQ)->count(),

            'doing' => (clone $taskQ)
                ->where('status', 'Doing')
                ->count(),

            'review' => (clone $taskQ)
                ->where('status', 'Review')
                ->count(),

            'overdue' => (clone $taskQ)
                ->whereDate('deadline', '<', now())
                ->where('status', '!=', 'Done')
                ->count(),
        ];
        
        $tasks = Task::query()
            ->with([
                'intern.user',
                'intern.mentor.user'
            ]);

        if ($q = request('q')) {
            $tasks->where('title', 'like', "%$q%");
        }

        if ($mentor = request('mentor_id')) {
            $tasks->whereHas('intern', function ($q) use ($mentor) {
                $q->where('mentor_id', $mentor);
            });
        }

        if ($intern = request('intern_id')) {
            $tasks->where('intern_id', $intern);
        }

        if ($status = request('status')) {
            $normalizedStatus = match (strtolower($status)) {
                'todo' => 'Todo',
                'doing' => 'Doing',
                'review' => 'Review',
                'done' => 'Done',
                default => null,
            };

            if ($normalizedStatus) {
                $tasks->where('status', $normalizedStatus);
            }
        }

        if (request()->filled('deadline_from')) {
            $tasks->whereDate('deadline', '>=', request('deadline_from'));
        }

        if (request()->filled('deadline_to')) {
            $tasks->whereDate('deadline', '<=', request('deadline_to'));
        }

        $tasks = $tasks->latest()->paginate(10);


        return view('admin.tasks.tasks', compact('mentors', 'interns', 'tasks', 'stats'));
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
