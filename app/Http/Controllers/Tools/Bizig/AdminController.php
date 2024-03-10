<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use App\Services\Tools\Bizig\ProgressService;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct(
        private CompanyService $companyService,
        private ProgressService $progressService
    ) {
    }

    public function getCompanies()
    {
        try {
            $companies = $this->companyService->getCompanies();

            foreach ($companies as $company) {
                $company->progress = $this->progressService->calculateProgressFromAnswerBatches($company->answerBatches);
            }

            return response()->json($companies->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'progress' => $company->progress
                ];
            }));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
