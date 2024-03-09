<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getProgress(Request $request)
    {
        $userId = 1; // $request->user()->id;
        $perspectives = Section::whereRelation('sectionType', function ($query) {
            $query->where('name', 'perspective');
        })->get();

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

            // load progress of wach initiatives and bigs
            // Cargar el progreso de cada "big"
            foreach ($bigs as $big) {
                $progress = $this->calculateProgress($big->answerBatches->where('user_id', $userId));
                $big->progress = $progress;
                $perspectiveProgress += $progress;

                unset($big->answerBatches); // clean answerBatches
                unset($big->sectionType); // clean sectionType
            }

            // Cargar el progreso de cada "iniciativa"
            foreach ($initiatives as $initiative) {
                $progress = $this->calculateProgress($initiative->answerBatches->where('user_id', $userId));
                $initiative->progress = $progress;
                $perspectiveProgress += $progress;

                unset($initiative->answerBatches); // clean answerBatches
                unset($initiative->sectionType); // clean sectionType
            }

            // calculate progress of perspective

            $perspective->progress = intval($perspectiveProgress / (count($bigs) + count($initiatives)));
            $globalProgress += $perspective->progress;

            unset($perspective->children); // clean children
        }

        return response()->json(['perspectives' => $perspectives, 'global_progress' => intval($globalProgress / count($perspectives))]);
    }

    private function calculateProgress($answerBatches)
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
