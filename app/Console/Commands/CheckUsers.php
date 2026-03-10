<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckUsers extends Command
{
    protected $signature = 'check:users';
    protected $description = 'Check users in database';

    public function handle()
    {
        $users = User::all();
        
        $this->info("Total users: " . $users->count());
        
        foreach ($users as $user) {
            $this->info("ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}, Active: " . ($user->is_active ? 'Yes' : 'No'));
        }
        
        $admins = User::where('role', 'admin')->where('is_active', true)->get();
        $this->info("\nActive admin users: " . $admins->count());
        
        return 0;
    }
}
