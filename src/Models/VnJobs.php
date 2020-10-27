<?php
namespace VnCoder\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class VnJobs implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
}
