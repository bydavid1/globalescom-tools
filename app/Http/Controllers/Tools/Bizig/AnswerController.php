<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tools\Bizig\AnswerBatchResource;
use App\Services\CompanyService;
use App\Services\Tools\Bizig\AnswerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnswerController extends Controller
{
    public function __construct(
        private AnswerService $answerService,
        private CompanyService $companyService
    ) {
    }

    public function saveBatch(Request $request)
    {
        try {
            $user = $request->user();
            $answers = $request->input('answers');
            $formId = $request->input('form_id');
            $sectionId = $request->input('section_id');
            $userId = $user->id;
            $companyId = $user->companies->first()->id;

            $this->answerService->saveBatch($answers, $formId, $sectionId, $userId, $companyId);

            return response()->json(['message' => 'Answers saved successfully']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function updateBatch(Request $request)
    {
        try {
            $answers = $request->input('answers');
            $this->answerService->updateBatch($answers);

            return response()->json(['message' => 'Answers updated successfully']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function getAnswers(Request $request)
    {
        try {
            $currentUser = $request->user();

            $sectionId = $request->query('section_id');
            $companyIdFromQuery = $request->query('company_id');

            if ($companyIdFromQuery && !$currentUser->hasRole('admin')) {
                return response()->json(['message' => 'No autorizado'], 401);
            }

            $company = $companyIdFromQuery ?
                $this->companyService->getCompany($companyIdFromQuery) :
                $currentUser->companies->first();

            if (!$company) {
                return response()->json(['message' => 'No se encontro la empresa'], 404);
            }

            $answers = $this->answerService->getAnswers($sectionId, $company->id);
            return response()->json(AnswerBatchResource::collection($answers));
        } catch (\Error $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
