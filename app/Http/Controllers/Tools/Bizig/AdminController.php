<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use App\Services\Tools\Bizig\ProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct(
        private CompanyService $companyService,
        private ProgressService $progressService
    ) { }

    public function getCompanies()
    {
        try {
            $companies = $this->companyService->getCompanies();

            foreach ($companies as $company) {
                $companyProgress = 0;

                $users = $company->users;

                if (count($users) === 0) {
                    $company->progress = 0;
                    continue;
                }

                foreach ($users as $user) {
                    $userProgress = $this->progressService->calculateProgressFromAnswerBatches($user->answerBatches);
                    $companyProgress += $userProgress;
                }

                $company->progress = $companyProgress / count($users);
                unset($company->users);
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
