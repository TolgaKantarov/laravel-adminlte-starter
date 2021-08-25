@extends('layouts.app-dashboard')

@section('css')
<link href='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css' rel='stylesheet'>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />

<style type="text/css">

  .filepond--drop-label {
    color: #4c4e53;
  }

  .filepond--label-action {
    text-decoration-color: #babdc0;
  }

  .filepond--panel-root {
    background-color: #edf0f4;
  }

  .filepond--root {
    width:170px;
    margin: 0 auto;
  }

</style>
@endsection

@section('content')

<!-- Content Header (Page header) -->

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit user</h1>
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

<div class="container-fluid">
<div class="row">
  <div class="col-md-3">

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">

        <div class="text-center">
          <img class="img-circle shadow bg-white" height='100px' width="100px" src="{{ $user->getUserAvatar() }}" alt="User profile picture">
        </div>

        <button type="button" class="mt-2 btn btn-sm btn-outline-primary btn-block" data-toggle="modal" data-target="#modal-avatar-update">
                Change avatar
        </button>

        <h3 class="profile-username text-center">{{ $user->name }}</h3>

        <p class="text-muted text-center">{{ $user->email }}</p>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- About Me Box -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Account information</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <strong><i class="fas fa-clock mr-1"></i> Registered:</strong>
          <span class="badge badge-info">{{$user->created_at->format('d/m/Y H:m')}}</span>

        <hr>

        <strong><i class="fas fa-info-circle mr-1"></i> Account status:</strong>

        <form method="POST" action="{{ route('admin.users.update.status', $user->id) }}">
          @csrf
          <select class="custom-select rounded-0" name='status' onchange="submit()">
              <option {{ (($user->email_verified_at == null) AND ($user->banned_at == null)) ? 'selected' : '' }} value='not_confirmed'>Not confirmed</option>
              <option {{ (($user->email_verified_at != null) AND ($user->banned_at == null)) ? 'selected' : '' }} value='active'>Active</option>
          </select>
        </form>

<!--         <strong><i class="fas fa-info-circle mr-1"></i> Role:</strong>

        <form method="POST" action="{{ route('admin.users.update.role', $user->id) }}">
          @csrf
          <select class="custom-select rounded-0" name='role' onchange="submit()">
              <option>No assigned role</option>
              @forelse ($roles as $role)
                <option {{ $user->getRoleNames() == $role ? 'selected' : '' }}> {{ $role }}</option>
              @empty 
                <option>No roles in database</option>
              @endforelse
          </select>
        </form> -->

      </div>
      <!-- /.card-body -->

      <div class="card-footer">

        <form action="{{ route('admin.users.ban-hammer', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to perform this action?');" class="mb-2">
            @csrf

            <input type="hidden" name="action" value="{{ ($user->banned_at) ? '0' : '1' }}">

            <button type="submit" class="btn btn-warning btn-block">
              <i class="fas fa-ban"></i> @if ($user->banned_at) Unban user @else Ban user @endif
            </button>
        </form>

        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-block">
              <i class="fas fa-trash"></i> Delete user
            </button>
        </form>

      </div>

    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="card card-light">

      <div class="card-header">
        <h3 class="card-title">General information</h3>
      </div>

      <div class="card-body">

            @if (session('status_general'))
                <div class="alert alert-success" role="alert">
                    {{ session('status_general') }}
                </div>
            @endif
          
            <form method='POST' action={{ route('admin.users.update.general', $user->id) }} class="form">
              @csrf

              <div class="form-group col-sm-12">
                <label for="name" class="col-form-label">Password</label>
                <input type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}">

                @error('name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group col-sm-12">
                <label for="email" class="col-form-label">E-mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}">

                @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-outline-success float-right"><i class="fa fa-check"></i> Update</button>
                </div>
              </div>

            </form>
      </div><!-- /.card-body -->
    </div>

    <div class="card card-light">

      <div class="card-header">
        <h3 class="card-title">Password</h3>
      </div>

      <div class="card-body">

            @if (session('status_password'))
                <div class="alert alert-success" role="alert">
                    {{ session('status_password') }}
                </div>
            @endif
          
            <form method='POST' action={{ route('admin.users.update.password', $user->id) }} class="form">

              @csrf
              <div class="form-group col-sm-12">
                <label for="old_password" class="col-form-label">Current password</label>
                <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" placeholder="*********" required>

                @error('old_password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group col-sm-12">
                <label for="new_password" class="col-form-label">New password</label>
                <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="*********" required>

                @error('new_password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group col-sm-12">
                <label for="new_password_confirmation" class="col-form-label">New password repeat</label>
                <input type="password" class="form-control" name="new_password_confirmation" placeholder="*********" required>

              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-outline-success float-right"><i class="fa fa-check"></i> Update</button>
                </div>
              </div>

            </form>

      </div><!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="card card-light">

      <div class="card-header">
        <h3 class="card-title">Roles</h3>
      </div>

      <div class="card-body">

            @if (session('status_password'))
                <div class="alert alert-success" role="alert">
                    {{ session('status_password') }}
                </div>
            @endif
          
            <form method='POST' action={{ route('admin.users.update.password', $user->id) }} class="form">

              @csrf

              <div class="form-group">
                  <div style="padding-bottom: 4px">
                      <span class="btn btn-info btn-sm select-all">Add all</span>
                      <span class="btn btn-info btn-sm deselect-all">Remove all</span>
                  </div>

                  <select class="form-control select2" name="permissions[]" id="permissions" multiple required>
                      @foreach($roles as $id => $role)
                          <option value="{{ $id }}" >{{ $role }}</option>
                      @endforeach
                  </select>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-outline-success float-right"><i class="fa fa-check"></i> Update</button>
                </div>
              </div>

            </form>

      </div><!-- /.card-body -->
    </div>
    <!-- /.card -->

  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
</div>

@include('admin.users.partials.avatar-modal')

</section>
<!-- /.content -->
@endsection

@section('scripts')
  <script src='https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js'></script>
<script src='https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js'></script>
<script src='https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'></script>
<script src='https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js'></script>
<script src='https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js'></script>
<script src='https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js'></script>
<script src='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js'></script>
<script src='https://unpkg.com/filepond/dist/filepond.min.js'></script>

<script>
FilePond.registerPlugin(
  FilePondPluginFileValidateType,
  FilePondPluginImageExifOrientation,
  FilePondPluginImagePreview,
  FilePondPluginImageCrop,
  FilePondPluginImageResize,
  FilePondPluginImageTransform,
);

// Select the file input and use 
// create() to turn it into a pond
FilePond.create(
  document.querySelector('.filepond'),
  {
    labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
    imagePreviewHeight: 170,
    imageCropAspectRatio: '1:1',
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    stylePanelLayout: 'compact circle',
    styleLoadIndicatorPosition: 'center bottom',
    styleProgressIndicatorPosition: 'right bottom',
    styleButtonRemoveItemPosition: 'center bottom',
    styleButtonProcessItemPosition: 'right bottom',
  }
);

FilePond.setOptions({
    server: '/storage/uploads'
});


$('.select-all').click(function () {
  let $select2 = $(this).parent().siblings('.select2')
  $select2.find('option').prop('selected', 'selected')
  $select2.trigger('change')
})

$('.deselect-all').click(function () {
  let $select2 = $(this).parent().siblings('.select2')
  $select2.find('option').prop('selected', '')
  $select2.trigger('change')
})

$('.select2').select2();

</script>

@endsection
