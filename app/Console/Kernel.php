<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  protected $commands = [\App\Console\Commands\UpdateUserStatus::class];

  protected function schedule(Schedule $schedule): void
  {
    $schedule->command('update:user-status')->dailyAt('07:05');
  }

  protected function commands(): void
  {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }
}
