<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'app:create-admin 
                            {--name=Admin : Nama admin} 
                            {--email=admin@example.com : Email admin} 
                            {--password=password : Password admin}';

    protected $description = 'Membuat akun admin baru atau reset password admin yang ada';

    public function handle()
    {
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');

        $admin = User::where('email', $email)->first();

        if ($admin) {
            $admin->update([
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'admin',
                'kelas' => 'XII',
                'jurusan' => 'IPA',
            ]);
            $this->info("✓ Akun admin diperbarui!");
        } else {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'kelas' => 'XII',
                'jurusan' => 'IPA',
            ]);
            $this->info("✓ Akun admin baru berhasil dibuat!");
        }

        $this->line("Email: <fg=green>{$email}</>");
        $this->line("Password: <fg=green>{$password}</>");
        $this->line("Role: <fg=green>admin</>");
        $this->line("Kelas: <fg=green>XII</>");
        $this->line("Jurusan: <fg=green>IPA</>");
    }
}
