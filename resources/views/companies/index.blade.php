@extends('layouts.app')
@section('content')
  @if(flash()->message)
      <div class="{{ flash()->class }}">
          {{ flash()->message }}
      </div>
  @endif
  <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
    <div class="panel panel-primary">

      <div class="panel-heading">Companies
        @if(auth()->user()->can('create_company') || auth()->user()->hasRole('admin'))
          <a href="{{ route('companies.create') }}" style="color: white; float: right;">Create a new company</a>
        @endif
      </div>

      <div class="panel-body">
        <ul class="list-group">
          @foreach($companies as $company)
            <li class="list-group-item">
              <a href="{{ route('companies.show', $company->id) }}"> {{ $company->name }} </a>
              @if(Auth::user()->id == $company->user_id)
                <a class="pull-right" href="{{ route('companies.show', $company->id) }}"> Manage </a>
              @endif
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="pull-right">{{ $companies->links() }}</div>
  </div>
@endsection
