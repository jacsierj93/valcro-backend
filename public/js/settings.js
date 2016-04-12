/**
 * Created by delimce on 14/3/2016.
 */
/////variable global de la ruta de la aplicacion
var PATHAPP = "http://valcrolindes01/dev/";

/////////token para los request ajax
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});