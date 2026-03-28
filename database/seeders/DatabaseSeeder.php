<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Grade;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Group::factory()->count(2)->create();
        User::factory()->count(3)->create();
        Subject::factory()->count(2)->create();
        Grade::factory()->count(6)->create();
        
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => User::ROLE_ADMIN,
        ]);
    }
}
