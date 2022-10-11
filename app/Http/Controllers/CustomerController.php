<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function index()
    {
        $data['customers'] = Customer::with('company:id,name')
            ->when(request('q'), fn($query, $q) => $query->where(fn($query) => $query->orWhere('email', 'like', "%$q%")->orWhereRaw('concat(first_name,\' \',last_name) like ?', "%$q%")))
            ->when(request('company_id'), fn($query, $companyId) => $query->whereCompanyId($companyId))
            ->paginate();

        Session::flashInput(request()->all());

        return view('customers.index', $data);
    }

    public function create()
    {
        return $this->edit(new Customer());
    }

    public function edit(Customer $customer)
    {
        $data['customer'] = $customer;
        $data['companies'] = Company::get(['id','name']);
        return view('customers.form', $data);
    }

    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        return redirect()->route('customers.index');
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return redirect()->route('customers.index');
    }

    public function destroy(Customer $customer)
    {
        try {

            $customer->delete();

            return redirect()->route('customers.index');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }
}
