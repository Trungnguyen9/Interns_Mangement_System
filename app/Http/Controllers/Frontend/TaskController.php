<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $intern = Auth::user()->internProfile;

        $tasks = $intern->tasks();

        // Search
        if ($request->filled('search')) {
            $tasks->where('title', 'like', '%' . $request->search . '%');
        }

        // Status
        if ($request->filled('status')) {

            if ($request->status === 'Overdue') {

                $tasks->whereDate('deadline', '<', now())
                    ->whereNotIn('status', ['Done', 'Review']);
            } else {

                $tasks->where('status', $request->status);
            }
        }

        // Priority
        if ($request->filled('priority')) {
            $tasks->where('priority', $request->priority);
        }

        $tasks = $tasks->paginate(5);

        $stats = [
            [
                'title' => 'Total Tasks',
                'value' => $intern->tasks()->count(),
                'icon'  => 'mdi mdi-format-list-bulleted',
                'color' => 'info',
            ],

            [
                'title' => 'Pending Tasks',
                'value' => $intern->tasks()->where('status', 'Review')->count(),
                'icon'  => 'mdi mdi-timer-sand',
                'color' => 'warning',
            ],

            [
                'title' => 'Completed Tasks',
                'value' => $intern->tasks()->where('status', 'Done')->count(),
                'icon'  => 'mdi mdi-check-circle-outline',
                'color' => 'success',
            ],

            [
                'title' => 'Overdue Tasks',
                'value' => $intern->tasks()
                    ->whereDate('deadline', '<', now())
                    ->whereNotIn('status', ['Done', 'Review'])
                    ->count(),
                'icon'  => 'mdi mdi-alert-circle-outline',
                'color' => 'danger',
            ]
        ];

        return view('frontend_fn.intern.tasks.tasks', compact('tasks', 'intern', 'stats'));
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
        $intern = Auth::user()->internProfile;

        $task = $intern->tasks()
            ->with(['mentor.user'])
            ->where('id', $id)
            ->firstOrFail();

        return view('frontend_fn.intern.tasks.task-detail', compact('task'))->render();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:Todo,Doing,Review',
        ]);

        $intern = Auth::user()->internProfile;

        $task = $intern->tasks()
            ->where('id', $id)
            ->firstOrFail();

        // nếu task đã Done, không ai qua route intern sửa được nữa
        if ($task->status === 'Done') {
            return response()->json([
                'success' => false,
                'message' => 'This task is completed; only the mentor can edit it.',
            ], 403);
        }

        $task->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'status'  => $task->status,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
