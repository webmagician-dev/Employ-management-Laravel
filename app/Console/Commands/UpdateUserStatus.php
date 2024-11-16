<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\AdminSetting;
use Carbon\Carbon;

class UpdateUserStatus extends Command
{
  // The name and signature of the console command
  protected $signature = 'update:user-status';

  // The console command description
  protected $description = 'Update user status based on latest login timestamp';

  // Execute the console command
  public function handle()
  {
    // Get the current date and time
    $now = Carbon::now();

    $duration = AdminSetting::first();
    // Fetch all users and update their status
    User::all()->each(function ($user) use ($now, $duration) {
      $latestLogin = Carbon::parse($user->latest_login);
      $daysDifference = $latestLogin->diffInDays($now);

      // Update the status field
      if ($daysDifference > (int) $duration->suspend_duration) {
        $user->status = 'suspended';
      } else {
        $user->status = 'active';
      }

      $user->save();
    });

    $this->info('User statuses have been updated successfully.');
  }
}
