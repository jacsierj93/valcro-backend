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
            $("#message").html("<p class='text-center'><img src='" + PATHAPP + "/assets/images/ajax-loader.gif'></p>")
        },
        success: function (response) {
            // response
            var msg = "";
            if (response.success == 'false') { ///nolog
                msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.error + '</div>';
                $("#message").html(msg);
            } else { ///loging
                var adminurl = PATHAPP + 'admin';
                location.replace(adminurl);
            }

        }
    });

};