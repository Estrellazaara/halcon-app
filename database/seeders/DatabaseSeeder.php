<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles
        $this->call(RoleSeeder::class);

        // Create default admin user
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@halcon.com',
                'password' => Hash::make('password'), // Change this in production
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]);
        }
    }
}
