@extends('layouts.app')
@section('content')

<div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
  <div class="panel panel-primary">
    <div class="panel-heading">Projects
      @if(auth()->user()->can('create_project') || auth()->user()->hasRole('admin')) 
        <a href="{{ route('projects.create') }}" style="color: white; float: right;">Create new project</a>
      @endif
    </div>
    <div class="panel-body">
      <ul class="list-group">
        @foreach($projects as $project)
          <li class="list-group-item">
            <a href="{{ route('projects.show', $project->id) }}"> {{ $project->name }} </a>
            @if(Auth::user()->id == $project->user_id)
              <a class="pull-right" href="{{ route('projects.show', $project->id) }}"> Manage </a>
            @endif
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="pull-right">{{ $projects->links() }}</div>
</div>
@endsection