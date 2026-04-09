<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class VerifyAdminAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:verify';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Verify admin account and display credentials';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->error('Admin account not found!');
            return 1;
        }

        $this->info('Admin Account Found:');
        $this->line('Name: ' . $admin->name);
        $this->line('Email: ' . $admin->email);
        $this->line('Role: ' . $admin->role);
        $this->line('Kelas: ' . $admin->kelas);
        $this->line('Jurusan: ' . $admin->jurusan);

        // Test password
        if (Hash::check('password123', $admin->password)) {
            $this->info('✓ Password verified: password123');
        } else {
            $this->warn('✗ Password does not match: password123');
            $this->warn('Updating password to: password123');
            $admin->update(['password' => Hash::make('password123')]);
            $this->info('✓ Password updated successfully');
        }

        return 0;
    }
}
