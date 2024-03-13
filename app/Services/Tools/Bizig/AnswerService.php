<?php
namespace App\Services\Tools\Bizig;

use App\Models\Answer;
use App\Models\AnswerBatch;
use App\Models\Company;
use App\Models\Form;
use App\Models\Section;
use Illuminate\Support\Collection;

class AnswerService
{

    public function saveBatch(array $answers, int $formId, int $sectionId, int $userId, int $company_id) : AnswerBatch
    {
        $form = Form::findOrFail($formId);
        $section = Section::findOrFail($sectionId);
        $company = Company::findOrFail($company_id);

        $answerBatch = new AnswerBatch();
        $answerBatch->form()->associate($form);
        $answerBatch->section()->associate($section);
        $answerBatch->company()->associate($company);
        $answerBatch->user_id = $userId;

        $answerBatch->save();

        $answers = collect($answers)->map(function ($answer) {
            return new Answer([
                'input_id' => $answer['input_id'],
                'body' => $answer['body'] ?? ''
            ]);
        });

        $answerBatch->answers()->saveMany($answers);

        return $answerBatch;
    }

    public function updateBatch(array $answers) : void
    {
        $answerBatchId = null;

        foreach ($answers as $key => $answer) {
            $answerModel = Answer::find($answer['id']);

            if ($answerBatchId === null) {
                $answerBatchId = $answerModel->batch?->id; // lo uso por si hay una respuesta que no esta guardada
            }

            if ($answerModel) {
                $answerModel->update([
                    'body' => $answer['body'] ?? ''
                ]);
            } else {
                $answerModel = new Answer([
                    'answer_batch_id' => $answerBatchId,
                    'input_id' => $answer['input_id'],
                    'body' => $answer['body'] ?? ''
                ]);

                $answerModel->save();
            }
        }
    }

    public function getAnswers(int $sectionId, int $companyId) : Collection
    {
        $answers = AnswerBatch::where('section_id', $sectionId)
            ->where('company_id', $companyId)
            ->with('answers')
            ->get();

        return $answers;
    }
}
