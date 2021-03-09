@extends('layouts.app')
@section('content')

  <div class="col-md-9 col-lg-9 col-sm-9 pull-left">

    <h1>Create a new Project</h1>
    <div class="row col-md-12 col-lg-12 col-sm-12" style=" background: white; padding-top: 10px; border:solid 1px #e3e3e3; border-radius: 10px;">

      <form method="post" action="{{ route('projects.store') }}">
        {{ csrf_field() }}

        <div class="form-group @if($errors->has('name')) has-error @endif">
          <label for="project-name">Name <span class="required">*</span></label>
          <input  placeholder="Enter name"
                  id="project-name"
                  name="name"
                  spellcheck="false"
                  class="form-control" />
        </div>

        <div class="form-group">
          <label for="company-content">Select Company</label>

          <select name="company_id" class="form-control">
              @foreach($companies as $company)
                <option @if($company_id == $company->id) selected="selected" @endif value="{{ $company->id }}">{{ $company->name }}</option>
              @endforeach

          </select>
        </div>

        <div class="form-group @if($errors->has('name')) has-error @endif">
          <label for="project-days">Time frame (days) <span class="required">*</span></label>
          <input  type="number"
                  placeholder="Enter number of days"
                  id="project-says"
                  name="days"
                  class="form-control" />
        </div>

        <div class="form-group">
          <label for="project-content">Description</label>
          <textarea placeholder="Enter description"
                    style="resize: vertical;" 
                    id="project-content"
                    name="description"
                    rows="5" spellcheck="false" 
                    class="form-control autosize-target text-left">
          </textarea>
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
        <li><a href="{{ route('projects.index') }} ">All projects</a></li>
      </ol>
    </div>
  </div>
@endsection