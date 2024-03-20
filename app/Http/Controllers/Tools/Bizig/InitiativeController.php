<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Services\Tools\Bizig\InitiativeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InitiativeController extends Controller
{
    public function __construct(
        private InitiativeService $initiativeService
    ) {}

    public function createInitiative(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string',
                'parent_id' => 'required|integer'
            ]);

            /**
             * @var User $user
             */
            $user = auth()->user();
            $companyId = $user->companies->first()?->id;

            // If no company is related to the user, return 404
            if (!$companyId) return response()->json(['message' => 'No company related'], 404);

            $perspective = $this->initiativeService->createInitiative($request->input('name'), $request->input('parent_id'), $companyId);

            return response()->json($perspective);
        } catch (\Error $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
