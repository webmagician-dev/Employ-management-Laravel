@extends('layouts/contentNavbarLayout')

@section('title', 'Add New User')

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header"><a href="{{ route('user-management') }}">User Management</a> / Add New User</h5>

            <form action="{{ route('user-save') }}" method="POST" enctype="multipart/form-data"
                class="card-body demo-vertical-spacing demo-only-element">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                            name="username" placeholder="Enter your username" aria-describedby="username"
                            value="{{ old('username') }}">
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
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Enter your email address" aria-describedby="email"
                            value="{{ old('email') }}">
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
                            <option value="male" selected>Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    @error('gender')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Enter a strong password (min. 8 characters)"
                            aria-describedby="password">
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
                            aria-describedby="confirm-password">
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
                            value="{{ old('phone') }}">
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
                            value="{{ old('address') }}">
                    </div>
                    @error('address')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex flex-row justify-content-end align-items-center gap-3">
                    <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
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
