@extends('layouts.app')

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! Html::style('components/select2/dist/css/select2.css') !!}
    {!! Html::style('components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') !!}
    {!! Html::style('components/DataTables/media/css/dataTables.bootstrap.min.css') !!}

@stop


@section('contentheader_title')
    Pedido
@endsection



@section('main-content')


    <div id="rootwizard">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul>
                        <li><a href="#tab1" data-toggle="tab">Datos Básicos</a></li>
                        <li><a href="#tab2" data-toggle="tab">Datos Orden de compras</a></li>
                        <li><a href="#tab3" data-toggle="tab">Informacion de pago</a></li>
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
                                    <label>Proveedor</label><br>
                                    {!! Form::select('prove_id',$provedores, null , array('class' => 'form-control select2','id'=>'prove_id'))  !!}
                                </div>
                            </div>


                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Tipo de Pedido</label><br>
                                    {!! Form::select('tipo_id',$tipoPedido, null , array('class' => 'form-control select2','id'=>'tipo_id'))  !!}

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Motivo Pedido</label><br>
                                    {!! Form::select('motivo_id',$motivoPedido, null , array('class' => 'form-control select2','id'=>'motivo_id')) !!}

                                </div>
                            </div>


                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Pais</label><br>
                                    {!! Form::select('pais_id',Array(), null , array('class' => 'form-control select2','id'=>'pais_id'))  !!}
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Prioridad</label><br>
                                    {!! Form::select('prio_id',$PriorityOrders, null , array('class' => 'form-control select2','id'=>'prio_id'))  !!}

                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Condicion de pedido</label><br>
                                    {!! Form::select('condicion_pedido_id',$OrderCondition, $data->condicion_pedido_id, array('class' => 'form-control select2','id'=>'condicion_pedido_id'))  !!}

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
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="30px"></th>
                                <th>Id</th>
                                <th>Nro Orden</th>
                                <th>Aprovada</th>
                                <th>Comentario</th>
                                <th>Creada</th>
                                <th>Items</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="30px"></th>
                                <th>Id</th>
                                <th>Nro Orden</th>
                                <th>Aprovada</th>
                                <th>Comentario</th>
                                <th>Creada</th>
                                <th>Items</th>
                            </tr>
                            </tfoot>
                        </table>


                    </div>


                    {{--parte del formulario de usuario que guardará--}}
                    {!! Form::hidden('part',2) !!}

                </form>

            </div>


            <div class="tab-pane" id="tab3">
                <form name="form3" id="form3" role="form"
                      data-toggle="validator" novalidate="true">

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Monto</label><br>
                                    <input type="text" id="monto" value="{{$data->monto}}" />
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Moneda</label><br>
                                    {!! Form::select('moneda_id',Array(), null , array('class' => 'form-control select2','id'=>'moneda_id'))  !!}

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Tasa fija</label><br>
                                    <input  type="checkbox"  id="tasa_fija"
                                            @if ($data->aprovada == true)
                                            checked
                                            @endif
                                            value="{{$data->tasa_fija}}"/>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Tasa</label><br>
                                    <input  type="text"  id="tasa" value="{{$data->tasa}}"/>
                                </div>
                            </div>


                        </div>
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
                                </div>
                            </div>


                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Idioma</label><br>
                                </div>
                            </div>


                        </div>


                        <div class="row">

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Sucursal</label><br>
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

                <li id="classfinal" class="bfinal" style="display: none;float: left">
                    <a href="#" id="bfinal" class="btn bg-orange margin">Finalizar</a>
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
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Pais</label><br>
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
    {!! Html::script('components/DataTables/media/js/jquery.dataTables.min.js') !!}
    {!! Html::script('components/DataTables/media/js/dataTables.bootstrap.min.js') !!}




    <script src="{{url("js/module/pedidos-ctrl.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#rootwizard').bootstrapWizard({
                onTabShow: function (tab, navigation, index) {


                    ///validar y guardar datos basicos
                    if (index == 1) {
                    }

                    ////validar y guardar datos de acceso
                    if (index == 2) {
                        $("#ncontact").show();

                    }else{
                        $("#ncontact").hide();
                    }

                    ////finalizar y guardar preferencias
                    if(index == 3) {

                        $("#classfinal").show();
                        $(".next").hide();
                    }else{
                        $(".next").show();
                        $("#classfinal").hide();
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
        $(".select2").select2({ width: '300px', dropdownCssClass: "bigdrop" });

        ///////////boton finalizar
        $("#bfinal").on("click",function(){

            savePreferences();

        });

    </script>

    <script>

    </script>



@stop
