@extends('layouts.app')


@section('htmlheader_title')
    Maestro de departamentos
@endsection

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@stop


@section('main-content')

    <form name="form1" method="GET" id="form1" role="form"
          data-toggle="validator" novalidate="true">

        <div class="box-body">
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" name="nombre" placeholder="Escriba..." type="text" required>
                    </div>
                </div>


                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input class="form-control" name="descripcion" placeholder="Escriba..." type="text" required>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-11">
                    <button type="button" id="save" class="btn bg-orange margin">Guardar</button>

                    <button onclick="history.back()" id="save" class="btn bg-gray margin">Cancelar</button>
                </div>

            </div>


        </div>

    </form>

@endsection


@section('scripts_adds')

    <script src="{{url("js/module/catalog.js")}}"></script>

    <script>
        $(function () {


            $("#save").on("click",function(){

               saveOrUpdateDep();

            });


        });
    </script>


@stop
