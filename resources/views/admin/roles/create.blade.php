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
        Create Role
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf

            <div class="form-group">
              <label class="required" for="name">Title</label>
              <input class="form-control " type="text" name="name" id="name" value="" required="">
            </div>

            <div class="form-group">
                <label class="required" for="permissions">Permissions</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-sm select-all">Add all</span>
                    <span class="btn btn-info btn-sm deselect-all">Remove all</span>
                </div>

                <select class="form-control select2" name="permissions[]" id="permissions" multiple>
                    @foreach($permissions as $id => $name)
                        <option value="{{ $id }}">
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
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
