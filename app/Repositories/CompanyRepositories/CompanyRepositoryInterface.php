<?php 
namespace App\Repositories\CompanyRepositories;

use Illuminate\Http\Request;
use App\Company;

interface CompanyRepositoryInterface 
{
	public function allCompanies();

	public function addCompany(Request $request);

	public function updateCompany(Request $request, Company $company);
}

?>