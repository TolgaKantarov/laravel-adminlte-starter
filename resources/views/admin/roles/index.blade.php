@extends('layouts.app-dashboard')

@section('content')

<!-- Content Header (Page header) -->


<!-- Main content -->
<section class="content" style="padding-top: 20px">

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<div class="card">
<div class="card-header">
  <h3 class="card-title">Roles</h3>

  <div class="card-tools">
    <a href="{{ route('admin.roles.create') }}" class="btn btn-tool">
      <i class="fas fa-plus"></i>
    </a>
  </div>
</div>
<div class="card-body" style="display: block;">

  @if ($roles->count()) 
  <table class="table table-striped table-bordered projects">
      <thead>
          <tr>
              <th>
                Name
              </th>

              <th>
                Permissions assigned
              </th>

              <th>
                Users count
              </th>

              <th></th>
          </tr>
      </thead>
      <tbody>
          @foreach ($roles as $role)
          <tr>
              <td>
                  {{ $role->name }}
              </td>

              <td>
                  @forelse ($role->permissions as $permission)
                    <span class="badge badge-info">{{ $permission->name }}</span>
                  @empty
                    No permissions assigned
                  @endforelse
              </td>

              <td>
                  {{ count($role->users) }}
              </td>

              <td class="project-actions text-right">
                  <a class="btn btn-info btn-sm" href="{{ route('admin.roles.edit', $role) }}">
                      <i class="fas fa-pencil-alt">
                      </i>
                      Edit
                  </a>

                  <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete item?');" style="display: inline-block;">
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
  @else
    <p>No roles in database.</p>
  @endif
</div>
<!-- /.card-body -->

<div class="card-footer clearfix">
  <ul class="pagination pagination-sm m-0 float-right">
    {{ $roles->links() }}
  </ul>
</div>

</div>

</section>
<!-- /.content -->
@endsection
