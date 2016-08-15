/**
 * Created by delimce on 14/3/2016.
 */
/////variable global de la ruta de la aplicacion
//console.log(window.location.pathname);
var puerto = window.location.port;

//console.log("puerto",puerto);
if(puerto != 80 || puerto != ""){
    prt = ":"+puerto;
}else{
    prt = "";
}

var base2 = "/"+window.location.pathname.split("/")[1]+"/";

var PATHAPP = "http://"+window.location.hostname+prt+base2;

/////////token para los request ajax
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


/***Jacsiel 06-06-2016
 * prevent open files on drop in browser ****/


window.addEventListener("dragover",function(e){
    e = e || event;
    e.preventDefault();
},false);
window.addEventListener("drop",function(e){
    e = e || event;
    e.preventDefault();
},false);