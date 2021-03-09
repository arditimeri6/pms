@extends('layouts.app')
@section('content')

  <div class="btn-toolbar">
    <h2>Users Table</h2>
  </div>
  <div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Created At</th>
          <th style="width: 36px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td></td>
            <td>{{ $user->created_at }}</td>
            <td>
                <a href="{{ route('users.edit', $user->id) }}"><i class="fas fa-user-edit"></i></a>

                <a href=""
                    onclick="var result = confirm('Are you sure you want to delete this User?');
                      if (result) {
                          event.preventDefault();
                          document.getElementById('delete-form-{{$user->id}}').submit();
                      }
                  ">
                    <i class="fas fa-user-slash"></i>
                  </a>

                  <form id="delete-form-{{$user->id}}" action="{{ route('users.destroy', $user->id) }}"
                    method="POST" style="display: none;">
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}
                  </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="pull-right">{{ $users->links() }}</div>

@endsection
