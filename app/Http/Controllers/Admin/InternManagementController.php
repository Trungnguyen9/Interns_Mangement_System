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
    public function index()
    {
        // $data = User::with('internProfile', 'role', 'mentorProfile')->get();
        $data = Intern_profiles::with('user', 'mentor', 'tasks', 'weeklyReports')->get();
        return view('admin.intern.index', compact('data'));
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
                    'Mentor này đã đạt số lượng intern tối đa.'
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
                    'Thêm intern thành công'
                );
        } catch (\Exception $e) {
            DB::rollBack();

            // Ghi lại lỗi vào file log (storage/logs/laravel.log) để tiện mở lên xem khi code bị lỗi
            Log::error('Lỗi khi thêm Intern: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra trong quá trình xử lý. Vui lòng thử lại.');
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
                    ->with('error', 'Mentor này đã đạt số lượng intern tối đa.');
            }
        }
        DB::beginTransaction();



        try {

            $user = $intern->user;

            if (!$user) {
                throw new \Exception('Không tìm thấy User');
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
                ->with('success', 'Cập nhật intern thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi cập nhật Intern: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra trong quá trình xử lý. Vui lòng thử lại.');
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
