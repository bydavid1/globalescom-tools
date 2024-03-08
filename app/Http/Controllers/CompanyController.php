<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $companyService,
        private UserService $userService
    ) { }

    public function getCompanies()
    {
        try {
            $companies = $this->companyService->getCompanies();

            return response()->json(CompanyResource::collection($companies));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function getCompany($id)
    {
        try {
            $company = $this->companyService->getCompany($id);
            return response()->json($company);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function createCompany(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'required|image',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $company = $this->companyService->createCompany($request->all());
            $user = $this->userService->register($request->name, $request->email, $request->password);

            $company->users()->save($user);

            return response()->json($company);
        } catch (\Error $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function updateCompany(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'logo' => 'image',
            ]);

            $company = $this->companyService->updateCompany($id, $request->all());

            return response()->json($company);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
