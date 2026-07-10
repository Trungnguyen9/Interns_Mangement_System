<?php

namespace Database\Seeders;

use App\Models\Intern_profiles;
use App\Models\Weekly_report;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WeeklyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interns = Intern_profiles::all();

        if ($interns->isEmpty()) {
            return;
        }

        $weekStart = Carbon::now()->startOfWeek()->subWeek();
        $weekEnd = Carbon::now()->startOfWeek()->subDay();

        Weekly_report::create([
            'intern_id' => $interns->first()->id,
            'week_start_date' => $weekStart->toDateString(),
            'week_end_date' => $weekEnd->toDateString(),
            'completed_tasks' => 'Installed project dependencies, configured the database, and created the initial intern profile layout.',
            'difficulties' => 'Needed more time to understand the existing project structure and blade templates.',
            'next_plan' => 'Finish the intern profile edit form and connect it to the backend.',
            'reference_links' => 'https://laravel.com/docs/10.x/eloquent, https://vuejs.org/',
            'status' => 'reviewed',
            'mentor_comment' => 'Keep going. Pay attention to validation and user experience.',
        ]);

        if ($interns->count() > 1) {
            Weekly_report::create([
                'intern_id' => $interns->skip(1)->first()->id,
                'week_start_date' => $weekStart->toDateString(),
                'week_end_date' => $weekEnd->toDateString(),
                'completed_tasks' => 'Reviewed the task management flow and started API endpoint implementation.',
                'difficulties' => 'Encountered some foreign key issues while linking intern and mentor records.',
                'next_plan' => 'Complete the task creation endpoint and add unit tests for API routes.',
                'reference_links' => 'https://laravel.com/docs/10.x/eloquent-relationships',
                'status' => 'pending',
                'mentor_comment' => null,
            ]);
        }
    }
}
