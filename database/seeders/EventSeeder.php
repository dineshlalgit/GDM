<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'name' => 'Team Building Workshop',
                'type' => 'workshop',
                'description' => 'Join us for an exciting team building workshop to improve collaboration and communication skills.',
                'event_datetime' => now()->addDays(7)->setTime(10, 0),
                'location' => 'Conference Room A, Main Building',
            ],
            [
                'name' => 'Monthly All-Hands Meeting',
                'type' => 'meeting',
                'description' => 'Monthly company-wide meeting to discuss updates, achievements, and upcoming projects.',
                'event_datetime' => now()->addDays(3)->setTime(14, 0),
                'location' => 'Grand Hall, Ground Floor',
            ],
            [
                'name' => 'Technical Training Session',
                'type' => 'training',
                'description' => 'Advanced technical training on the latest development tools and methodologies.',
                'event_datetime' => now()->addDays(14)->setTime(9, 0),
                'location' => 'Training Room B, 2nd Floor',
            ],
            [
                'name' => 'Company Anniversary Celebration',
                'type' => 'celebration',
                'description' => 'Celebrate our company\'s anniversary with food, games, and recognition of achievements.',
                'event_datetime' => now()->addDays(21)->setTime(18, 0),
                'location' => 'Outdoor Garden Area',
            ],
            [
                'name' => 'Industry Conference',
                'type' => 'conference',
                'description' => 'Annual industry conference featuring keynote speakers and networking opportunities.',
                'event_datetime' => now()->addDays(30)->setTime(8, 0),
                'location' => 'Convention Center, Downtown',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
