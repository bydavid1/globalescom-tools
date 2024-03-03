<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kutia\Larafirebase\Facades\Larafirebase;

class BizigToolReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Larafirebase::withTitle('Test Title')
        ->withBody('Test body')
        ->sendNotification(
            ["d2LgDJesk-1GP9JxJLUpSG:APA91bEfXKcO3IndmSq9UkMAlzBTBV65noB8-hMDpCkZicezL7mYaEbjRfiKPRuVcze_AM_mv9ECl4gd15y8lK2E13d_e7LmRhdtKn19SHYNCMfhqp9rmA2uwb01_b1tX4X6uYu1awt4"]
        );
    }
}
