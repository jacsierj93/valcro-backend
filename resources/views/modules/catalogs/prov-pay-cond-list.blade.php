@extends('layouts.app')

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! Html::style('components/DataTables/media/css/dataTables.bootstrap.min.css') !!}
@stop


@section('contentheader_title')
    Maestro condicion de Pagos a Proveedor
@endsection

@section('main-content')


    <div class="panel-body">
        <a type="button" href="{{url("catalogs/CondPagoProvForm")}}" class="btn bg-orange margin">Crear Nuevo</a>
    </div>

    <div class="box">
        <div class="box-body">
            <table id="body" class="" cellspacing="0" border="0" width="100%">
                <tr>
                    <td width="500px">
                        <div class="panel panel-default">
                            <div class="panel-heading">Titulos
                                </div>

                            <div class="panel-body" style=" height:350px; overflow: scroll;">
                                <table  class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th width="30px">&nbsp;</th>
                                        <th>Titulo</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                            @foreach ($data as $result)
                                <tr >
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="{{url('catalogs/CondPagoProvForm?id='.$result->id)}}">Editar</a></li>
                                                <li><a href="javascript:deleteProvPayCond({{$result->id}})">Borrar</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="item" id="{{$result->id}}">{{$result->titulo}}</td>
                                </tr>
                                @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>titulo</th>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="panel panel-default">
                          <div class="panel-heading">Detalles</div>
                            <div id="detail" class="panel-body" style=" height:350px; overflow: scroll;">
                                <table id="items"  class="table table-bordered table-striped" >
                                    <thead>
                                    <tr>
                                        <th width="80px">%</th>
                                        <th width="80px">Dias</th>
                                        <th>Descripcion</th>

                                    </tr>
                                    </thead>
                                    <tbody  style="height:200px;">
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th width="80px">%</th>
                                        <th width="80px">Dias</th>
                                        <th>Descripcion</th>
                                    </tr>
                                    </tfoot>
                                </table>
                          </div>
                        </div>

                    </td>
                </tr>

            </table>
        </div>
        <!-- /.box-body -->
    </div>

@endsection

@section('scripts_adds')
    {!! Html::script('components/DataTables/media/js/jquery.dataTables.min.js') !!}
    {!! Html::script('components/DataTables/media/js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('components/jquery-confirm/jquery.confirm.min.js') !!}
    <script src="{{url("js/module/prov-pay-cond-ctrl.js")}}"></script>

    <script>
        $(function () {

            $('#example1').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>


@stop