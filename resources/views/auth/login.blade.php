<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Log in</title>
    @include('layouts.includes.styles')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>GOLDEN</b>GYM</a>
        </div>
        <!-- /.login-logo -->


        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            {{-- @if (session('status'))
                <div class="alert alert-danger">{{ session('status') }}</div>
            @endif --}}

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('dashboard.login') }}" method="POST">
                @csrf
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">

                    <div class="form-group" style="margin-left:20px">
                        <label for="password">
                            <a href="{{ route('password.request') }}" class="float-right">
                                Forgot Password?
                            </a>
                        </label>
                    </div>

                    <div class="form-group" style="margin-left: 240px ; margin-top:-40px">
                        <div class="custom-checkbox custom-control">
                            <input type="checkbox" name="remember" id="remember" class="custom-control-input">
                            <label for="remember" class="custom-control-label">Remeber Me</label>
                        </div>
                    </div>


                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    @include('layouts.includes.scripts')

</body>

</html>
