<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tools\Bizig\PerspectiveResource;
use App\Services\Tools\Bizig\PerspectiveService;
use Illuminate\Support\Facades\Log;

class PerspectiveController extends Controller
{

    public function __construct(
        private PerspectiveService $perspectiveService
    ) {

    }

    public function getPerspectives() {
        try {
            $perspectives = $this->perspectiveService->getPerspectives();

            return response()->json($perspectives);
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
