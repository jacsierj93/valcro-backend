@extends('layouts.app')

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! Html::style('components/select2/dist/css/select2.css') !!}
    {!! Html::style('components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') !!}
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
                                    <input class="form-control" name="email" value="{{$data->email}}"
                                           placeholder="email"
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

                    {{--parte del formulario de usuario que guardará--}}
                    {!! Form::hidden('part',1) !!}

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
                                    <label>Nivel de usuario</label>
                                    {!! Form::select('nivel_id',$niveles,$data->nivel_id, array('class' => 'form-control select2','id'=>'nivel_id'))  !!}
                                </div>
                            </div>


                        </div>


                        <div class="row">

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" name="password" value="{{$data->password}}"
                                           placeholder="escriba una clave" type="password" required>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Reptita Password</label>
                                    <input class="form-control" name="password" value="{{$data->password}}"
                                           placeholder="escriba una clave" type="password" required>
                                </div>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Activo</label><br>
                                    <input type="checkbox" name="status" id="status" checked>
                                </div>
                            </div>


                            {{--parte del formulario de usuario que guardará--}}
                            {!! Form::hidden('part',2) !!}

                        </div>

                    </div>


                </form>

            </div>


            <div class="tab-pane" id="tab3">
                <form name="form3" id="form3" role="form"
                      data-toggle="validator" novalidate="true">

                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            <!-- /.item -->
                            <li class="item">
                                <div class="product-img">
                                    <i class="fa fa-home" style="font-size: 50px"></i>
                                </div>
                                <div class="product-info">
                                    Samsung TV
                                    <span class="label pull-right">
                                  <a data-toggle="modal" onclick="" data-target="#modulex"
                                     title="editar"> <i class="fa fa-pencil-square-o"></i> </a>
                                    &nbsp;
                                    <a onclick="" title="borrar"> <i class="fa fa-trash-o"></i></a>
                                    </span></a>
                                    </span></a>
                                    <span class="product-description">
                                      Samsung 32" 1080p 60Hz LED Smart HDTV.
                                    </span>
                                </div>
                            </li>
                            <!-- /.item -->

                            <!-- /.item -->
                            <li class="item">
                                <div class="product-img">
                                    <i class="fa fa-fax" style="font-size: 50px"></i>
                                </div>
                                <div class="product-info">
                                    Samsung TV
                                    <span class="label pull-right">
                                  <a data-toggle="modal" onclick="" data-target="#modulex"
                                     title="editar"> <i class="fa fa-pencil-square-o"></i> </a>
                                    &nbsp;
                                    <a onclick="" title="borrar"> <i class="fa fa-trash-o"></i></a>
                                    </span></a>
                                    </span></a>
                                    <span class="product-description">
                                      Samsung 32" 1080p 60Hz LED Smart HDTV.
                                    </span>
                                </div>
                            </li>
                            <!-- /.item -->


                            <!-- /.item -->
                            <li class="item">
                                <div class="product-img">
                                    <i class="fa fa-mobile" style="font-size: 60px"></i>
                                </div>
                                <div class="product-info">
                                    Samsung TV
                                    <span class="label pull-right">
                                  <a data-toggle="modal" onclick="" data-target="#modulex"
                                     title="editar"> <i class="fa fa-pencil-square-o"></i> </a>
                                    &nbsp;
                                    <a onclick="" title="borrar"> <i class="fa fa-trash-o"></i></a>
                                    </span></a>
                                    </span></a>
                                    <span class="product-description">
                                      Samsung 32" 1080p 60Hz LED Smart HDTV.
                                    </span>
                                </div>
                            </li>
                            <!-- /.item -->


                        </ul>
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
                <li class="previous">
                    <a href="#" class="btn bg-orange margin">Anterior</a>
                </li>
                <li class="next" style="float: left">
                    <a href="#" class="btn bg-orange margin">Guardar</a>
                </li>

                <li id="ncontact" class="contact" style="display: none;float: left">
                    <a type="button" data-toggle="modal" data-target="#myModal" class="btn bg-orange margin">
                        Nuevo contácto</a>
                </li>


            </ul>
        </div>
    </div>
    <!-- form wizard content ends -->





    {{--Modal de los contactos--}}


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Crear / editar Contácto de usuario</h4>
                </div>
                <div class="modal-body">

                    <form name="form-contact" id="form3" role="form"
                          data-toggle="validator" novalidate="true">

                        <div class="row">

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Tipo</label><br>
                                    {!! Form::select('tipo',$tipos,$data->idioma_id, array('class' => 'form-control select2','id'=>'tipo'))  !!}
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Pais</label><br>
                                    {!! Form::select('pais_id',$paises,$data->pais_id, array('class' => 'form-control select2','id'=>'pais_id'))  !!}
                                </div>
                            </div>


                        </div>


                        <div class="row">

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Telefono</label><br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input type="telefono" class="form-control" placeholder="telefono">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Email</label><br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label>Dirección</label><br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        <input type="text" class="form-control" placeholder="dirección">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




@endsection

@section('scripts_adds')

    {!! Html::script('components/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') !!}
    {!! Html::script('components/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('components/bootstrap-switch/dist/js/bootstrap-switch.min.js') !!}


    <script src="{{url("js/module/users.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#rootwizard').bootstrapWizard({
                onTabShow: function (tab, navigation, index) {


                    ///validar y guardar datos basicos
                    if (index == 1) {
                        saveBasic();
                    }

                    ////validar y guardar datos de acceso
                    if (index == 2) {
                        saveAccess();
                        $("#ncontact").show();
                    }else{
                        $("#ncontact").hide();
                    }




                    var $total = navigation.find('li').length;
                    var $current = index + 1;
                    var $percent = ($current / $total) * 100;
                    $('#rootwizard').find('.bar').css({width: $percent + '%'});
                }
            });
        });

        $.fn.bootstrapSwitch.defaults.onText = 'SI';
        $.fn.bootstrapSwitch.defaults.offText = 'NO';
        $.fn.bootstrapSwitch.defaults.size = 'large';
        $('#status').bootstrapSwitch();


    </script>



@stop
