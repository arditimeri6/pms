<?php 
namespace App\Repositories\ProjectRepositories;

use Illuminate\Http\Request;
use App\Project;

interface ProjectRepositoryInterface 
{
	public function allProjects();

	public function addProject(Request $request);

	public function updateProject(Request $request, Project $project);

	public function findProject(Request $request);

	public function userEmail(Request $request);
}

?>