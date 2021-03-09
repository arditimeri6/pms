<?php 
namespace App\Repositories\TaskRepositories;

use App\Task;
use Illuminate\Http\Request;

interface TaskRepositoryInterface 
{
	public function allTasks();

	public function addTask(Request $request);

	public function updateTask(Request $request, Task $task);

	public function findTask(Request $request);

	public function userEmail(Request $request);
}

?>