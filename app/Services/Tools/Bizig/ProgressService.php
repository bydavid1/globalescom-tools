<?php
namespace App\Services\Tools\Bizig;

class ProgressService
{
    public function calculateProgressFromAnswerBatches($answerBatches)
    {
        if (count($answerBatches) === 0) {
            return 0;
        }

        $total = 0;

        foreach ($answerBatches as $batch) {
            $progress = $batch->answers->where('input_id', 14)->first();
            $total += $progress->body;
        }

        return $total / count($answerBatches);
    }
}
