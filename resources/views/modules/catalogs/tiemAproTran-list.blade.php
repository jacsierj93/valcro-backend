@extends('layouts.app')

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! Html::style('components/DataTables/media/css/dataTables.bootstrap.min.css') !!}
@stop


@section('contentheader_title')
    Maestro de Tiempo Aproximado de Transito
@endsection

@section('main-content')


    <div class="panel-body">
        <a type="button" href="{{url("catalogs/tiemAproTranForm")}}" class="btn bg-orange margin">Crear Nuevo</a>
    </div>

    <div class="box">
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="30px">&nbsp;</th>
                    <th>ID</th>
                    <th>Mìn.Días</th>
                    <th>Máx. Días</th>
                    <th>País</th>

                </tr>
                </thead>
                <tbody>

                @foreach ($data as $result)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{url('catalogs/tiemAproTranForm?id='.$result->id)}}">Editar</a></li>
                                    <li><a href="javascript:deleteDep({{$result->id}})">Borrar</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>{{$result->id}}</td>
                        <td>{{$result->min_dias}}</td>
                        <td>{{$result->max_dias}}</td>
                        <td>{{$result->getPaisName()->first()->short_name}}
                        </td>

                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>ID</th>
                    <th>Mín. Días</th>
                    <th>Máx.Días</th>
                    <th>País</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('scripts_adds')
    {!! Html::script('components/DataTables/media/js/jquery.dataTables.min.js') !!}
    {!! Html::script('components/DataTables/media/js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('components/jquery-confirm/jquery.confirm.min.js') !!}
    {!! Html::script('components/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') !!}
    {!! Html::script('components/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('components/bootstrap-switch/dist/js/bootstrap-switch.min.js') !!}
    <script src="{{url("js/module/prov-tiemaprotran.js")}}"></script>

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