@extends('layouts.app-dashboard')

@section('content')

<!-- Main content -->
<section class="content" style="padding-top: 20px">

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<div class="card">
<div class="card-header">
  <h3 class="card-title">Permissions</h3>

  <div class="card-tools">
    <a href="{{ route('admin.permissions.create') }}" class="btn btn-tool">
      <i class="fas fa-plus"></i>
    </a>
  </div>
</div>
<div class="card-body" style="display: block;">

  @if ($permissions->count()) 
  <table class="table table-striped table-bordered projects ">
      <thead>
          <tr>
              <th>
                Name
              </th>

              <th>
                Assigned to roles
              </th>

              <th></th>
          </tr>
      </thead>
      <tbody>
          @foreach ($permissions as $permission)
          <tr>
              <td>
                  {{ $permission->name }}
              </td>

              <td>
                  @forelse ($permission->roles as $role)
                    <span class="badge badge-info">{{ $role->name }}</span>
                  @empty
                    -
                  @endforelse
              </td>

              <td class="project-actions text-right">
                  <a class="btn btn-info btn-sm" href="{{ route('admin.permissions.edit', $permission) }}">
                    <i class="fas fa-pencil-alt"></i> Edit
                  </a>

                  <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete item?');" style="display: inline-block;">
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
    <p>No permissions in database.</p>
  @endif
</div>
<!-- /.card-body -->

<div class="card-footer clearfix">
  <ul class="pagination pagination-sm m-0 float-right">
    {{ $permissions->links() }}
  </ul>
</div>

</div>

</section>
<!-- /.content -->
@endsection
