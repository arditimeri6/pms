<?php

namespace App\Http\Controllers;

use App\Project;
use App\Company;
// use App\User;
use App\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Projects\ProjectsCreateFormRequest;
use App\Http\Requests\Projects\AddMemberFormRequest;
use Illuminate\Support\MessageBag;
use App\Repositories\ProjectRepositories\ProjectRepositoryInterface;

class ProjectsController extends Controller
{
    protected $projects;

    public function __construct(ProjectRepositoryInterface $projects)
    {
        $this->middleware(['permission:create_project'])->only('create');
        $this->middleware(['permission:edit_project'])->only('edit');
        $this->middleware(['permission:delete_project'])->only('delete');
        $this->projects = $projects;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = $this->projects->allProjects();

        // $projects = DB::table('projects')->paginate(10);

        return view('projects.index', ['projects' => $projects]);
    }

    public function adduser(AddMemberFormRequest $request,MessageBag $msg)
    {
        $user = Auth::user();

        // $project = Project::find($request->input('project_id'));
        $project = $this->projects->findProject($request);

        if(!$user->can('addUser', $project))
        {
            $msg->add('member', 'Error adding user to project');
            return redirect()
                ->route('projects.show', ['project' => $project->id])
                ->withErrors($msg);
        }

        // $user = User::where('email', $request->input('email'))->first();
        $user = $this->projects->userEmail($request);

        if ($user && $project)
        {
            $project->users()->attach($user->id);

            return redirect()->route('projects.show', ['project' => $project->id])
                ->with('success', $request->input('email').' was added to the project successfully');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $company_id = $request->company_id;
        
        $companies = null;

        $companies = Company::all();

        return view('projects.create', ['company_id' => $company_id, 'companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectsCreateFormRequest $request)
    {
        $project = $this->projects->addProject($request);

        return redirect()->route('projects.index')
            ->with('success', 'Project added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $comments = $project->comments;

        return view('projects.show', ['project' => $project, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $user = Auth::user();

        if ($user->can('update', $project)) 
        {
            return view('projects.edit', ['project' => $project]);
        }
        
        return response(view('errors.403'), 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectsCreateFormRequest $request, Project $project)
    {
        $user = Auth::user();

        if ($user->can('update', $project)) 
        {
            $this->projects->updateProject($request, $project);   

            return redirect()->route('projects.show',['project' => $project->id])
                ->with('success', 'Project updated successfully');
        }

        return response(view('errors.403'), 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $user = Auth::user();

        if ($user->can('update', $project))
        {
            $project->delete();
            
            return redirect()->route('projects.index')
                ->with('success', 'Project deleted successfully');
        }

        return response(view('errors.403'), 403);
    }
}