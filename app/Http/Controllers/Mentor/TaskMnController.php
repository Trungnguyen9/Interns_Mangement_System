<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Http\Requests\frontend\CreateTaskRequest;
use App\Http\Requests\frontend\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskMnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mentor = Auth::user()->mentorProfile;
        $interns = $mentor->interns->where('status', 'Đang thực tập');

        $tasks = $mentor->tasks()->with('intern')->get();


        return view('frontend.mentor.tasks.tasks', compact('tasks', 'interns'));
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
    public function store(CreateTaskRequest $request)
    {
        $mentor = Auth::user()->mentorProfile;

        // Kiểm tra intern có thuộc mentor này không
        $intern = $mentor->interns()
            ->where('id', $request->intern_id)
            ->firstOrFail();

        Task::create([

            'mentor_id' => $mentor->id,

            'intern_id' => $intern->id,

            'title' => $request->title,

            'description' => $request->description,

            'priority' => $request->priority,

            'deadline' => $request->deadline,

            'status' => 'Todo',

        ]);

        return redirect()
            ->back()
            ->with('success', 'Giao task thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mentor = Auth::user()->mentorProfile;

        // Chỉ được xem intern thuộc mentor này
        $intern = $mentor->interns()
            ->with('tasks')
            ->findOrFail($id);

        $tasksByStatus = $intern->tasks
            ->sortBy('deadline')
            ->groupBy('status');

        return view('frontend.mentor.tasks.show', compact('intern', 'tasksByStatus'));
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
    public function update(UpdateTaskRequest $request, string $id)
    {
        // dd($id);

        $mentor = Auth::user()->mentorProfile;

        $task = $mentor->tasks()->find($id);

        if (!$task) {
            return back()->withErrors([
                'permission' => 'Task này không thuộc quyền quản lý của bạn.'
            ]);
        }

        $task->title = $request->title;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->mentor_comment = $request->mentor_comment;

        switch ($request->action) {

            case 'doing':
                if ($task->status === 'Review') {
                    $task->status = 'Doing';
                }
                break;

            case 'done':
                if ($task->status === 'Review') {
                    $task->status = 'Done';
                }
                break;

            case 'save':
            default:
                break;
        }

        $task->save();

        return redirect()
            ->back()
            ->with('success', 'Cập nhật task thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
