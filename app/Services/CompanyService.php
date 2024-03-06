<?php
namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    public function getCompanies() {
        $companies = Company::all();

        return $companies;
    }

    public function getCompany($id) : Company
    {
        $company = Company::find($id);

        return $company;
    }

    public function createCompany($data) : Company
    {
        $logo = $data['logo'];
        $filename = time() . '.' . $logo->getClientOriginalExtension();
        Storage::disk('public')->put(Company::$mediaPath . $filename, file_get_contents($logo));

        $company = Company::create([
            'name' => $data['name'],
            'logo' => $filename,
        ]);

        return $company;
    }
}
