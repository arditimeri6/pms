@extends('layouts.app')
@section('content')

<div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
  <div class="panel panel-primary">
    
    <div class="panel-heading">Tasks 
      @if(auth()->user()->can('create_task') || auth()->user()->hasRole('admin')) 
        <a href="{{ route('tasks.create') }}" style="color: white; float: right;">Create new task</a>
      @endif
    </div>
    
    <div class="panel-body">
      
      <ul class="list-group">
        @foreach($tasks as $task)
          <li class="list-group-item">
            <a href="{{ route('tasks.show', $task->id) }}"> {{ $task->name }} </a>
            @if(Auth::user()->id == $task->user_id)
                <a class="pull-right" href="{{ route('tasks.show', $task->id) }}"> Manage </a>
            @endif
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="pull-right">{{ $tasks->links() }}</div>
</div>
@endsection