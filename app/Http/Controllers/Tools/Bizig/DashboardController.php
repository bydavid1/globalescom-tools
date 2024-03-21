<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Section;
use App\Services\Tools\Bizig\ProgressService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct(
        private ProgressService $progressService
    ) { }

    public function getProgress(Request $request)
    {
        $currentUser = $request->user();
        $companyIdFromQuery = $request->query('company_id');

        if ($currentUser->roles?->first()->name !== 'admin' && $companyIdFromQuery) {
            return response()->json(['error' => 'No tienes permisos para ver el progreso de otro usuario'], 403);
        }

        $company = null;

        if ($companyIdFromQuery) {
            $company = Company::findOrFail($companyIdFromQuery);
        }

        $companyId = $company?->id ?  : $currentUser->companies?->first()->id;

        $perspectives = Section::whereRelation('sectionType', function ($query) {
            $query->where('name', 'perspective');
        })->where('company_id', $companyId)->get();

        $globalProgress = 0;

        foreach ($perspectives as $perspective) {
            $perspectiveProgress = 0;

            $bigs = [];
            $initiatives = [];

            foreach ($perspective->children as $child) {
                if ($child->sectionType->name === 'big') {
                    $bigs[] = $child;
                } elseif ($child->sectionType->name === 'initiative') {
                    $initiatives[] = $child;
                }
            }

            $perspective->bigs = $bigs;
            $perspective->initiatives = $initiatives;

            // Cargar el progreso de cada "iniciativa"
            foreach ($initiatives as $initiative) {
                $progress = $this->progressService->calculateProgressFromAnswerBatches(
                    $initiative->answerBatches->where('company_id', $companyId)
                );
                $initiative->progress = $progress;
                $perspectiveProgress += $progress;

                unset($initiative->answerBatches); // clean answerBatches
                unset($initiative->sectionType); // clean sectionType
            }

            // load progress of wach initiatives and bigs
            // Cargar el progreso de cada "big"
            foreach ($bigs as $big) {
                $progress = $this->progressService->calculateProgressFromAnswerBatches(
                    $big->answerBatches->where('company_id', $companyId)
                );
                $big->progress = $progress;
                $perspectiveProgress += $progress;

                unset($big->answerBatches); // clean answerBatches
                unset($big->sectionType); // clean sectionType
            }

            // calculate progress of perspective

            $perspective->progress = intval($perspectiveProgress / (count($bigs) + count($initiatives)));
            $globalProgress += $perspective->progress;

            unset($perspective->children); // clean children

            $perspective->data = json_decode($perspective->data);
        }

        return response()->json(['perspectives' => $perspectives, 'global_progress' => intval($globalProgress / count($perspectives))]);
    }
}
