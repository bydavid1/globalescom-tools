<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Services\Tools\Bizig\AnswerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnswerController extends Controller
{

    public function __construct(
        private AnswerService $answerService,
    ) {

    }

    public function saveBatch(Request $request) {
        try {
            $this->answerService->saveBatch($request->input('answers'), $request->input('form_id'), $request->input('section_id'));

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
}
