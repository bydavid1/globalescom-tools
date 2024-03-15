<?php

namespace App\Jobs;

use App\Models\Answer;
use App\Models\AnswerBatch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
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
        $today = Carbon::today()->toDateString();

        $answers = Answer::whereHas('input', function ($query) {
            $query->where('slug', 'BZG_RESPONSABLES');
        })
        ->whereHas('batch', function ($query) use ($today) {
            $query->whereHas('answers', function ($query) use ($today) {
                $query->whereRelation('input', 'slug', 'BZG_TIEMPO')
                      ->whereDate('body', '>', $today);
            });
        })
        ->get();

        /**
         * @var \Illuminate\Support\Collection<User>
         */
        $users = $answers->map(function ($answer) {
            $answerUsers = User::whereIn('id', json_decode($answer->body))->get();

            return $answerUsers;
        })->flatten()->unique('id');

        $devices = $users->map(function (User $user) {
            return $user->device_id;
        })->flatten();

        // dd($devices->toArray());


        Larafirebase::withTitle('BizigTool')
                    ->withBody('Recuerda que tienes tareas pendientes en BizigTool')
                    ->sendNotification($devices->toArray());
    }
}
