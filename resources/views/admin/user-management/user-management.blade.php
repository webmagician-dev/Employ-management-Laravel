@extends('layouts/contentNavbarLayout')

@section('title', 'User Management')

@section('content')
    <input type="hidden" id="deleteId" value="">
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="pt-3">User Management</h3>
            <a href="{{ route('user-add') }}" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus"></i> &nbsp;
                Add New User</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                    @foreach ($userlist as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td> {{ $user->user->name }}</td>
                            <td> {{ ucwords($user->user->gender) }}</td>
                            <td> {{ $user->user->phone }}</td>
                            <td>
                                @if ($user->address)
                                    {{ ucwords($user->address) }}
                                @endif
                            </td>
                            <td>
                                <input type="hidden" id="flag" value="{{ $user->days_since_last_login }}">
                                {{-- <span class="{{ $user->days_since_last_login < 1 ? 'text-success' : 'text-danger' }}"
                                    id="permission"
                                    onclick="permission(`{{ $user->days_since_last_login < 1 ? 'active' : 'suspend' }}`,`{{ $user->user->id }}`)">{{ $user->days_since_last_login < 1 ? 'Active' : 'Suspended' }}</span> --}}
                                <span class="{{ $user->user->status === 'active' ? 'text-success' : 'text-danger' }}"
                                    id="permission">{{ $user->user->status === 'active' ? 'Active' : 'Suspended' }}</span>
                            </td>
                            <td>
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="{{ route('user-edit', $user->id) }}"><i
                                            class="mdi mdi-pencil-outline me-1"></i></a>
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        onclick="deleteFunc({{ $user->id }})">
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
                    <img id="zoomedImage" src="" alt="Zoomed Avatar" style="width:400px; height:300px"
                        class="img-fluid" style="transition: transform 0.3s ease;">
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
        function permission(status, id) {
            if (status === "suspended") {
                $.ajax({
                    url: '{{ route('user-permission') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        status: "active",
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                console.log(status);
            }
        }

        function deleteFunc(params) {
            $("#deleteId").val(params);
        }

        function deleteOk() {
            $.ajax({
                url: '/admin/setting/user/delete/' + $('#deleteId').val(),
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}", // Laravel CSRF token
                },
                success: function(response) {
                    console.log(response.message); // Alert success message
                    location.reload(); // Optionally reload the page
                },
                error: function(xhr) {
                    console.log('Error: ' + xhr.responseText);
                }
            });
        }

        // JavaScript function to show zoom modal
        function zoomImage(imageSrc, username) {
            $("#zoomModalLabel").text(username);
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
