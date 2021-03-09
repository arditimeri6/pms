@extends('layouts.app')
@section('content')

  <div class="col-md-9 col-lg-9 col-sm-9 pull-left">
    
    <div class="well well-lg">
      <div class="container">
        <h1 class="display-3">{{ $project->name }}</h1>
        <p>Created by: <strong><a href="users/{{$project->user->id}}">{{ $project->user->name }}</a></strong></p>
        <p>Project for: <strong><a href="{{ route('companies.show', $project->company->id) }}">{{ $project->company->name }}</a> </strong></p>
        <p>Description: <strong> {{ $project->description }} </strong></p>
        <p>Created at: <strong> {{ $project->created_at }} </strong></p>
        <p>Time frame: <strong> {{ $project->days }} days </strong></p>
      </div>
    </div>

    <div class="container">
      <div class="row col-md-9 col-lg-9 col-sm-9 pull-left" 
           style=" background: white; padding-bottom: 5px; margin-bottom: 20px; border:solid 1px #e3e3e3; border-radius: 10px;">

        @foreach($project->tasks as $task)
          <div class="col-md-4">
            <h2>{{ $task->name }}</h2>
            <p>Timeframe: {{ $task->days }} days</p>
            <p><a class="btn btn-primary" href="{{ route('tasks.show', $task->id) }}" role="button">View Task &raquo;</a></p>
          </div>
        @endforeach

      </div>
      
      @include('partials.comments')

      <div class="row col-md-9 col-lg-9 col-sm-9 pull-left" style="
      background: white; margin-top: 20px; margin-bottom: 20px; border:solid 1px #e3e3e3; border-radius: 10px;">

        <div class="row container-fluid">
           <form method="post" action="{{ route('comments.store') }}">
            
            {{ csrf_field() }}

            <input type="hidden" name="commentable_type" value="App\Project">
            <input type="hidden" name="commentable_id" value="{{ $project->id }}">
            <h2>Add a comment</h2>
            <div class="form-group @if($errors->has('url')) has-error @endif">
              <label for="comment-content">Work done (url/title)</label>
              <textarea placeholder="Enter url/title"
                      style="resize: vertical;" 
                      id="comment-content"
                      name="url"
                      rows="2" spellcheck="false" 
                      class="form-control autosize-target text-left"></textarea>
            </div>

            <div class="form-group @if($errors->has('body')) has-error @endif">
              <label for="comment-content">Comment</label>
              <textarea placeholder="Enter comment"
                      style="resize: vertical;" 
                      id="comment-content"
                      name="body"
                      rows="3" spellcheck="false" 
                      class="form-control autosize-target text-left"></textarea>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit"/>
            </div>

          </form>
        </div>
      </div>
    </div> <!-- /container -->
  </div>

  <div class="col-sm-3 col-md-3 col-lg-3 ">
       
    <div class="sidebar-module">
      <h4>Actions</h4>
      <ol class="list-unstyled">
        @if(Auth::user()->id == $project->user->id || auth()->user()->hasRole('admin'))
          <li><a href="{{ route('projects.edit', $project->id) }}"><i class="fas fa-edit"></i> Edit</a></li>
        @endif
        @if(Auth::user()->id == $project->user->id || auth()->user()->can('create_task'))
          <li><a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"><i class="fas fa-plus-circle"></i> Add Task</a></li>
        @endif
        <li><a href="{{ route('projects.index') }}"><i class="fas fa-list-ul"></i> List of projects</a></li>

        @if(Auth::user()->id == $project->user->id || auth()->user()->hasRole('admin'))
          <li>
            <a href=""
              onclick="var result = confirm('Are you sure you want to delete this Project?');
                if (result) 
                {
                    event.preventDefault();
                    document.getElementById('delete-form').submit();
                }
            ">
              <i class="fas fa-trash-alt"></i> Delete
            </a>

            <form id="delete-form" action="{{ route('projects.destroy',[$project->id]) }}"
              method="POST" style="display: none;">
                <input type="hidden" name="_method" value="delete">
                {{ csrf_field() }}
            </form>

          </li>
        @endif
      </ol>
      <hr/>

      @if(Auth::user()->id == $project->user->id)
        <h4>Add a member</h4>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <form id="add-user" action="{{ route('projects.adduser') }}" method="POST">
              {{ csrf_field() }}
              <div class="input-group">
                <input class="form-control" name="project_id" value="{{ $project->id }}" type="hidden">
                <input type="text" class="form-control" name="email" placeholder="Email">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="submit">Add!</button>
                </span>
              </div><!-- /input-group -->
            </form>
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
        <hr/>
      @endif

      <h4>Members</h4>
      <ol class="list-unstyled">
        @foreach($project->users as $user)
          <li><a href="#"> {{ $user->email }} </a></li>
        @endforeach
      </ol>

    </div>          
  </div>
@endsection