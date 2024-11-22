@extends('layouts/contentNavbarLayout')

@section('title', 'ProductManagement')

@section('content')
<input type="hidden" id="deleteId" value="">
<div class="card">
  <div class="card-header flex items-center justify-between">
    <h3 class="pt-3">製品管理</h3>
    <a href="{{route('product-add')}}" class="btn btn-info waves-effect waves-light">追加</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead class="table-light">
        <tr>
          <th>いいえ</th>
          <th>アバター</th>
          <th>製品名</th>
          <th>価格</th>
          <th>アクション</th>
        </tr>
      </thead>

      <tbody class="table-border-bottom-0">
        @foreach ($productlist as $key => $product)
          <tr>
          <td>{{ $key + 1 }}</td>
          <td>
            <img src="{{ $product->avatar ? asset('storage/' . $product->avatar) : asset('assets/img/avatars/5.png') }}" onclick="zoomImage('{{ $product->avatar ? asset('storage/' . $product->avatar) : asset('assets/img/avatars/5.png') }}', '{{ $product->name }}')" data-bs-toggle="modal" data-bs-target="#zoomModal" alt="Avatar" class="avatar avatar-xs pull-up rounded-circle">
          </td>
          <td> {{ $product->name }}</td>
          <td> {{ $product->price }}</td>
          <td>
            <div class="flex">
              <a class="dropdown-item" href="{{ route('product-edit', $product->id) }}"><i class="mdi mdi-pencil-outline me-1"></i></a>
              <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteFunc({{ $product->id }})">
                <i class="mdi mdi-trash-can-outline me-1"></i>
              </a>
            </div>
          </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


<!-- Zoomed Image Modal -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="zoomModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center flex justify-content-center">
                <img id="zoomedImage" src="" alt="Zoomed Avatar" style="widith:400px; height:300px" class="img-fluid" style="transition: transform 0.3s ease;">
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger" onclick="deleteOk()">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>

  function deleteFunc(params) {
    $("#deleteId").val(params);
  }
   
  function deleteOk() {
    console.log($('#deleteId').val());
    $.ajax({
      url: '/admin/setting/product/delete/' + $('#deleteId').val(),
      type: 'DELETE',
      data: {
          "_token": "{{ csrf_token() }}", // Laravel CSRF token
      },
      success: function (response) {
          console.log(response.message); // Alert success message
          location.reload();       // Optionally reload the page
      },
      error: function (xhr) {
          console.log('Error: ' + xhr.responseText);
      }
    });
  }

  // JavaScript function to show zoom modal
    function zoomImage(imageSrc, productname) {
      $("#zoomModalLabel").text(productname);
      $("#zoomedImage").attr("src", imageSrc);
      $("#zoomModal").removeClass("hidden");
    }

    // Close button logic
    document.querySelector(".close").addEventListener("click", function() {
        $("#zoomModal").addClass("hidden");
    });

    // Optional: close modal on outside click
    window.addEventListener("click", function(event) {
        if (event.target === $("#zoomModal")) {
            $("#zoomModal").addClass("hidden");
        }
    });
</script>
@endsection