<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        Promotion::insert([
            [
                'title' => 'New Customer Glow Promo',
                'description' => 'Diskon khusus untuk customer baru yang melakukan treatment pertama.',
                'promo_code' => 'NEWGLOW10',
                'discount_percent' => 10,
                'membership_only' => false,
                'minimum_membership_level_id' => null,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonth()->toDateString(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Silver Member Beauty Deal',
                'description' => 'Promo khusus untuk customer dengan minimal membership Silver.',
                'promo_code' => 'SILVER15',
                'discount_percent' => 15,
                'membership_only' => true,
                'minimum_membership_level_id' => 2,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(2)->toDateString(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Gold Exclusive Treatment',
                'description' => 'Promo eksklusif untuk member Gold dan Platinum.',
                'promo_code' => 'GOLD20',
                'discount_percent' => 20,
                'membership_only' => true,
                'minimum_membership_level_id' => 3,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(2)->toDateString(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}