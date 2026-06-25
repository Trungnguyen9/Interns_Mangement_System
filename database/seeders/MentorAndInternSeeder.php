<?php

namespace Database\Seeders;

use App\Models\Intern_profiles;
use App\Models\Mentor_profiles;
use App\Models\User;
use Illuminate\Database\Seeder;

class MentorAndInternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mentorUser = User::firstWhere('email', 'mentor@example.com');
        $internUser1 = User::firstWhere('email', 'intern@example.com');

        if (! $mentorUser || ! $internUser1) {
            return;
        }

        $mentor = Mentor_profiles::create([
            'user_id' => $mentorUser->id,
            'full_name' => 'Nguyễn Văn B',
            'department' => 'Software Development',
            'position' => 'Senior Mentor',
            'max_interns' => 3,
        ]);

        Intern_profiles::create([
            'user_id' => $internUser1->id,
            'full_name' => 'Nguyễn Văn A',
            'school' => 'Đại học Bách Khoa',
            'academic_year' => 'Năm 3',
            'desired_technology' => 'Laravel, Vue.js',
            'start_date' => now()->subWeeks(2)->toDateString(),
            'end_date' => now()->addWeeks(10)->toDateString(),
            'status' => 'Đang thực tập',
            'mentor_id' => $mentor->id,
        ]);
    }
}
