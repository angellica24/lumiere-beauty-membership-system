<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminConfig = config('lumiere.admin', []);
        $email = $adminConfig['email'] ?? null;
        $password = $adminConfig['password'] ?? null;

        if (blank($email) || blank($password)) {
            $this->command?->warn(
                'Admin user seeding skipped. Set LUMIERE_ADMIN_EMAIL and LUMIERE_ADMIN_PASSWORD in your local .env file.'
            );

            return;
        }

        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $adminConfig['name'] ?? 'Lumiere Admin',
                'phone' => $adminConfig['phone'] ?? null,
                'password' => Hash::make($password),
                'role' => 'admin',
                'membership_level_id' => 1,
                'total_points' => 0,
                'is_active' => true,
            ]
        );

        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $admin->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }
}
