@extends('layouts.app-dashboard')

@section('content')

<!-- Content Header (Page header) -->

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Users</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<!-- Main content -->
<section class="content">
  
<div class="row">
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Registered users</span>
        <span class="info-box-number">{{ $users->total() }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-success"><i class="fa fa-check"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Active users</span>
        <span class="info-box-number">{{ $active_users }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-warning"><i class="fa fa-exclamation"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Unconfirmed users</span>
        <span class="info-box-number">{{ $unconfirmed_users }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-danger"><i class="fa fa-ban"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Banned users</span>
        <span class="info-box-number">{{ $banned_users }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>


<div class="card">
<div class="card-header">
  <h3 class="card-title">All users</h3>

  <div class="card-tools">
    <a href="{{ route('admin.users.create') }}" class="btn btn-tool">
      <i class="fas fa-plus"></i>
    </a>
  </div>
</div>
<div class="card-body p-0" style="display: block;">
  <table class="table table-striped projects">
      <thead>
          <tr>
              <th style="width: 1%"></th>
              <th style="width: 1%"></th>
              <th style="width: 20%">
                  Name
              </th>
              <th style="width: 5%" class="text-center">
                  Status
              </th>
              <th style="width: 5%" class="text-center">
                  Roles
              </th>
              <th style="width: 20%">
              </th>
          </tr>
      </thead>
      <tbody>
          @foreach ($users as $user)
          <tr>
              <td>
                  {{ $user->id }}
              </td>
              <td>
                  <ul class="list-inline">
                      <li class="list-inline-item">
                          <img alt="Avatar" class="shadow-lg table-avatar" src="{{ $user->getUserAvatar() }}">
                      </li>
                  </ul>
              </td>
              <td>
                  <a>
                      {{$user->name}} {{ $user->id == auth()->user()->id ? '(You)' : '' }}
                  </a>
                  <br>
                  <small>
                      <b>Registered at:</b> {{$user->created_at->format('d/m/Y H:m')}}
                  </small>
              </td>
              <td class="project-state">

                  @if (($user->email_verified_at == null) AND ($user->banned_at == null))
                    <span class="badge badge-warning">Not confirmed</span>
                  @elseif ($user->banned_at != null)
                    <span class="badge badge-danger">Banned</span>
                  @else 
                    <span class="badge badge-success">Active</span>
                  @endif

              </td>
              <td class="project-state">
                  @forelse ($user->roles as $role)
                    <span class="badge badge-info">{{ $role->name }}</span>
                  @empty
                    No roles
                  @endforelse
              </td>
              <td class="project-actions text-right">
                  <a class="btn btn-sm btn-primary" href="{{ route('admin.users.show', $user->id) }}">
                      <i class="fas fa-eye">
                      </i>
                      View
                  </a>
                  <a class="btn btn-info btn-sm" href="{{ route('admin.users.edit', $user->id) }}">
                      <i class="fas fa-pencil-alt">
                      </i>
                      Edit
                  </a>

                  <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display: inline-block;">
                      @method('DELETE')
                      @csrf

                      <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Delete
                      </button>
                  </form>

              </td>
          </tr>
          @endforeach
          
      </tbody>
  </table>
</div>
<!-- /.card-body -->

<div class="card-footer clearfix">
  <ul class="pagination pagination-sm m-0 float-right">
    {{ $users->links() }}
  </ul>
</div>

</div>

</section>
<!-- /.content -->
@endsection
