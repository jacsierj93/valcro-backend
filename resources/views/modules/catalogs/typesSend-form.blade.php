@extends('layouts.app')


@section('contentheader_title')
    Maestro de tipos de envio de proveedores
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
                               type="text" maxlength="50" required>
                    </div>
                </div>


                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input class="form-control" name="descripcion" value="{{$data->descripcion}}"
                               placeholder="Escriba..." type="text" maxlength="255" required>
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

    <script src="{{url("js/module/prov-typesEnv.js")}}"></script>
    {!! Html::script('components/jquery-confirm/jquery.confirm.min.js') !!}

    <script>
        $(function () {


            $("#save").on("click", function () {

                saveOrUpdateDep();

            });


        });
    </script>


@stop