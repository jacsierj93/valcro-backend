@extends('layouts.app')


@section('contentheader_title')
    Maestro de Sucursales
@endsection

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@stop


@section('main-content')

    <form name="form1" id="form1" role="form"
          data-toggle="validator" novalidate="true">

        <div class="box-body">
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" name="nombre" value="{{$data->nombre}}" placeholder="Escriba..."
                               type="text" required>
                    </div>
                </div>


                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Razón Social</label>
                        <input class="form-control" name="razon_social" value="{{$data->razon_social}}"
                               placeholder="Escriba..." type="text" required>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Telefono 1</label>
                        <input class="form-control" name="telefono1" value="{{$data->telefono1}}" placeholder="Escriba..."
                               type="text" required>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Telefono 2</label>
                        <input class="form-control" name="telefono2" value="{{$data->telefono2}}"
                               placeholder="Escriba..." type="text" required>
                    </div>
                </div>

            </div>



            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Dirección</label>
                        {!! Form::textarea('direccion', $data->direccion, ['class' => 'form-control'])  !!}
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-sm-11">

                    @if ($data->id !="") {!! Form::hidden('id', $data->id) !!} @endif

                    <button type="button" id="save" class="btn bg-orange margin">Guardar</button>

                    <button onclick="history.back()" id="save" class="btn bg-gray margin">Regresar</button>
                </div>

            </div>


        </div>

    </form>

@endsection


@section('scripts_adds')

    <script src="{{url("js/module/catalog.js")}}"></script>

    <script>
        $(function () {


            $("#save").on("click", function () {

                saveOrUpdateSuc();

            });


        });
    </script>


@stop
