@extends('layouts.app')
@section('content')

  <div class="col-md-9 col-lg-9 col-sm-9 pull-left">
    <h1>Update User</h1>
    <div class="row col-md-12 col-lg-12 col-sm-12" style=" background: white; padding-top: 10px; border:solid 1px #e3e3e3; border-radius: 10px;">
      <form method="post" action="{{ route('users.update', $user->id) }}">
        {{ csrf_field() }}

        <input type="hidden" name="_method" value="put">

        <div class="form-group @if($errors->has('name')) has-error @endif">
          <label for="user-name">Name <span class="required">*</span></label>
          <input  placeholder="Enter username"
                  id="user-name"
                  name="name"
                  spellcheck="false"
                  class="form-control"
                  value="{{ $user->name }}" />
        </div>

        <div class="form-group @if($errors->has('email')) has-error @endif">
          <label for="user-email">Email <span class="required">*</span></label>
          <input  placeholder="Enter email"
                  id="user-email"
                  name="email"
                  spellcheck="false"
                  class="form-control"
                  value="{{ $user->email }}" />
        </div>

        <div class="form-group">
          <label for="user-role">Role</label>
          <br />
          <label class="radio-inline">
            <input type="radio" name="role" value="admin" @if($user->hasRole('admin')) checked @endif> Admin </input>
          </label>
          <label class="radio-inline">
            <input type="radio" name="role" value="manager" @if($user->hasRole('manager')) checked @endif> Manager </input>
          </label>
          <label class="radio-inline">
            <input type="radio" name="role" value="user" @if($user->hasRole('user')) checked @endif> User </input>
          </label>
        </div>

        <div class="form-group">
          <label for="user-company">Companies</label>
          <br />
          <label>
              <input type="checkbox" name="permissions[create_company]" value="create_company" @if($user->hasPermissionTo('create_company')) checked @endif> Create </input>
          </label>

          <label style="padding-left: 15px;">
              <input type="checkbox" name="permissions[edit_company]" value="edit_company" @if($user->hasPermissionTo('edit_company')) checked @endif> Edit </input>
          </label>

          <label style="padding-left: 15px;">
              <input type="checkbox" name="permissions[delete_company]" value="delete_company" @if($user->hasPermissionTo('delete_company')) checked @endif> Delete </input>
          </label>
        </div>

        <div class="form-group">
          <label for="user-project">Projects</label>
          <br />
          <label>
              <input type="checkbox" name="permissions[create_project]" value="create_project" @if($user->hasPermissionTo('create_project')) checked @endif> Create </input>
          </label>

          <label style="padding-left: 15px;">
              <input type="checkbox" name="permissions[edit_project]" value="edit_project" @if($user->hasPermissionTo('edit_project')) checked @endif> Edit </input>
          </label>

          <label style="padding-left: 15px;">
              <input type="checkbox" name="permissions[delete_project]" value="delete_project" @if($user->hasPermissionTo('delete_project')) checked @endif> Delete </input>
          </label>
        </div>

        <div class="form-group">
          <label for="user-task">Tasks</label>
          <br />
          <label>
              <input type="checkbox" name="permissions[create_task]" value="create_task" @if($user->hasPermissionTo('create_task')) checked @endif> Create </input>
          </label>

          <label style="padding-left: 15px;">
              <input type="checkbox" name="permissions[edit_task]" value="edit_task" @if($user->hasPermissionTo('edit_task')) checked @endif> Edit </input>
          </label>

          <label style="padding-left: 15px;">
              <input type="checkbox" name="permissions[delete_task]" value="delete_task" @if($user->hasPermissionTo('delete_task')) checked @endif> Delete </input>
          </label>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit"/>
        </div>

      </form>
    </div>
  </div>
@endsection