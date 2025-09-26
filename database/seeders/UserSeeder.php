<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(3)->state(['role' => 'admin'])->create();
        User::factory()->count(3)->state(['role' => 'manager'])->create();
        User::factory()->count(5)->state(['role' => 'user'])->create();
    }
}
