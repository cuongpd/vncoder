<?php

namespace VnCoder\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class CronjobSchedule extends ConsoleKernel
{
    protected $commands = [];

    protected function schedule(Schedule $schedule)
    {
        if (file_exists(ADMIN_PATH . 'cronjob.php')) {
            require ADMIN_PATH . 'cronjob.php';
        }
    }
}
