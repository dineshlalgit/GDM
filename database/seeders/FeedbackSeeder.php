<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        // Create some sample feedback
        Feedback::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'rating' => 5,
            'message' => 'Excellent service! The platform is very user-friendly and the staff is very helpful. Highly recommended!',
            'status' => 'active',
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ]);

        Feedback::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'rating' => 4,
            'message' => 'Great experience overall. The booking system works well, though it could be a bit faster. Staff is friendly and professional.',
            'status' => 'active',
            'ip_address' => '192.168.1.2',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
        ]);

        Feedback::create([
            'name' => 'Mike Johnson',
            'email' => 'mike.johnson@example.com',
            'rating' => 3,
            'message' => 'The service is okay, but there are some areas that could be improved. The interface could be more intuitive.',
            'status' => 'active',
            'ip_address' => '192.168.1.3',
            'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36',
        ]);

        // Create additional random feedback using factory
        Feedback::factory(10)->create();
    }
}
