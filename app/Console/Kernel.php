<?php

namespace App\Console;

use App\Console\Commands\CheckOfferExpireCommand;
use App\Console\Commands\DeleteOldPdfAttachmentsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CheckOfferExpireCommand::class,
        DeleteOldPdfAttachmentsCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command(CheckOfferExpireCommand::class)->timezone('Asia/Bangkok')->daily()->at('00:01');
        $schedule->command(DeleteOldPdfAttachmentsCommand::class)->timezone('Asia/Bangkok')->daily()->at('10:02');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
