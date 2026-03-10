<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdateUserRole extends Command
{
    protected $signature = 'user:update-role {userId} {role}';
    protected $description = 'Update user role';

    public function handle()
    {
        $userId = $this->argument('userId');
        $role = $this->argument('role');
        
        $user = User::find($userId);
        
        if (!$user) {
            $this->error("User not found");
            return 1;
        }
        
        $user->role = $role;
        $user->save();
        
        $this->info("Updated user {$user->name} (ID: {$user->id}) role to: {$role}");
        
        return 0;
    }
}
