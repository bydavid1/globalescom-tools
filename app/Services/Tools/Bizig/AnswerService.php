<?php
namespace App\Services\Tools\Bizig;

use App\Models\Answer;
use App\Models\AnswerBatch;
use App\Models\Form;
use App\Models\Section;
use Illuminate\Support\Collection;

class AnswerService
{

    public function saveBatch(array $answers, int $formId, int $sectionId, int $userId) : AnswerBatch
    {
        $form = Form::find($formId);
        $section = Section::find($sectionId);

        $answerBatch = new AnswerBatch();
        $answerBatch->form()->associate($form);
        $answerBatch->section()->associate($section);
        $answerBatch->user_id = $userId;

        $answerBatch->save();

        $answers = collect($answers)->map(function ($answer) {
            return new Answer([
                'input_id' => $answer['input_id'],
                'body' => $answer['body']
            ]);
        });

        $answerBatch->answers()->saveMany($answers);

        return $answerBatch;
    }

    public function updateBatch(array $answers) : void
    {
        foreach ($answers as $answer) {
            $answerModel = Answer::find($answer['id']);
            $answerModel->update([
                'body' => $answer['body']
            ]);
        }
    }

    public function getAnswers(int $sectionId, int $userId) : Collection
    {
        $answers = AnswerBatch::where('section_id', $sectionId)
            ->where('user_id', $userId)
            ->with('answers')
            ->get();

        return $answers;
    }
}
