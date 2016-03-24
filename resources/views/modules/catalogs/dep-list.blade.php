@extends('layouts.app')

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! Html::style('bower_components/datatables/media/css/dataTables.bootstrap.min.css') !!}
@stop


@section('contentheader_title')
    Maestro de departamentos
@endsection

@section('main-content')


    <div class="panel-body">
        <a type="button" href="{{url("catalogs/departamentForm")}}" class="btn bg-orange margin">Crear Nuevo</a>
    </div>

    <div class="box">
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="30px">&nbsp;</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Creado</th>

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
                                    <li><a href="{{url('catalogs/departamentForm?id='.$result->id)}}">Editar</a></li>
                                    <li><a href="javascript:deleteDep({{$result->id}})">Borrar</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>{{$result->id}}</td>
                        <td>{{$result->nombre}}</td>
                        <td>{{ date('d/m/Y', strtotime($result->created_at)) }}</td>

                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>&nbsp;</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Departamento</th>

                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('scripts_adds')
    {!! Html::script('bower_components/datatables/media/js/jquery.dataTables.min.js') !!}
    {!! Html::script('bower_components/datatables/media/js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('bower_components/jquery-confirm/jquery.confirm.min.js') !!}
    <script src="{{url("js/module/catalog.js")}}"></script>

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