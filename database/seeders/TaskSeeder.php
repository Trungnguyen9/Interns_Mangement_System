<?php

namespace Database\Seeders;

use App\Models\Intern_profiles;
use App\Models\Mentor_profiles;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mentorUser = User::firstWhere('email', 'mentor@example.com');
        $mentor = null;

        if ($mentorUser) {
            $mentor = Mentor_profiles::firstWhere('user_id', $mentorUser->id);
        }

        $interns = Intern_profiles::all();

        if (! $mentor || $interns->isEmpty()) {
            return;
        }

        Task::create([
            'title' => 'Setup Laravel development environment',
            'description' => 'Install dependencies, configure database, and prepare the local Laravel environment for the internship project.',
            'deadline' => Carbon::now()->addDays(7)->toDateString(),
            'priority' => 'High',
            'status' => 'Done',
            'mentor_id' => $mentor->id,
            'intern_id' => $interns->first()->id,
            'mentor_comment' => 'Good progress. Continue with the next feature.',
        ]);

        Task::create([
            'title' => 'Build intern profile page',
            'description' => 'Create a profile page that displays intern details, mentor assignment, and progress status.',
            'deadline' => Carbon::now()->addDays(14)->toDateString(),
            'priority' => 'Medium',
            'status' => 'Doing',
            'mentor_id' => $mentor->id,
            'intern_id' => $interns->first()->id,
            'mentor_comment' => 'Remember to follow the UI guidelines and validate inputs.',
        ]);

        if ($interns->count() > 1) {
            $secondIntern = $interns->skip(1)->first();

            Task::create([
                'title' => 'Implement task management API',
                'description' => 'Develop endpoints for creating, updating, and listing tasks assigned to interns.',
                'deadline' => Carbon::now()->addDays(10)->toDateString(),
                'priority' => 'High',
                'status' => 'Review',
                'mentor_id' => $mentor->id,
                'intern_id' => $secondIntern->id,
                'mentor_comment' => 'Need a few fixes before merging.',
            ]);

            Task::create([
                'title' => 'Write weekly progress report',
                'description' => 'Gather accomplishments and blockers and prepare the weekly report for mentor review.',
                'deadline' => Carbon::now()->addDays(3)->toDateString(),
                'priority' => 'Low',
                'status' => 'Todo',
                'mentor_id' => $mentor->id,
                'intern_id' => $secondIntern->id,
                'mentor_comment' => null,
            ]);
        }
    }
}
