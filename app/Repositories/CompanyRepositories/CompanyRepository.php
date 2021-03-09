<?php

namespace App\Repositories\CompanyRepositories;

use App\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
	protected $model;

 	public function __construct(Company $company)
    {
        $this->model = $company;
    }

	public function allCompanies()
	{
		return Company::paginate(10);
	}

	public function addCompany(Request $request)
	{
		$company =  Company::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_id' => Auth::user()->id
        ]);

        if ($company) {
            return $company;
        }
	}

	public function updateCompany(Request $request, Company $company)
	{
		return Company::where('id', $company->id)->update([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);
	}
}

?>
