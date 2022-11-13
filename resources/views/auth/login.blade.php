<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="flex-column">
            <div class="card-body">
                <div class="col-12 text-center my-3">
                    <img src="{{ asset('assets/images/logo1.jpg') }}" alt="" height="70">
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mx-3">
                        <!-- <label for="email">{{ __('Email Address') }}</label> -->
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mx-3">
                        <!-- <label for="password">{{ __('Password') }}</label> -->
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
</body>
</html>
