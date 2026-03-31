<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Employer;
use App\Models\Job;
use App\Models\JobApplication;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@jobboard.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // Categories
        $categories = ['IT', 'Finance', 'Marketing', 'Sales', 'Design', 'Engineering'];
        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => str($cat)->slug(),
            ]);
        }

        // Employer users + employers
        $employerUsers = User::factory(5)->create(['role' => 'employer']);
        $employerUsers->each(function ($user) {
            Employer::create([
                'user_id'             => $user->id,
                'company_name'        => fake()->company(),
                'company_description' => fake()->paragraph(),
                'website'             => fake()->url(),
            ]);
        });

        // Applicant users
        User::factory(20)->create(['role' => 'applicant']);

        // Jobs
        $employers   = Employer::all();
        $categories  = Category::all();

        foreach ($employers as $employer) {
            Job::factory(8)->create([
                'employer_id' => $employer->id,
                'category_id' => $categories->random()->id,
            ]);
        }

        // Applications
        $applicants = User::where('role', 'applicant')->get();
        $jobs       = Job::all();

        $applicants->each(function ($applicant) use ($jobs) {
            $jobs->random(3)->each(function ($job) use ($applicant) {
                JobApplication::create([
                    'user_id'         => $applicant->id,
                    'job_id'          => $job->id,
                    'expected_salary' => fake()->numberBetween(30000, 120000),
                    'status'          => fake()->randomElement(['pending', 'reviewed', 'accepted', 'rejected']),
                ]);
            });
        });
    }
}