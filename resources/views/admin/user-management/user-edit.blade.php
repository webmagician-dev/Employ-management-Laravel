@extends('layouts/contentNavbarLayout')

@section('title', 'Edit User')

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header"><a href="{{ route('user-management') }}">User Management</a> / Edit User</h5>

            <form action="{{ route('user-update') }}" method="POST" enctype="multipart/form-data"
                class="card-body demo-vertical-spacing demo-only-element">
                @csrf
                @method('PUT')
                <input type="hidden" id="userid" name="userid" value="{{ $user->id }}">

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                            name="username" placeholder="Enter your username" aria-describedby="username"
                            value="{{ $user->user->name }}">
                    </div>
                    @error('username')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <input disabled type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" placeholder="Enter your email address" aria-describedby="email"
                            value="{{ $user->user->email }}">
                    </div>
                    @error('email')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <div class="">
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender"
                            aria-label="Select Gender">
                            <option value="male" @selected($user->user->gender == 'male')>Male</option>
                            <option value="female" @selected($user->user->gender == 'female')>Female</option>
                        </select>
                    </div>
                    @error('gender')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <p class="text-info pt-0 mt-0">To update your password, enter a new one below. If not, leave the password
                    field blank.</p>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Enter a strong password (min. 8 characters)"
                            aria-describedby="password" autocomplete="off">
                        <span class="input-group-text cursor-pointer" onclick="togglePasswordVisibility('password')"><i
                                class="mdi mdi-eye-off-outline"></i></span>
                    </div>
                    @error('password')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="confirm-password" name="password_confirmation" placeholder="Re-enter your password"
                            aria-describedby="confirm-password" autocomplete="off">
                        <span class="input-group-text cursor-pointer"
                            onclick="togglePasswordVisibility('confirm-password')"><i
                                class="mdi mdi-eye-off-outline"></i></span>
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" placeholder="Enter your phone number" aria-describedby="phone"
                            value="{{ $user->user->phone }}">
                    </div>
                    @error('phone')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" placeholder="Enter your full address" aria-describedby="address"
                            value="{{ $user->address }}">
                    </div>
                    @error('address')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">User status</label>
                    <div class="">
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            aria-label="Select User Status">
                            <option value="active" @selected($user->user->status == 'active')>Active</option>
                            <option value="suspend" @selected($user->user->status == 'suspend')>Suspend</option>
                        </select>
                    </div>
                    @error('status')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex flex-row justify-content-end align-items-center gap-3">
                    <button type="submit" class="btn btn-info waves-effect waves-light">Update</button>
                    <a href="{{ route('user-management') }}" class="btn btn-danger waves-effect waves-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    function togglePasswordVisibility(id) {
        const passwordInput = document.getElementById(id);
        const eyeIcon = passwordInput.nextElementSibling.children[0];
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("mdi-eye-off-outline");
            eyeIcon.classList.add("mdi-eye-outline");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("mdi-eye-outline");
            eyeIcon.classList.add("mdi-eye-off-outline");
        }
    }
</script>
