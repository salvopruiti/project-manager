<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('company_id')->after('id')->nullable()->constrained();
        });

        $customers = \App\Models\Customer::all(['id','company'])->groupBy('company');
        $customers->each(function(\Illuminate\Database\Eloquent\Collection $customers, string $companyName) {

            $company = \App\Models\Company::firstOrCreate(['name' => $companyName]);

            $customers->each->update(['company_id' => $company->id]);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('company');
        });
    }
};
