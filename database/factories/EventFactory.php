<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventTypes = ['meeting', 'workshop', 'training', 'celebration', 'seminar', 'conference', 'other'];

        return [
            'name' => fake()->sentence(3),
            'type' => fake()->randomElement($eventTypes),
            'description' => fake()->paragraph(3),
            'event_datetime' => fake()->dateTimeBetween('now', '+2 months'),
            'location' => fake()->city() . ', ' . fake()->state(),
        ];
    }

    /**
     * Indicate that the event is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_datetime' => fake()->dateTimeBetween('now', '+2 months'),
        ]);
    }

    /**
     * Indicate that the event is past.
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_datetime' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Indicate that the event is open.
     */
    public function open(): static
    {
        return $this;
    }

    /**
     * Indicate that the event is closed.
     */
    public function closed(): static
    {
        return $this;
    }
}
