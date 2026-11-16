<?php

namespace Database\Seeders;

use App\Models\Treatment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TreatmentSeeder extends Seeder
{
    public function run(): void
    {
        $treatments = [
            [
                'treatment_name' => 'Facial Glow Treatment',
                'category' => 'Facial',
                'short_description' => 'Perawatan wajah untuk membantu kulit tampak lebih bersih dan segar.',
                'description' => 'Facial Glow Treatment dirancang untuk membersihkan wajah, membantu mengangkat kotoran, dan membuat kulit terasa lebih segar.',
                'price' => 250000,
                'duration_minutes' => 60,
                'image' => 'assets/images/beauty1.jpeg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'treatment_name' => 'Acne Care Treatment',
                'category' => 'Facial',
                'short_description' => 'Perawatan untuk kulit berjerawat dengan pendekatan pembersihan mendalam.',
                'description' => 'Acne Care Treatment membantu membersihkan kulit wajah dan merawat kulit berjerawat agar tampak lebih terkontrol.',
                'price' => 300000,
                'duration_minutes' => 75,
                'image' => 'assets/images/beauty2.jpeg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'treatment_name' => 'Brightening Skin Therapy',
                'category' => 'Skin Care',
                'short_description' => 'Perawatan untuk membantu kulit tampak lebih cerah dan merata.',
                'description' => 'Brightening Skin Therapy difokuskan pada perawatan kulit agar tampak lebih cerah, segar, dan merata.',
                'price' => 350000,
                'duration_minutes' => 90,
                'image' => 'assets/images/beauty3.jpeg',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'treatment_name' => 'Hydrating Facial',
                'category' => 'Facial',
                'short_description' => 'Perawatan hidrasi untuk kulit kering dan kusam.',
                'description' => 'Hydrating Facial membantu menjaga kelembapan kulit dan membuat wajah terasa lebih lembut.',
                'price' => 280000,
                'duration_minutes' => 60,
                'image' => 'assets/images/beauty1.jpeg',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'treatment_name' => 'Anti Aging Treatment',
                'category' => 'Skin Care',
                'short_description' => 'Perawatan untuk membantu kulit tampak lebih kencang dan terawat.',
                'description' => 'Anti Aging Treatment berfokus pada perawatan kulit dewasa agar tampak lebih segar dan terawat.',
                'price' => 450000,
                'duration_minutes' => 90,
                'image' => 'assets/images/beauty2.jpeg',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'treatment_name' => 'Body Spa Relaxation',
                'category' => 'Body Treatment',
                'short_description' => 'Perawatan relaksasi tubuh untuk membantu tubuh terasa lebih rileks.',
                'description' => 'Body Spa Relaxation memberikan pengalaman perawatan tubuh yang menenangkan dan membantu relaksasi.',
                'price' => 400000,
                'duration_minutes' => 120,
                'image' => 'assets/images/beauty3.jpeg',
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($treatments as $treatment) {
            Treatment::updateOrCreate(
                ['slug' => Str::slug($treatment['treatment_name'])],
                array_merge($treatment, [
                    'slug' => Str::slug($treatment['treatment_name']),
                    'created_by' => 1,
                ])
            );
        }
    }
}