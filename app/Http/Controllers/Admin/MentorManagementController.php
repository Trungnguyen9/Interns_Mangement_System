<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\addMentorRequest;
use App\Http\Requests\admin\updateMentorRequest;
use App\Models\Mentor_profiles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MentorManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Mentor_profiles::withCount('interns');

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
        if ($request->filled('status')) {

            if ($request->status === 'Full') {

                $query->havingRaw('interns_count >= max_interns');
            }

            if ($request->status === 'Available') {

                $query->havingRaw('interns_count < max_interns');
            }
        }


        $data = $query
            ->with('user', 'interns', 'tasks')
            ->paginate(5);


        $internCount = $data->pluck('interns_count', 'id');


        return view('admin.mentor.index', compact('data', 'internCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mentor.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(addMentorRequest $request)
    {
        DB::beginTransaction();


        try {


            // 1. Tạo user trước
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_role' => 2,
                'status' => 'active'
            ]);



            // 2. Tạo mentor profile
            Mentor_profiles::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'department' => $request->department,
                'position' => $request->position,
                'max_interns' => $request->max_interns
            ]);



            DB::commit();
            return redirect('adminpage/mentor')
                ->with(
                    'success',
                    'Thêm mentor thành công'
                );
        } catch (\Exception $e) {
            DB::rollBack();

            // Ghi lại lỗi vào file log (storage/logs/laravel.log) để tiện mở lên xem khi code bị lỗi
            Log::error('Lỗi khi thêm Mentor: ' . $e->getMessage());

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
        $mentor = Mentor_profiles::with('user', 'interns', 'tasks')->findOrFail($id);
        return view('admin.mentor.show', compact('mentor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mentor = Mentor_profiles::with('user', 'interns', 'tasks')->findOrFail($id);
        return view('admin.mentor.edit', compact('mentor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateMentorRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $mentor = Mentor_profiles::findOrFail($id);
            $user = $mentor->user;

            if (!$user) {
                throw new \Exception('Không tìm thấy User');
            }


            // Cập nhật thông tin user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Cập nhật thông tin mentor profile
            $mentor->update([
                'full_name' => $request->full_name,
                'department' => $request->department,
                'position' => $request->position,
                'max_interns' => $request->max_interns
            ]);

            DB::commit();

            return redirect('adminpage/mentor')
                ->with('success', 'Cập nhật mentor thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi cập nhật Mentor: ' . $e->getMessage());
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
