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

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<!-- Main content -->
<section class="content mt-4">

<div class="card">
    <div class="card-header">
        Create User
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="form-group">
                <label class="required" for="name">Name</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}" required="">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror 

            </div>

            <div class="form-group">
                <label class="required" for="email">Email</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{ old('email') }}" required="">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror 
            </div>

            <div class="form-group">
                <label class="required" for="password">Password</label>
                <input class="form-control " type="password" name="password" id="password" required="">
            </div>

            <div class="form-group">
                <label class="required" for="roles">Roles</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-sm select-all">Add all</span>
                    <span class="btn btn-info btn-sm deselect-all">Remove all</span>
                </div>

                <select class="form-control select2 @error('roles') is-invalid @enderror" name="roles[]" id="roles" multiple>
                    @foreach($roles as $id => $name)
                        <option value="{{ $id }}">
                            {{ $name }}
                        </option>
                    @endforeach
                </select>

                @error('roles')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror 
            </div>

            <div class="checkbox checkbox-primary">
               <input type="checkbox" name="send_welcome_email" id="send_welcome_email" checked="">
               <label for="send_welcome_email">Send welcome email</label>
            </div>

            <div class="form-group">
                <button class="btn btn-outline-success float-right" type="submit">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>

        </form>
    </div>
</div>

</section>
<!-- /.content -->
@endsection

@section('scripts')
<script> 

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
