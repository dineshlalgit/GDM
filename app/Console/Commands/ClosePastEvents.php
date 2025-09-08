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
    protected $signature = 'events:close-past {--dry-run : (Deprecated) No-op since status is computed}';

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
        $this->info('Event status is now computed based on date/time; no action needed.');
        return self::SUCCESS;
    }
}
