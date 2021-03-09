<?php 

namespace App\Repositories\ProjectRepositories;

use App\Project;
use App\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
	protected $model;
 	
 	public function __construct(Project $project)
    {
        $this->model = $project;
    }

	public function allProjects()
	{
		return Project::paginate(10);
	}

	public function addProject(Request $request)
	{
		return Project::create([
            'name' => $request->input('name'),
            'days' => $request->input('days'),
            'description' => $request->input('description'),
            'company_id' => $request->input('company_id'),
            'user_id' => Auth::user()->id
        ]);
	}

	public function updateProject(Request $request, Project $project)
	{
		return Project::where('id', $project->id)->update([
                'name' => $request->input('name'),
                'days' => $request->input('days'),
                'description' => $request->input('description')
            ]);
	}

	public function findProject(Request $request)
	{
		return Project::find($request->input('project_id'));
	}

	public function userEmail(Request $request)
	{
		return User::where('email', $request->input('email'))->first();
	}
}

?>