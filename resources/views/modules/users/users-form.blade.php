@extends('layouts.app')

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! Html::style('bower_components/select2/dist/css/select2.css') !!}
    {!! Html::style('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') !!}
@stop


@section('contentheader_title')
    Modulo Usuarios
@endsection



@section('main-content')


    <div id="rootwizard">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul>
                        <li><a href="#tab1" data-toggle="tab">Datos Básicos</a></li>
                        <li><a href="#tab2" data-toggle="tab">Datos de Acceso</a></li>
                        <li><a href="#tab3" data-toggle="tab">Contactos</a></li>
                        <li><a href="#tab4" data-toggle="tab">Preferencias</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="bar" class="progress progress-striped active">
            <div class="bar"></div>
        </div>
        <div class="tab-content">
            <div class="tab-pane" id="tab1">

                <form name="form1" id="form1" role="form"
                      data-toggle="validator" novalidate="true">

                    <div class="box-body">

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input class="form-control" name="nombre" value="{{$data->nombre}}"
                                           placeholder="nombre"
                                           type="text" required>
                                </div>
                            </div>


                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Apellido</label>
                                    <input class="form-control" name="apellido" value="{{$data->apellido}}"
                                           placeholder="apellido" type="text" required>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" name="email" value="{{$data->emal}}" placeholder="email"
                                           type="email" required>
                                </div>
                            </div>


                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Cargo</label>
                                    {!! Form::select('cargo_id',$cargos,$data->cargo_id, array('class' => 'form-control select2','id'=>'cargo_id'))  !!}
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Responsabilidades</label>
                                    <input class="form-control" name="responsabilidades"
                                           value="{{$data->responsabilidades}}" placeholder="Escriba..."
                                           type="text" required>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>


            </div>

            <div class="tab-pane" id="tab2">

                <form name="form2" id="form2" role="form"
                      data-toggle="validator" novalidate="true">

                    <div class="box-body">


                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Usuario</label>
                                    <input class="form-control" name="user" value="{{$data->user}}"
                                           placeholder="escriba un usuario"
                                           type="text" required>
                                </div>
                            </div>


                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" name="password" value="{{$data->password}}"
                                           placeholder="escriba una clave" type="password" required>
                                </div>
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Activo</label><br>
                                    <div id="label-switch" class="make-switch" data-on-label="SI" data-off-label="NO">
                                        <input type="checkbox" checked>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Nivel de usuario</label>
                                    {!! Form::select('nivel_id',$niveles,$data->nivel_id, array('class' => 'form-control select2','id'=>'nivel_id'))  !!}
                                </div>
                            </div>

                        </div>

                    </div>


                </form>

            </div>
            <div class="tab-pane" id="tab3">
                <form name="form2" id="form2" role="form"
                      data-toggle="validator" novalidate="true">

                    <div class="box-body">




                    </div>

                </form>


            </div>
            <div class="tab-pane" id="tab4">
                <form name="form4" id="form4" role="form"
                      data-toggle="validator" novalidate="true">

                    <div class="box-body">

                        <div class="row">

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Pais</label><br>
                                    {!! Form::select('pais_id',$paises,$data->pais_id, array('class' => 'form-control select2','id'=>'pais_id'))  !!}
                                </div>
                            </div>


                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Idioma</label><br>
                                    {!! Form::select('idioma_id',$lenguajes,$data->idioma_id, array('class' => 'form-control select2','id'=>'idioma_id'))  !!}
                                </div>
                            </div>



                        </div>


                        <div class="row">

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Sucursal</label>
                                    {!! Form::select('sucursal_id',$sucursales,$data->sucursal_id, array('class' => 'form-control select2','id'=>'sucursal_id'))  !!}
                                </div>
                            </div>

                        </div>


                    </div>

                </form>
            </div>

            <ul class="pager wizard">
                <li class="previous first" style="display:none;"><a href="#">First</a></li>
                <li class="previous">
                    <a href="#" class="btn bg-orange margin">Previous</a>
                </li>
                <li class="next last" style="display:none;"><a href="#">Last</a></li>
                <li class="next" style="float: left">
                    <a href="#" class="btn bg-orange margin">Siguiente</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- form wizard content ends -->

@endsection

@section('scripts_adds')

    {!! Html::script('bower_components/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') !!}
    {!! Html::script('bower_components/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') !!}


    <script src="{{url("js/module/users.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#rootwizard').bootstrapWizard({
                onTabShow: function (tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index + 1;
                    var $percent = ($current / $total) * 100;
                    $('#rootwizard').find('.bar').css({width: $percent + '%'});
                }
            });
        });


        $('#label-switch').bootstrapSwitch('setOnLabel', 'I');
        $('#label-switch').bootstrapSwitch('setOffLabel', 'O');


    </script>



@stop
