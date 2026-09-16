<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\addInternRequest;
use App\Http\Requests\admin\updateInternRequest;
use App\Models\Intern_profiles;
use App\Models\Mentor_profiles;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class InternManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Intern_profiles::query();
        // search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($subQuery) use ($request) {
                        $subQuery->where('email', 'like', '%' . $request->search . '%');
                    });
            });
        }
        // filter by status 
        if ($request->filled('status') && in_array($request->status, ['Ongoing Interns', 'Completed Interns'])) {
            $query->where('status', $request->status);
        }
        // filter by mentor
        if ($request->filled('mentor_id')) {
            $query->where('mentor_id', $request->mentor_id);
        }

        $mentors = Mentor_profiles::with('user')->get();
        $data = $query->with('user', 'mentor', 'tasks', 'weeklyReports')->paginate(5);
        return view('admin.intern.index', compact('data', 'mentors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mentors = Mentor_profiles::all();
        return view('admin.intern.add', compact('mentors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(addInternRequest $request)
    {
        $mentor = Mentor_profiles::withCount('interns')
            ->findOrFail($request->mentor_id);

        if ($mentor->interns_count >= $mentor->max_interns) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'This mentor has reached the maximum number of interns.'
                );
        }

        DB::beginTransaction();

        try {
            // 1. Tạo user trước
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_role' => 3,
                'status' => 'active'
            ]);


            // 2. Tạo intern profile
            Intern_profiles::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'school' => $request->school,
                'academic_year' => $request->academic_year,
                'desired_technology' => $request->desired_technology,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'mentor_id' => $request->mentor_id,
                'status' => $request->status
            ]);


            DB::commit();
            return redirect('adminpage/intern')
                ->with(
                    'success',
                    'Intern added successfully.'
                );
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error to storage/logs/laravel.log so it can be reviewed during debugging.
            Log::error('Error while adding Intern: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'An error occurred while processing. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $intern = Intern_profiles::with('user', 'mentor', 'tasks', 'weeklyReports')->findOrFail($id);
        return view('admin.intern.show', compact('intern'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $intern = Intern_profiles::with([
            'user',
            'mentor.user'
        ])->findOrFail($id);
        $mentors = Mentor_profiles::with('user')->get();
        return view('admin.intern.edit', compact('intern', 'mentors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateInternRequest $request, string $id)
    {
        $intern = Intern_profiles::findOrFail($id);

        if ($request->mentor_id != $intern->mentor_id) {
            $mentor = Mentor_profiles::withCount('interns')
                ->findOrFail($request->mentor_id);

            if ($mentor->interns_count >= $mentor->max_interns) {
                return back()
                    ->withInput()
                    ->with('error', 'This mentor has reached the maximum number of interns.');
            }
        }
        DB::beginTransaction();



        try {

            $user = $intern->user;

            if (!$user) {
                throw new \Exception('User not found.');
            }


            // Cập nhật thông tin user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Cập nhật thông tin intern profile
            $intern->update([
                'full_name' => $request->full_name,
                'school' => $request->school,
                'academic_year' => $request->academic_year,
                'desired_technology' => $request->desired_technology,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'mentor_id' => $request->mentor_id,
                'status' => $request->status
            ]);

            DB::commit();

            return redirect('adminpage/intern')
                ->with('success', 'Intern updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while updating Intern: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'An error occurred while processing. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
