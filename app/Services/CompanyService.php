<?php
namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    public function getCompanies() {
        $companies = Company::all();

        return $companies;
    }

    public function getCompany($id) : Company|null
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

    public function getMyCompany() : Company|null
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        return $user->companies?->first();
    }

    public function updateCompany($id, $data) : Company
    {
        $company = Company::find($id);

        if (isset($data['logo'])) {
            $logo = $data['logo'];
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            Storage::disk('public')->put(Company::$mediaPath . $filename, file_get_contents($logo));
            $company->logo = $filename;
        }

        $company->name = $data['name'];
        $company->save();

        return $company;
    }

    public function getCompanyUsers($id) {
        $company = Company::find($id);

        return $company->users;
    }
}
