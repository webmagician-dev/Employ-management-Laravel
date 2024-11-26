@extends('layouts/contentNavbarLayout')

@section('title', 'ユーザーの編集')

@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header"><a href="{{ route('user-management') }}">ユーザー管理</a> / ユーザーの編集</h5>

            <form action="{{ route('user-update') }}" method="POST" enctype="multipart/form-data"
                class="card-body demo-vertical-spacing demo-only-element">
                @csrf
                @method('PUT')
                <input type="hidden" id="userid" name="userid" value="{{ $user->id }}">

                <div class="mb-3">
                    <label for="username" class="form-label">ユーザー名</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                            name="username" placeholder="ユーザー名を入力してください" aria-describedby="username"
                            value="{{ $user->user->name }}">
                    </div>
                    @error('username')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">メール</label>
                    <div class="input-group">
                        <input disabled type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" placeholder="メールアドレスを入力してください" aria-describedby="email"
                            value="{{ $user->user->email }}">
                    </div>
                    @error('email')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">性別</label>
                    <div class="">
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender"
                            aria-label="性別を選択">
                            <option value="male" @selected($user->user->gender == 'male')>男性</option>
                            <option value="female" @selected($user->user->gender == 'female')>女性</option>
                        </select>
                    </div>
                    @error('gender')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <p class="text-info pt-0 mt-0">パスワードを更新するには、以下に新しいパスワードを入力してください。更新しない場合は、パスワード フィールドを空白のままにしてください。</p>
                <div class="mb-3">
                    <label for="password" class="form-label">パスワード</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="強力なパスワードを入力してください（最低8文字）" aria-describedby="password"
                            autocomplete="off">
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
                    <label for="confirm-password" class="form-label">パスワードを認証する</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="confirm-password" name="password_confirmation" placeholder="パスワードを再入力してください"
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
                    <label for="phone" class="form-label">電話</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" placeholder="電話番号を入力してください" aria-describedby="phone"
                            value="{{ $user->user->phone }}">
                    </div>
                    @error('phone')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">住所</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" placeholder="住所を入力してください" aria-describedby="address"
                            value="{{ $user->address }}">
                    </div>
                    @error('address')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">ユーザーステータス</label>
                    <div class="">
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            aria-label="ユーザーステータスを選択">
                            <option value="active" @selected($user->user->status == 'active')>アクティブ</option>
                            <option value="suspend" @selected($user->user->status == 'suspend')>つるす</option>
                        </select>
                    </div>
                    @error('status')
                        <div class="text-danger pt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex flex-row justify-content-end align-items-center gap-3">
                    <button type="submit" class="btn btn-info waves-effect waves-light">更新</button>
                    <a href="{{ route('user-management') }}" class="btn btn-danger waves-effect waves-light">キャンセル</a>
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
