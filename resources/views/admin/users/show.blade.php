@extends('layouts.app-dashboard')

@section('content')

<!-- Content Header (Page header) -->

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>User profile</h1>
      </div>
    </div>
  </div>
</section>

<!-- Main content -->
<section class="content">

<div class="container-fluid">
<div class="row">
  <div class="col-md-3">

    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="img-circle shadow bg-white" height='100px' width="100px" src="{{ $user->getUserAvatar() }}" alt="User profile picture">
        </div>

        <h3 class="profile-username text-center">{{ $user->name }}</h3>

        <p class="text-muted text-center">{{ $user->email }}</p>

      </div>

    </div>

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Account information</h3>
      </div>

      <div class="card-body">
        <strong><i class="fas fa-clock mr-1"></i> Registered:</strong>
          <span class="badge badge-info">{{$user->created_at->format('d/m/Y H:m')}}</span>

        <hr>

        <strong><i class="fas fa-info-circle mr-1"></i> Account status:</strong>

        @if (($user->email_verified_at == null) AND ($user->banned_at == null))
          <span class="badge badge-warning">Not confirmed</span>
        @elseif ($user->banned_at != null)
          <span class="badge badge-danger">Banned</span>
        @else 
          <span class="badge badge-success">Active</span>
        @endif

        <hr>

        <strong><i class="fas fa-briefcase"></i> Roles:</strong>

        @forelse ($user->roles as $role)
          <span class="badge badge-info">{{ $role->name }}</span>
        @empty
          No roles
        @endforelse

      </div>


      <div class="card-footer">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary btn-block"><i class="fa fa-cog"></i> <b>Edit user</b></a>
      </div>

    </div>

  </div>

  <div class="col-md-9">
    <div class="card card-primary card-outline">
      <div class="card-body">
          
        <div class="form-group">
          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-12">
            <input type="email" class="form-control" value="{{ $user->name }}" disabled>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-12">
            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
          </div>
        </div>

      </div>
    </div>

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Permissions</h3>
      </div>
      <div class="card-body">
        @forelse ($user->getPermissionsViaRoles() as $permission)
          <span class="badge badge-info">{{ $permission->name }}</span>
        @empty
          No permission assigned to the current roles of the user
        @endforelse
      </div>
    </div>

  </div>

</div>

</div>

</section>
<!-- /.content -->
@endsection
