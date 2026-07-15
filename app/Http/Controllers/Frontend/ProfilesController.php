<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\frontend\updateInternProfile;
use App\Models\Intern_profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $intern = Auth::user()->internProfile()->with(['user', 'mentor.user'])->firstOrFail();

        return view('frontend.intern.profile.profile', compact('intern'));
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
        $intern = Auth::user()->internProfile()->with(['user', 'mentor.user'])->firstOrFail();

        return view('frontend.intern.profile.edit', compact('intern'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateInternProfile $request, string $id)
    {
        $intern = Auth::user()->internProfile()->firstOrFail();


        DB::beginTransaction();

        try {

            $user = $intern->user;

            if (!$user) {
                throw new \Exception('Không tìm thấy User');
            }


            // Cập nhật thông tin user
            $user->update([
                'name' => $request->name,
            ]);

            // Cập nhật thông tin intern profile
            $intern->update([
                'full_name' => $request->full_name,
                'school' => $request->school,
                'academic_year' => $request->academic_year,
                'desired_technology' => $request->desired_technology,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            DB::commit();

            return redirect('internpage/profile')
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
        //
    }
}
