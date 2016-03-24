<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
{!! Html::script('bower_components/jquery/dist/jquery.min.js') !!}
<!-- Bootstrap 3.3.6 JS -->
{!! Html::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
<!-- AdminLTE App -->
<script src="{{ url('/js/app.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/js/settings.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
@yield('scripts_adds') <!-- los script extras en el footer que necesiten las paginas dinamicas -->