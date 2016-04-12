@extends('layouts.app')


@section('contentheader_title')
    Maestro de Tiempo Aproximado de Transito
@endsection

@section('head_adds')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! Html::style('components/select2/dist/css/select2.css') !!}
    {!! Html::style('components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') !!}
    {!! Html::style('css/input.css') !!}
@stop


@section('main-content')

    <form name="form1" id="form1" role="form"
          data-toggle="validator" novalidate="true">

        <div class="box-body">
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Mínimo de Días</label>
                        <input class="form-control numer" id="min_dia" name="min_dia" value="{{$data->min_dias}}" placeholder="Nro..."
                               type="number" min="1"  value="1"required>
                        <label id="min_hid" class="alert alert-danger"  role="alert" style= "padding-top: 5px; padding-bottom:5px; width: 100%" hidden> El valor debe estar comprendido entre 1 y 365</label>
                    </div>
                </div>


                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Máximo de Días</label>
                        <input class="form-control numer" id="max_dia" name="max_dia" value="{{$data->max_dias}}"
                               placeholder="Nro..." type="number" min="1" value="1" required>
                       <!-- <label id="max_hid" class="alert alert-danger"  role="alert" style= "padding-top: 5px; padding-bottom:5px; width: 100%" hidden>El valor debe ser mayor al mínimo de días, comprendido entre 1 y 365</label>-->
                        <label id="dias_hid" class="alert alert-danger"  role="alert" style= "padding-top: 5px; padding-bottom:5px; width: 100%" hidden>El valor debe estar comprendido entre 1 y 365</label>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="form-group">
                        <label>País</label><br>
                        {!! Form::select('id_pais',$paises,$data->id_pais, array('class' => 'form-control select2','id'=>'id_pais'))  !!}
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

    <script src="{{url("js/module/prov-tiemaprotran.js")}}"></script>
    {!! Html::script('components/jquery-confirm/jquery.confirm.min.js') !!}
    {!! Html::script('components/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') !!}
    {!! Html::script('components/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('components/bootstrap-switch/dist/js/bootstrap-switch.min.js') !!}

    <script>
        $(function () {


            $("#save").on("click", function () {

                saveOrUpdateDep();

            });


        });
    </script>


@stop
