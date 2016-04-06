@extends('layouts.app')


@section('contentheader_title')
    Maestro de condicion de Pago a Proveedor
@endsection

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@stop


@section('main-content')

    <form name="form1" id="form1" role="form"
          data-toggle="validator" novalidate="true">
        <div class="panel panel-default">
            <div class="panel-heading">
                <table width="100%">
                    <tr>
                        <td width="70px"><label>Titulo</label></td>
                        <td width="250px">
                            <input class="form-control" name="titulo"  id="titulo" maxlength="45" value="{{$data->titulo}}" placeholder="Escriba..."
                                                                 type="text" required style=" !important; width: 300px;">
                        </td>
                        <td style="text-align: right;">
                            @if ($data->id !="")
                                <input type="hidden" id="id" value="{{$data->id}}">
                            @endif
                            <button onclick="history.back()" id="back" class="btn bg-gray">Regresar</button>
                            <input type="button"  id="save" class="btn" value="Guardar" disabled>
                        </td>
                    </tr>
                </table>



            </div>
            <div class="list-group panel-body" >
                <div style="width: 100%; height: 250px; overflow-y: scroll;">
                <table id="items"  class="table table-bordered table-striped" >
                    <thead>
                    <tr>
                        <th width="60px">&nbsp;</th>
                        <th width="80px">%</th>
                        <th width="80px">Dias</th>
                        <th>Descripcion</th>

                    </tr>
                    </thead>
                    <tbody  style="height:200px;">
                    @foreach ($data->getItems()->get() as $result)
                        <tr class='itemRow' id="{{$result->id}}" >
                          <td>
                              <div class='btn-group'>
                                    <button type='button' class='btn btn-default btn-flat dropdown-toggle' data-toggle='dropdown'>
                                        <span class='caret'></span>
                                        <span class='sr-only'>Toggle Dropdown</span>
                                    </button>
                                    <ul class='dropdown-menu' role='menu'>
                                        <li><a id="{{$result->id}}" class='opEdit'>Editar</a></li>
                                        <li><a  id="{{$result->id}}" class='opDel'>Borrar</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td class='mntPorc'>
                                {{$result->porcentaje}}

                            </td>
                            <td>
                                {{$result->dias}}

                            </td>
                            <td>
                                {{$result->descripcion}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <table class="table">
                    <tbody>
                    <tr>
                        <td width="60px">&nbsp;</td>
                        <td width="80px">

                            <input class="form-control numer" name="porcentage" id="porcentaje"   placeholder="%"
                                   type="text"  max="100"  min="1" required value="1">
                        </td>
                        <td width="80px">
                            <input class="form-control numer" name="dias"  id="dias" maxlength="19"  placeholder="0"
                                                type="text"  min="1" required>
                        </td>
                        <td>
                            <input class="form-control" name="descripcion" id="descripcion"  maxlength="19" placeholder="Escriba..."
                                   type="text" required >


                        </td>
                        <td width="60px">
                            <input type="hidden" id="itemid" value="-1">
                            <input type="button"  id="btadd" class="btn bg-orange" value="Agregar">
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </form>

@endsection


@section('scripts_adds')

    <script src="{{url("js/module/prov-pay-cond-ctrl.js")}}"></script>
    {!! Html::script('components/jquery-confirm/jquery.confirm.min.js') !!}




    <script>
        $(function () {


            $("#save").on("click", function () {
                saveOrUpdateProvPayCond();

            });


        });
    </script>


@stop
