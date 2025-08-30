<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\EventRegistration;
use Illuminate\Database\Seeder;

class EventRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $events = Event::all();

        if ($users->isEmpty() || $events->isEmpty()) {
            $this->command->warn('No users or events found. Please seed users and events first.');
            return;
        }

        // Create some sample registrations
        foreach ($events as $event) {
            // Register 2-3 random users for each event
            $randomUsers = $users->random(rand(2, 3));

            foreach ($randomUsers as $user) {
                EventRegistration::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                    'registered_at' => now()->subDays(rand(1, 7)),
                    'notes' => 'Sample registration for testing purposes.',
                ]);
            }
        }

        $this->command->info('Event registrations seeded successfully!');
    }
}
