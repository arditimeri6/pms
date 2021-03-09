<?php 

namespace App\Repositories\TaskRepositories;

use App\Task;
use App\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
	protected $model;
 	
 	public function __construct(Task $task)
    {
        $this->model = $task;
    }
    
	public function allTasks()
	{
		return Task::paginate(10);
	}

	public function addTask(Request $request)
	{
		return Task::create([
            'name' => $request->input('name'),
            'days' => $request->input('days'),
            'project_id' => $request->input('project_id'),
            'user_id' => Auth::user()->id
        ]);
	}

	public function updateTask(Request $request, Task $task)
	{
		return Task::where('id', $task->id)->update([
                'name' => $request->input('name'),
                'days' => $request->input('days')
            ]);
	}

	public function findTask(Request $request)
	{
		return Task::find($request->input('task_id'));
	}

	public function userEmail(Request $request)
	{
		return User::where('email', $request->input('email'))->first();
	}
}

?>