<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Student::where('registration_number', '2023/0001')->exists()) {
            Student::create([
                'registration_number' => '2023/0001',
                'name' => 'Erick Peter',
                'password' => Hash::make('password123'),
                'faculty_id' => 1,
                'course_id' => 1,
                'registration_year' => 2023,
            ]);
        }

        if (!Student::where('registration_number', '2024/0002')->exists()) {
    Student::create([
        'registration_number' => '2024/0002',
        'name' => 'Grace John',
        'password' => Hash::make('passwrd123'),
        'faculty_id' => 1,
        'course_id' => 1,
        'registration_year' => 2024,
        ]);
    }

        if (!Student::where('registration_number', '2024/0003')->exists()) {
    Student::create([
        'registration_number' => '2024/0003',
        'name' => 'Sarah Sulley',
        'password' => Hash::make('passwrd123'),
        'faculty_id' => 1,
        'course_id' => 1,
        'registration_year' => 2024,
        ]);
    }
    }
}
