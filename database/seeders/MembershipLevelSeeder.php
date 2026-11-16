<?php

namespace Database\Seeders;

use App\Models\MembershipLevel;
use Illuminate\Database\Seeder;

class MembershipLevelSeeder extends Seeder
{
    public function run(): void
    {
        MembershipLevel::insert([
            [
                'level_name' => 'Bronze',
                'min_points' => 0,
                'benefits' => 'Akses membership dasar dan informasi promosi reguler.',
                'created_at' => now(),
            ],
            [
                'level_name' => 'Silver',
                'min_points' => 500,
                'benefits' => 'Akses promosi khusus member Silver dan prioritas informasi promo.',
                'created_at' => now(),
            ],
            [
                'level_name' => 'Gold',
                'min_points' => 1500,
                'benefits' => 'Akses promosi eksklusif Gold dan prioritas treatment tertentu.',
                'created_at' => now(),
            ],
            [
                'level_name' => 'Platinum',
                'min_points' => 3000,
                'benefits' => 'Akses benefit premium, promo eksklusif, dan prioritas layanan.',
                'created_at' => now(),
            ],
        ]);
    }
}