/**
 * Created by delimce on 14/3/2016.
 */
/////variable global de la ruta de la aplicacion
var puerto = window.location.port;

//console.log("puerto",puerto);
if(puerto != 80 || puerto != ""){
    prt = ":"+puerto;
}else{
    prt = "";
}

var PATHAPP = "http://"+window.location.hostname+prt+"/dev/";

/////////token para los request ajax
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});