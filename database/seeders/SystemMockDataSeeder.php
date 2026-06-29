<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Mentor_profiles;
use App\Models\Intern_profiles;
use App\Models\Task;
use App\Models\Weekly_report;

class SystemMockDataSeeder extends Seeder
{
    public function run(): void
    {


        /*
        |--------------------------------------------------------------------------
        | Create Mentors
        |--------------------------------------------------------------------------
        */

        $mentors = [];


        for ($i = 1; $i <= 4; $i++) {


            $user = User::create([

                'name' => "mentor$i",

                'email' => "mentor$i@gmail.com",

                'password' => Hash::make('password'),

                'id_role' => 2,

                'status' => 'active'

            ]);



            $mentor = Mentor_profiles::create([


                'user_id' => $user->id,


                'full_name' => "Mentor $i",


                'department' => 'Software Development',


                'position' => 'Senior Developer',


                'max_interns' => 3


            ]);



            $mentors[] = $mentor;
        }





        /*
        |--------------------------------------------------------------------------
        | Create Interns
        |--------------------------------------------------------------------------
        */


        for ($i = 1; $i <= 12; $i++) {



            // mỗi mentor quản lý 3 intern

            $mentorIndex = intdiv($i - 1, 3);

            $mentor = $mentors[$mentorIndex];


            $user = User::create([


                'name' => "intern$i",


                'email' => "intern$i@gmail.com",


                'password' => Hash::make('password'),


                'id_role' => 3,


                'status' => 'active'


            ]);




            $intern = Intern_profiles::create([


                'user_id' => $user->id,


                'mentor_id' => $mentor->id,


                'full_name' => "Intern $i",


                'school' => 'University',


                'academic_year' => '2026',


                'desired_technology' => 'Laravel ReactJS',


                'start_date' => Carbon::now(),


                'end_date' => Carbon::now()
                    ->addMonths(3),


                'status' => 'Đang thực tập'


            ]);






            /*
            |--------------------------------------------------------------------------
            | Create Tasks
            |--------------------------------------------------------------------------
            */


            for ($j = 1; $j <= 3; $j++) {


                Task::create([


                    'title' =>
                    "Task $j - Intern $i",


                    'description' =>
                    "Complete assigned task $j",


                    'deadline' =>
                    Carbon::now()
                        ->addDays($j * 7),



                    'priority' =>
                    $j == 1
                        ? 'High'
                        : 'Medium',



                    'status' =>
                    'Doing',



                    'mentor_id' =>
                    $mentor->id,



                    'intern_id' =>
                    $intern->id,


                    'mentor_comment' =>
                    null


                ]);
            }






            /*
            |--------------------------------------------------------------------------
            | Create Weekly Reports
            |--------------------------------------------------------------------------
            */


            for ($week = 1; $week <= 2; $week++) {



                Weekly_report::create([


                    'intern_id' =>
                    $intern->id,



                    'week_start_date' =>
                    Carbon::now()
                        ->subWeeks($week)
                        ->startOfWeek(),



                    'week_end_date' =>
                    Carbon::now()
                        ->subWeeks($week)
                        ->endOfWeek(),




                    'completed_tasks' =>
                    "Completed tasks in week $week",




                    'difficulties' =>
                    "No difficulties",




                    'next_plan' =>
                    "Continue improving assigned features",




                    'reference_links' =>
                    "https://github.com/example",



                    // mentor_comment nullable

                ]);
            }
        }
    }
}
