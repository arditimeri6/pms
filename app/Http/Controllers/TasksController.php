<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
// use App\User;
use App\TaskUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tasks\TasksCreateFormRequest;
use App\Http\Requests\Tasks\AddMemberFormRequest;
use Illuminate\Support\MessageBag;
use App\Repositories\TaskRepositories\TaskRepositoryInterface;

class TasksController extends Controller
{
    protected $tasks;

    public function __construct(TaskRepositoryInterface $tasks)
    {
        $this->middleware(['permission:create_task'])->only('create');
        $this->middleware(['permission:edit_task'])->only('edit');
        $this->middleware(['permission:delete_task'])->only('delete');
        $this->tasks = $tasks;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->tasks->allTasks();
        // $tasks = DB::table('tasks')->paginate(10);

        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function addUser(AddMemberFormRequest $request, MessageBag $msg)
    {
        $user = Auth::user();
        //add user to task
        $task = $this->tasks->findTask($request);

        if(!$user->can('addUser', $task))
        {
            $msg->add('member', 'Error adding user to task');
            return redirect()
                ->route('tasks.show', ['task' => $task->id])
                ->withErrors($msg);
        }

        $user = $this->tasks->userEmail($request);

        if ($user && $task)
        {
            $task->users()->attach($user->id);

            return redirect()->route('tasks.show', ['task' => $task->id])
                    ->with('success', $request->input('email').' was added to the task successfully');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $project_id = $request->project_id;

        $projects = null;

        $projects = Project::all();
        
        return view('tasks.create', ['project_id' => $project_id, 'projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TasksCreateFormRequest $request)
    {
        $task = $this->tasks->addTask($request);

        if ($task)
        {
            return redirect()->route('tasks.index')
                     ->with('success', 'Task added successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $comments = $task->comments;

        return view('tasks.show', ['task' => $task, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $user = Auth::user();

        if ($user->can('update', $task)) 
        {
            return view('tasks.edit', ['task' => $task]);
        }

        return response(view('errors.403'), 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TasksCreateFormRequest $request, Task $task)
    {
        $user = Auth::user();

        if ($user->can('update', $task)) 
        {
            $this->tasks->updateTask($request, $task);

            if ($task)
            {
                return redirect()->route('tasks.show',['task' => $task->id])
                        ->with('success', 'Task updated successfully');
            }
        }

        return response(view('errors.403'), 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $user = Auth::user();

        if ($user->can('delete', $task)) 
        {
            $task->delete();
            
            return redirect()->route('tasks.index')
                    ->with('success', 'Task deleted successfully');
        }

        return response(view('errors.403'), 403);
    }
}