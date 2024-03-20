<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tools\Bizig\PerspectiveResource;
use App\Services\Tools\Bizig\PerspectiveService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PerspectiveController extends Controller
{

    public function __construct(
        private PerspectiveService $perspectiveService
    ) {

    }

    public function getPerspectives(Request $request) {
        try {
            /**
             * @var User $user
             */
            $user = auth()->user();
            $companyId = null;

            // Only admin can get perspectives from a specific company
            if ($user->hasRole('admin') && $request->query('company_id')) {
                $companyId = $request->query('company_id');
            } else {
                $companyId = $user->companies->first()?->id;
            }

            // If no company is related to the user, return 404
            if (!$companyId) return response()->json(['message' => 'No company related'], 404);

            $perspectives = $this->perspectiveService->getPerspectives($companyId);

            return response()->json($perspectives->map(function ($perspective) {
                return [
                    'id' => $perspective->id,
                    'name' => $perspective->name,
                    'section_type_id' => $perspective->section_type_id,
                    'data' => json_decode($perspective->data),
                ];
            }));
        } catch (\Error $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function getPerspective($id) {
        try {
            $perspective = $this->perspectiveService->getPerspective($id);

            if (!$perspective) return response()->json(['message' => 'Perspective not found'], 404);

            return new PerspectiveResource($perspective);
        } catch (\Error $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function createPerspective(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string',
                'accent_color' => 'required|string',
            ]);

            /**
             * @var User $user
             */
            $user = auth()->user();
            $companyId = $user->companies->first()?->id;

            // If no company is related to the user, return 404
            if (!$companyId) return response()->json(['message' => 'No company related'], 404);

            $perspective = $this->perspectiveService->createPerspective($request->input('name'), $request->input('accent_color'), $companyId);

            return response()->json($perspective);
        } catch (\Error $e) {

            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
