<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@law.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create attorney user
        User::create([
            'name' => 'Attorney Garcia',
            'email' => 'attorney@law.com',
            'password' => Hash::make('password'),
            'role' => 'attorney',
        ]);

        // Create staff user
        User::create([
            'name' => 'Staff Member',
            'email' => 'staff@law.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        $this->command->info('✓ Default users created successfully!');
        $this->command->info('  Admin: admin@law.com / password');
        $this->command->info('  Attorney: attorney@law.com / password');
        $this->command->info('  Staff: staff@law.com / password');
    }
}
