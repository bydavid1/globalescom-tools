<?php

namespace App\Http\Controllers\Tools\Bizig;

use App\Http\Controllers\Controller;
use App\Services\Tools\Bizig\BigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BigController extends Controller
{

    public function __construct(
        private BigService $bigService
    ) {}

    public function createBig(Request $request) {
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

            $perspective = $this->bigService->createBig($request->input('name'), $request->input('parent_id'), $companyId);

            return response()->json($perspective);
        } catch (\Error $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
