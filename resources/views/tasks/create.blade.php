@extends('layouts.app')
@section('content')

  <div class="col-md-9 col-lg-9 col-sm-9 pull-left">

    <h1>Create a new task</h1>
    <div class="row col-md-12 col-lg-12 col-sm-12" style=" background: white; padding-top: 10px; border:solid 1px #e3e3e3; border-radius: 10px;">
       
      <form method="post" action="{{ route('tasks.store') }}">
        {{ csrf_field() }}

        <input name="project_id" type="hidden" value="{{ $project_id }}" />
        
        <div class="form-group @if($errors->has('name')) has-error @endif">
          <label for="task-name">Name <span class="required">*</span></label>
          <input  placeholder="Enter name"
                  id="task-name"
                  name="name"
                  spellcheck="false"
                  class="form-control" />
        </div>

        <div class="form-group">
          <label for="project-content">Select project</label>

          <select name="project_id" class="form-control">

            @foreach($projects as $project)
              <option @if($project_id == $project->id) selected="selected" @endif value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach

          </select>
        </div>

        <div class="form-group @if($errors->has('days')) has-error @endif">
          <label for="task-days">Time frame (days) <span class="required">*</span></label>
            <input  type="number" 
                    placeholder="Enter number of days"
                    id="task-days"
                    name="days"
                    class="form-control" />
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit"/>
        </div>
        
      </form>
    </div>
  </div>

  <div class="col-sm-3 col-md-3 col-lg-3 ">
    <div class="sidebar-module">
      <h4>Actions</h4>
      <ol class="list-unstyled">
        <li><a href="{{ route('tasks.index') }}">All tasks</a></li>
      </ol>
    </div>
  </div>
@endsection