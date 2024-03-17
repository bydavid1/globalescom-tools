<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tools\Bizig\PerspectiveResource;
use App\Services\Tools\Bizig\PerspectiveService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PerspectiveController extends Controller
{

    public function __construct(
        private PerspectiveService $perspectiveService
    ) {

    }

    public function getPerspectives() {
        try {

            if (Gate::denies('get-sections', )) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $user = auth()->user();
            $companyId = $user->companies->first()->id;

            $perspectives = $this->perspectiveService->getPerspectives($companyId);

            return response()->json($perspectives->map(function ($perspective) {
                return [
                    'id' => $perspective->id,
                    'name' => $perspective->name,
                    'section_type_id' => $perspective->section_type_id,
                    'data' => json_decode($perspective->data),

                ];
            }));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function getPerspective($id) {
        try {
            $perspective = $this->perspectiveService->getPerspective($id);

            return new PerspectiveResource($perspective);
        } catch (\Error $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
