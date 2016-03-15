@extends('layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ url('/img/valcro/logo_inicio.png') }}"/>
        </div><!-- /.login-logo -->


    <div class="login-box-body">
    <p class="login-box-msg">Inicia una Sesión como usuario</p>
    <form name="form1" id="form1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Usuario" name="usuario"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
           {{--
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div>--}}

            <!-- /.col -->
            <div class="col-xs-4">
                <a href="javascript:userLogin()" class="btn btn-primary btn-block btn-flat">Entrar</a>
            </div><!-- /.col -->
        </div>
    </form>

    {{--@include('auth.partials.social_login')--}}

{{--
    <a href="{{ url('/password/reset') }}">I forgot my password</a><br>
    <a href="{{ url('/register') }}" class="text-center">Register a new membership</a>
--}}

</div><!-- /.login-box-body -->

</div><!-- /.login-box -->

    @include('layouts.partials.scripts')


    <script src="{{url("js/module/account.js")}}"></script>

</body>

@endsection
