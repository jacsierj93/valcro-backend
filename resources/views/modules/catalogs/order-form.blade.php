@extends('layouts.app')

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! Html::style('components/select2/dist/css/select2.css') !!}
    {!! Html::style('components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') !!}
    {!! Html::style('components/DataTables/media/css/dataTables.bootstrap.min.css') !!}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

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
                        <li><a href="#tab2" data-toggle="tab">Orden de compras</a></li>
                        <li><a href="#tab3" data-toggle="tab">Acuerdo de Pago</a></li>
                        <li><a href="#tab4" data-toggle="tab">Embarque </a></li>
                        <li><a href="#tab5" data-toggle="tab">Aprovacion/Cancelacion </a></li>
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
                                    <label>Nro Documento</label><br>
                                    <input type="text" class="form-control" id="nro_doc" value="{{$data->nro_doc}}">

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Proveedor</label><br>
                                    {!! Form::select('prov_id',$provedores, null , array('class' => 'form-control select2','id'=>'prov_id'))  !!}
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
                                    {!! Form::select('motivo_pedido_id',$motivoPedido, null , array('class' => 'form-control select2','id'=>'motivo_pedido_id')) !!}

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
                                    {!! Form::select('prioridad_id',$PriorityOrders, null , array('class' => 'form-control select2','id'=>'prioridad_id'))  !!}

                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Condicion de pedido</label><br>
                                    {!! Form::select('condicion_pedido_id',$OrderCondition, $data->condicion_pedido_id, array('class' => 'form-control select2','id'=>'condicion_pedido_id'))  !!}

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Almacen</label><br>
                                    {!! Form::select('direccion_almacen_id',Array(), 0 , array('class' => 'form-control select2','id'=>'direccion_almacen_id'))  !!}

                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Estado</label><br>
                                    {!! Form::select('pedido_estado_id',$OrderStatus, $data->status_pedido_id , array('class' => 'form-control select2','id'=>'pedido_estado_id'))  !!}

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Comentario</label><br>
                                    <input type="text" id="comentario" class="form-control" value="{{$data->comentario}}">

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
                                <th>Comentario</th>
                                <th>Creada</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data->getOrders()->get() as $result)
                                <tr old >
                                    <td width="30px"><input type="button" class="btn" value="Borrar" onclick='javascript:delRow(this)'></td>
                                    <td>{{$result->id}}</td>
                                    <td>{{$result->nro_orden}}</td>
                                    <td>{{$result->comentario}}</td>
                                    <td>{{$result->emision}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="30px"></th>
                                <th>Id</th>
                                <th>Nro Orden</th>
                                <th>Comentario</th>
                                <th>Creada</th>
                            </tr>
                            </tfoot>
                        </table>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="300px">
                                    {!! Form::select('items',Array(),null , array('class' => 'form-control select2','id'=>'items'))  !!}
                                </th>
                                <th>Comentario</th>
                                <th width="100px">
                                    <a type="button" data-toggle="modal" data-target="#myModal" class="btn bg-orange">
                                        Detalle</a>

                                </th>
                                <th width="100px"> <input type="button" id="add"  class="btn" value="Agregar"></th>
                            </tr>
                            </thead>
                        </table>
                        @if($data->id)
                            <input type="hidden" id="id" value="{{$data->id}}">
                        @endif
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
                                    <input type="text" id="monto" class="form-control" value="{{$data->monto}}" />
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Moneda</label><br>
                                    {!! Form::select('prov_moneda_id',Array(), null , array('class' => 'form-control select2','id'=>'prov_moneda_id'))  !!}

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
                                    <input  type="text" class="form-control" id="tasa" value="{{$data->tasa}}"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Condicion de Pago</label><br>
                                    {!! Form::select('condicion_pago_id',Array(), null , array('class' => 'form-control select2','id'=>'condicion_pago_id'))  !!}

                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Punto Compra</label><br>
                                    <input id="img_punto_compra" type="file" class="file" value="{{$data->img_punto_compra}}">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Nro Proforma</label><br>
                                    <input  type="text"  class="form-control" id="nro_proforma" value="{{$data->nro_proforma}}"/>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Proforma</label><br>
                                    <input id="img_proforma" type="file" class="filevalue="{{$data->img_proforma}}>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Nro Factura</label><br>
                                    <input  type="text"  id="nro_factura" class="form-control"value="{{$data->nro_factura}}"/>
                                </div>
                            </div>

                            <div class="col-sm-5" >
                                <div class="form-group">
                                    <label>Factura</label><br>
                                    <input id="img_factura" type="file" class="file"  value="{{$data->img_factura}}">
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
                                    <label>Mt3</label><br>
                                    <input  type="text"  id="mt3" class="form-control" value="{{$data->mt3}}"/>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Peso</label><br>
                                    <input id="peso" type="text" class="form-control" value="{{$data->peso}}">
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
            <div class="tab-pane" id="tab5">
                <form name="form4" id="form4" role="form"
                      data-toggle="validator" novalidate="true">

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Aprovacion gerencia</label><br>
                                    <input  type="checkbox"  id="aprob_gerencia"  value="{{$data->aprob_gerencia}}"/>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Aprovacaion Compras</label><br>
                                    <input id="img_factura" type="checkbox" value="{{$data->aprob_compras}}">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Fecha Cancelacion</label><br>
                                    <input  type="date"  id="cancelacion"  class="datepicker form-control" value="{{$data->cancelacion}}"/>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Motivo Cancelacion</label><br>
                                    <input  type="text"  id="comentario_cancelacion"  class="form-control" value="{{$data->comentario_cancelacion}}"/>
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
                    <a href="#" class="btn bg-orange margin">Siguient</a>
                </li>

                <li  style="float: left">
                    <input  id="save" type="button" class="btn bg-orange " value="Guardar"/>
                </li>


            </ul>
        </div>
    </div>
    <!-- form wizard content ends -->


    {{--Modal de ordenes de compra--}}


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Detalle de Orden Compra</h4>
                </div>
                <div class="modal-body">
                    <table width="100%">
                        <tr>
                            <td>
                                Nro
                            </td>
                            <td>
                                <span id="m_nro_orden"></span>
                            </td>
                            <td>
                                Provedor
                            </td>
                            <td>
                                <span id="mProvedor"></span>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                Aprovado
                            </td>
                            <td>
                                <span id="mAprovado"></span>
                            </td>
                            <td>
                                Direccion
                            </td>
                            <td>
                                <span id="mDir"></span>
                            </td>

                        </tr>

                        <tr>
                            <td>
                                Comentario
                            </td>
                            <td colspan="3">
                                <span id="mComent"></span>
                            </td>


                        </tr>


                    </table>

                    <table  class="table table-bordered table-striped" id="prodOrden" style=" height: 150px;overflow: scroll;">
                        <thead>
                        <tr>
                            <th width="80px">Cod</th>
                            <th>Descripcion</th>
                            <th width="80px">Cantidad</th>
                            <th width="80px">Unidad</th>
                            <th width="100px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th width="80px">Cod</th>
                            <th>Descripcion</th>
                            <th width="80px">Cantidad</th>
                            <th width="80px">Unidad</th>
                            <th width="100px"></th>
                        </tr>
                        </tfoot>
                    </table>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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

    {!! Html::script('components/jqueryui/jquery-ui.min.js') !!}



    <script src="{{url("js/module/pedidos-ctrl.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            ///////////boton finalizar
            $("#save").click(function(){
                save();
            })
            console.log( $("#save"));

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

                    $(".datepicker").datepicker();


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





    </script>

@stop
