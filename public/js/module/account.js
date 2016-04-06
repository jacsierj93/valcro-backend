/**
 * Created by delimce on 14/3/2016.
 */
var userLogin = function () {

    ////entrada de datos
    var form = $('#form1');


    jQuery.ajax({
        url: PATHAPP + 'api/user/login',
        type: 'POST',
        dataType: 'json',
        data: form.serialize(),
        /*        beforeSend: function (xhr) {
         // xhr.setRequestHeader( "Authorization", "BEARER " + access_token );
         },*/
        beforeSend: function () {
            $("#message").html("<p class='text-center'>Procesando...</p>")
        },
        success: function (response) {
            // response
            var msg = "";
            if (response.success == 'false') { ///nolog
                msg = '<div style="text-align: center; font-weight: bold; padding: 5px">' + response.error + '</div>';
                $("#message").html(msg);
            } else { ///loging
                var adminurl = PATHAPP;
                location.replace(adminurl);
            }

        }, error : function(response){
            console.log(response);
        }
    });

};