<div class="modal fade" id="modal-avatar-update" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change avatar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <div class="modal-body">

        <form method="POST" action={{ route('admin.users.update.avatar', $user->id) }} enctype="multipart/form-data" id="avatar-update-form">
          @csrf
          
            <!-- <input type="file" class="form-control-file" name="avatar"> -->
            <input type="file" 
                  class="filepond"
                  name="avatar"
                  accept="image/png, image/jpeg, image/gif"/>

        </form>

      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-outline-success" onclick='document.getElementById("avatar-update-form").submit();'><i class="fa fa-check"></i> Update</button>
      </div>

     
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>