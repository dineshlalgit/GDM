<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class ClosePastEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:close-past {--dry-run : Show what would be closed without actually closing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically close events that have passed their date and time';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $pastEvents = Event::where('event_datetime', '<', now())
            ->where('status', 'open')
            ->get();

        if ($pastEvents->isEmpty()) {
            $this->info('No past events found to close.');
            return 0;
        }

        $this->info("Found {$pastEvents->count()} past event(s) to close:");

        foreach ($pastEvents as $event) {
            $this->line("- {$event->name} ({$event->event_datetime->format('M d, Y g:i A')})");
        }

        if ($this->option('dry-run')) {
            $this->warn('Dry run mode - no events were actually closed.');
            return 0;
        }

        $closedCount = Event::closePastEvents();
        $this->info("Successfully closed {$closedCount} event(s).");

        return 0;
    }
}
