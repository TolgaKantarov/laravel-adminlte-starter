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
        
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

<div class="card">
    <div class="card-header">
        Edit Permission
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
            @method('PUT')
            @csrf
            <div class="form-group">
              <label class="required" for="name">Title</label>
              <input class="form-control " type="text" name="name" id="name" value="{{$permission->name}}" required="">
            </div>

            <div class="form-group">
                <button class="btn btn-outline-success float-right" type="submit">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>

        </form>
    </div>
</div>

</div>

</section>
@endsection

