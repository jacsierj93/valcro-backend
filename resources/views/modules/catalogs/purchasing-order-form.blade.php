@extends('layouts.app')

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! Html::style('components/select2/dist/css/select2.css') !!}
    {!! Html::style('components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') !!}
@stop


@section('contentheader_title')
    Creacion de orden de Compra
@endsection



@section('main-content')


    <div id="rootwizard">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul>
                        <li><a href="#tab1" data-toggle="tab">Datos Básicos</a></li>
                        <li><a href="#tab2" data-toggle="tab">Productos</a></li>
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
                                    <label>Nro</label>
                                    <input class="form-control" id="nro_orden" name="nro_orden" value="{{$data->nro_orden}}"
                                           placeholder="....."
                                           type="text" required>
                                    @if ($data->id !="")
                                        <input type="hidden" id="id" value="{{$data->id}}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Proveedor</label><br>
                                    {!! Form::select('provedor_id',$provedores, $data->prov_id, array('class' => 'form-control select2','id'=>'prov_id'))  !!}

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Motivo</label><br>
                                    {!! Form::select('motivo_id',$reason, $data->motivo_id, array('class' => 'form-control select2','id'=>'motivo_id'))  !!}

                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Comentario</label><br>
                                    <input class="form-control" id="coment" name="coment" value="{{$data->comentario}}"
                                           placeholder="....."
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
                        <div class="panel panel-default">
                            <div class="panel-heading">Productos
                            </div>

                            <div class="panel-body">
                                <table  class="table table-bordered table-striped" id="producProv" style=" height: 150px;overflow: scroll;">
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
                                    @foreach ($data->getItems()->get() as $result)
                                        <tr class="itemOld" id="{{ $result->id}}">
                                            <td>{{ $result->producto_profit_id}}</td>
                                            <td id="$result->getProductoProfit()->first()->descripcion_profit}}">{{ $result->getProductoProfit()->first()->descripcion_profit}}</td>
                                            <td>{{ $result->cantidad}}</td>
                                            <td>{{ $result->unidad}}</td>
                                            <td>
                                                <input type='button' class='' style='background-color: white; border: 0px;' onclick='javascript:delRow(this)' value='Borrar'/>
                                                <input type='button' class='' style='background-color: white; border: 0px;' onclick='javascript:editRow(this)' value='Editar'/>
                                            </td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>

                                <table  class="table table-bordered table-striped" >
                                    <thead>
                                    <th width="80px"><label id="cod_prod">0000</label></th>
                                    <th>
                                        {!! Form::select('p',Array(), null , array('class' => 'form-control select2','id'=>'product_id'))  !!}
                                        <input type="hidden" id="itemid" value="-1">
                                    </th>
                                    <th width="80px"><input type="text"  id="cant_prod" style="width: 50px" class="numer"> </th>
                                    <th width="80px"><input type="text" id="uni_proc"  maxlength="3" style="width: 50px"> </th>
                                    <th width="100px"> <input type="button" class="btn" value="Agregar" id="addRow"/></th>

                                    </thead>
                                </table>
                            </div>
                        </div>


                        {!! Form::hidden('part',2) !!}

                    </div>


                </form>

            </div>

            <ul class="pager wizard">
                <li class="previous">
                    <a href="#" class="btn bg-orange margin">Anterior</a>
                </li>
                <li class="next" style="float: left">
                    <input type="button" href="#" class="btn margin" id="save" value="Guardar">
                </li>


                <li id="ncontact" class="contact" style="display: none;float: left">
                    <a type="button" data-toggle="modal" data-target="#myModal" class="btn bg-orange margin">
                        Nuevo contácto</a>
                </li>

                <li id="classfinal" class="bfinal" style="display: none;float: left">
                    <a href="#" id="bfinal" class="btn bg-orange margin">Finalizar</a>
                </li>


            </ul>
        </div>
    </div>
    <!-- form wizard content ends -->

@endsection

@section('scripts_adds')

    {!! Html::script('components/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') !!}
    {!! Html::script('components/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('components/bootstrap-switch/dist/js/bootstrap-switch.min.js') !!}

    <script src="{{url("js/module/purchasing-order.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#rootwizard').bootstrapWizard({
                onTabShow: function (tab, navigation, index) {


                    ///validar y guardar datos basicos
                    if (index == 1) {
                        //saveBasic();
                    }

                    ////validar y guardar datos de acceso
                    if (index == 2) {
                        //  saveAccess();
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
        $(".select2").select2({ width: '300px', dropdownCssClass: "bigdrop" });

        ///////////boton finalizar
        $("#bfinal").on("click",function(){

            savePreferences();

        });

    </script>



@stop
