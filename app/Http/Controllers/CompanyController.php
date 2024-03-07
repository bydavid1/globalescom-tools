<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $companyService
    ) { }

    public function getCompanies()
    {
        $companies = $this->companyService->getCompanies();

        return response()->json($companies);
    }

    public function getCompany($id)
    {
        $company = $this->companyService->getCompany($id);

        return response()->json($company);
    }

    public function createCompany(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'required|image',
        ]);

        $company = $this->companyService->createCompany($request->all());

        return response()->json($company);
    }

    public function updateCompany(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'image',
        ]);

        $company = $this->companyService->updateCompany($id, $request->all());

        return response()->json($company);
    }
}
