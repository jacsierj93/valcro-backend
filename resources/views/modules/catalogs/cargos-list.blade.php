@extends('layouts.app')

@section('head_adds')
    <link rel="stylesheet" href="{{url('plugins/datatables/dataTables.bootstrap.css')}}">
@stop


@section('htmlheader_title')
    Maestro de cargos
@endsection


@section('main-content')
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Departamento</th>
                    <th>Creado</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($data as $result)
                    <tr>
                        <td>{{$result->id}}</td>
                        <td>{{$result->nombre}}</td>
                        <td>{{$result->departament->nombre}}</td>
                        <td>{{ date('d/m/Y', strtotime($result->created_at)) }}</td>
                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Departamento</th>
                    <th>Engine version</th>
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