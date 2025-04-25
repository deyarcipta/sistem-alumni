<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="icon" href="{{ asset('storage/settings/' . $setting->logo) }}" type="image/png">
    <!-- Menyesuaikan dengan format asset -->
    <link href="{{ asset('/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <!-- Nested Row within Card Body -->
                        <div class="text-center">
                            <img src="{{ asset('storage/settings/' . $setting->logo) }}" alt="Logo" style="height: 100px;">
                            <h1 class="h4 text-gray-900 mb-4">Login Admin</h1>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="user" method="POST" action="{{ url('/admin/login') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user"
                                    placeholder="Email" required autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user"
                                    placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Login
                            </button>
                        </form>

                        <hr>
                        <div class="text-center">
                            <a class="small" href="#">Lupa Password?</a>
                        </div>
                        {{-- <div class="text-center">
                            <a class="small" href="#">Buat Akun Baru</a>
                        </div> --}}
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Menyesuaikan dengan format asset -->
    <script src="{{ asset('/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('/assets/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
