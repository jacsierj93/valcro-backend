@extends('layouts.app')

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! Html::style('components/DataTables/media/css/dataTables.bootstrap.min.css') !!}
@stop


@section('contentheader_title')
    Pedidos
@endsection

@section('main-content')

    <div class="panel-body">
        <a type="button" href="{{url("catalogs/OrderForm")}}" class="btn bg-orange margin">Crear Nuevo</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <label>Proveedor</label><br>
            {!! Form::select('prove_id',$provedores, null , array('class' => 'form-control select2','id'=>'prove_id'))  !!}
        </div>
        <div class="panel-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="30px">&nbsp;</th>
                    <th>Tipo</th>
                    <th>Nro Pedido</th>
                    <th>Proforma</th>
                    <th>Factura </th>
                    <th>Fecha</th>
                    <th>Comentario</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                    <th width="30px">&nbsp;</th>
                    <th>Tipo</th>
                    <th>Nro Pedido</th>
                    <th>Proforma</th>
                    <th>Factura </th>
                    <th>Fecha</th>
                    <th>Comentario</th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
@endsection

@section('scripts_adds')
    {!! Html::script('components/DataTables/media/js/jquery.dataTables.min.js') !!}
    {!! Html::script('components/DataTables/media/js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('components/jquery-confirm/jquery.confirm.min.js') !!}
    <script src="{{url("pedido-lispedido-list-ctrl.js")}}"></script>

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