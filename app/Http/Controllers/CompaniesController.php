<?php

namespace App\Http\Controllers;

use App\Company;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Companies\CompaniesCreateFormRequest;
use App\Repositories\CompanyRepositories\CompanyRepositoryInterface;

class CompaniesController extends Controller
{
    protected $companies;

    public function __construct(CompanyRepositoryInterface $companies)
    {
        $this->middleware(['permission:create_company'])->only('create');
        $this->middleware(['permission:edit_company'])->only('edit');
        $this->middleware(['permission:delete_company'])->only('delete');
        $this->companies = $companies;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = $this->companies->allCompanies();

        return view('companies.index', ['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompaniesCreateFormRequest $request)
    {
        $company = $this->companies->addCompany($request);
        return redirect()->route('companies.index')->with('success', 'Company added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $comments = $company->comments;

        return view('companies.show', ['company' => $company, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $user = Auth::user();

        if ($user->can('update', $company))
        {
            return view('companies.edit', ['company' => $company]);
        }

        return response(view('errors.403'), 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompaniesCreateFormRequest $request, Company $company)
    {
        $user = Auth::user();

        if ($user->can('update', $company))
        {
            $this->companies->updateCompany($request, $company);

            return redirect()->route('companies.show',['company' => $company->id])
                    ->with('success', 'Company updated successfully');
        }

        return response(view('errors.403'), 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        dd($company);
        $user = Auth::user();

        if ($user->can('delete', $company))
        {
            $company->delete();

            return redirect()->route('companies.index')
                ->with('success', 'Company deleted successfully');
        }

        return response(view('errors.403'), 403);
    }
}
