<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $data['companies'] = Company::withCount('customers')->paginate();

        return view('companies.index', $data);
    }

    public function create()
    {
        return $this->edit(new Company());
    }

    public function edit(Company $company)
    {
        $data['company'] = $company;
        return view('companies.form', $data);
    }

    public function store(CompanyRequest $request)
    {
        $company = company::create($request->validated());

        return redirect()->route('companies.index');
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return redirect()->route('companies.index');
    }

    public function destroy(company $company)
    {
        try {

            \DB::beginTransaction();

            $company->customers()->update(['company_id' => null]);
            $company->delete();

            \DB::commit();

            return redirect()->route('companies.index');

        } catch (\Throwable $exception) {

            \DB::rollBack();

            throw $exception;
        }
    }
}
