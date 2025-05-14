<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('queue:work --tries=3 --timeout=900 --stop-when-empty')->everyMinute(); // define worker

        $schedule->command('queue:work --tries=3 --timeout=900 --stop-when-empty --queue=periority_1')->everyMinute();

        $schedule->command('queue:work --tries=3 --timeout=900 --stop-when-empty --queue=periority_2')->at('00:00');

        $schedule->command('check-ended-subscriptions')->dailyAt('00:00')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
