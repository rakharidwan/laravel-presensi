<?php

namespace App\Console;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
        $schedule->call(function () {
            $tanggal = Carbon::now()->addDays(30)->format('Y-m-d');
            $absensi = Absensi::whereDate('created_at',$tanggal)->select('foto')->get();
    
            foreach ($absensi as $a) {
                Storage::disk('public')->delete($a->foto);
            }

            Absensi::whereDate('created_at',$tanggal)->delete();
        })->daily();
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
