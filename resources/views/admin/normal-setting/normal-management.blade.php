@extends('layouts/contentNavbarLayout')

@section('title', 'Normal Setting')

@section('content')
<div class="col-md-12">
  <div class="card mb-4">
    <h5 class="card-header">Normal Setting</h5>
    
    <div class="card-body demo-vertical-spacing demo-only-element">
      @csrf
      <label class="form-label" for="Productname">Suspend_Duration Setting</label>
      <div class="input-group">
        <span class="input-group-text">@</span>
        <input type="text" class="form-control" id="productname" name="productname" placeholder="Productname" aria-describedby="Productname" value="Day: {{ $normal_setting == NULL ? 0 : $normal_setting->suspend_duration }}" readonly />
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editFunc({{ $normal_setting == NULL ? 0 : $normal_setting->suspend_duration }})">Edit</button>
    </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Edit Suspend_Duration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="edit_duration">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-info" onclick="updateOk()">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    function editFunc(params) {
        $('#edit_duration').val(params);
    }
   
    function updateOk() {
        var suspendDuration = $('#edit_duration').val();

        if (!suspendDuration) {
            alert("Please enter a suspend duration");
            return;
        }

        $.ajax({
            url: "/admin/setting/normal/update",
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                suspend_duration: suspendDuration // Data to be updated
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }
</script>
@endsection