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
                     <div id="message">&nbsp;</div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                    </div><!-- /.col -->
                </div>
            </form>


        </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->

    @include('layouts.partials.scripts')


    <script src="{{url("js/module/account.js")}}"></script>

    <script>

        $("#form1").submit(function (e) {
            userLogin();
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });


    </script>


    </body>

@endsection
