@extends('layouts.app')

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{url('plugins/datatables/dataTables.bootstrap.css')}}">
@stop


@section('contentheader_title')
    Lista de Usuarios
@endsection




@section('main-content')


    <div class="panel-body">
        <a type="button" href="{{url("users/userForm")}}" class="btn bg-orange margin">Crear Nuevo</a>
    </div>



    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="30px">&nbsp;</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>usuario</th>
                    <th>email</th>
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
                                    <li><a href="{{url('users/userForm?id='.$result->id)}}">Editar</a></li>
                                    <li><a href="javascript:deletePos({{$result->id}})">Borrar</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>{{$result->id}}</td>
                        <td>{{$result->nombre}} {{$result->apellido}}</td>
                        <td>{{$result->position->nombre}}</td>
                        <td>{{$result->user}}</td>
                        <td>{{$result->email}}</td>
                        <td>{{ date('d/m/Y', strtotime($result->created_at)) }}</td>
                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th width="30px">&nbsp;</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>usuario</th>
                    <th>email</th>
                    <th>Creado</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('scripts_adds')
    <script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('plugins/jQuery/jquery.confirm.min.js')}}"></script>
    <script src="{{url("js/module/users.js")}}"></script>

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