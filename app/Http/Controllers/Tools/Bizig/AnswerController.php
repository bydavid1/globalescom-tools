<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tools\Bizig\AnswerBatchResource;
use App\Services\Tools\Bizig\AnswerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnswerController extends Controller
{

    public function __construct(
        private AnswerService $answerService,
    ) { }

    public function saveBatch(Request $request) {
        try {
            $user = $request->user();

            $this->answerService->saveBatch(
                $request->input('answers'),
                $request->input('form_id'),
                $request->input('section_id'),
                $user->id,
                $user->companies->first()->id
            );

            return response()->json(['message' => 'Answers saved successfully']);
        } catch (\Error $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function updateBatch(Request $request) {
        try {
            $this->answerService->updateBatch($request->input('answers'));

            return response()->json(['message' => 'Answers updated successfully']);
        } catch (\Error $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function getAnswers(Request $request) {
        try {

            $currentUser = $request->user();

            $userIdFromQuery = $request->query('user_id');
            $sectionId = $request->query('section_id');

            if ($currentUser->roles?->first()->name !== 'admin' && $userIdFromQuery !== $currentUser->id) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $answers = $this->answerService->getAnswers(
                $sectionId,
                $userIdFromQuery ?? $currentUser->id
            );

            return response()->json(AnswerBatchResource::collection($answers));
        } catch (\Error $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
