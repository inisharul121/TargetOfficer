<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. System Admin
        User::firstOrCreate(
            ['email' => 'admin@targetofficer.com'],
            [
                'name' => 'System Admin',
                'phone' => '01700000001',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'target_exam' => '47th BCS Preliminary',
                'coins' => 1200,
                'daily_streak' => 22,
                'longest_streak' => 31,
                'last_active_date' => now()->toDateString(),
            ]
        );

        // 2. Main Admin Account
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'TargetOfficer Admin',
                'phone' => '01700000099',
                'password' => Hash::make('demo1234'),
                'role' => 'admin',
                'target_exam' => '47th BCS Preliminary',
                'coins' => 500,
                'daily_streak' => 10,
                'longest_streak' => 15,
                'last_active_date' => now()->toDateString(),
            ]
        );

        // 3. Demo Candidate
        User::firstOrCreate(
            ['email' => 'candidate@targetofficer.com'],
            [
                'name' => 'Tanvir Ahmed',
                'phone' => '01800000002',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'target_exam' => '47th BCS Preliminary',
                'coins' => 640,
                'daily_streak' => 9,
                'longest_streak' => 14,
                'last_active_date' => now()->toDateString(),
            ]
        );

        // 4. Question Setter
        User::firstOrCreate(
            ['email' => 'setter@targetofficer.com'],
            [
                'name' => 'Dr. Rakib Hassan',
                'phone' => '01900000003',
                'password' => Hash::make('password123'),
                'role' => 'setter',
                'target_exam' => 'BCS Written',
                'coins' => 850,
                'daily_streak' => 3,
                'longest_streak' => 18,
                'last_active_date' => now()->toDateString(),
            ]
        );

        // 5. Additional Candidates for Leaderboard
        $studentData = [
            ['রফিকুল ইসলাম', 'rafiq@test.com', 350, 15, 22, '46th BCS'],
            ['সুমাইয়া খানম', 'sumaiya@test.com', 720, 7, 12, '47th BCS Preliminary'],
            ['আশরাফুল আলম', 'ashraf@test.com', 480, 4, 8, 'Combined Bank Senior Officer'],
            ['ফারহানা হক', 'farhana@test.com', 910, 19, 25, '47th BCS Preliminary'],
            ['মেহরাব হোসেন', 'mehrab@test.com', 290, 2, 5, 'Bank Officer (General)'],
        ];

        foreach ($studentData as $s) {
            User::firstOrCreate(
                ['email' => $s[1]],
                [
                    'name' => $s[0],
                    'password' => Hash::make('password123'),
                    'role' => 'student',
                    'coins' => $s[2],
                    'daily_streak' => $s[3],
                    'longest_streak' => $s[4],
                    'target_exam' => $s[5],
                    'last_active_date' => now()->toDateString(),
                ]
            );
        }
    }
}
