$(document).ready(function() {
    let redirect = "";
    $('#log').on('submit', function(e) {
        e.preventDefault();
        let form = new FormData(this);
        $('.btn_connect').prop("disabled", true);
        $('#resultat').html('<hr><h5 class="alert alert-info">Veuillez patienter ...<img width="50" height="50" src="../images/loading.gif"/></h5><hr>');
        /*Debut ajax*/
        setTimeout(function() {
            $.ajax({
                url: "/auth",
                type: "POST",
                data: form,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function(data) {
                    var data = jQuery.parseJSON(data);
                    if (data.error == 1) {
                        $('.btn_connect').prop("disabled", false);
                        $('#resultat').html('<hr><h6 class="alert alert-danger close" data-dismiss="alert" >' + data.msg + '</h6><hr>');
                    } else if (data.suc == 1 && data.error == 0 || data.first_login == 0) {
                        $('#resultat').html('<h6 class="alert alert-success">' + data.msg + '</h6>');
                        setTimeout(function() {
                            window.location.replace(data.redirect);
                        }, 1000);
                    } else if (data.first_login == 1) {
                        $('#resultat').html('<h6 class="alert alert-success">' + data.msg + '</h6>');
                        redirect = data.redirect;
                        nom = data.redirect.replace("/", '');
                        $(".modal-title").html('<h4 class="modal-title">Bienvenue - ' + nom + '</h4>');
                        $("#modal-lg").modal("show");
                    }

                },
                // error: function(e) {

                //     // $("#result").text(e.responseText);
                //     console.log("ERROR : ", e);
                //     //$("#btnSubmit").prop("disabled", false);

                // }
            });
        }, 3000);


        /*Fin aja*/

    });


    $('#new_pwd_modify').on('submit', function(e) {
        e.preventDefault();
        let form = new FormData(this);
        $('.valider').prop("disabled", true);
        $('#resultat_new_pwd').html('<hr><h6 class="alert alert-info">Veuillez patienter ...<img width="50" height="50" src="../images/loading.gif"/></h6><hr>');
        /*Debut ajax*/
        setTimeout(function() {
            $.ajax({
                url: "/auth-first-login",
                type: "POST",
                data: form,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function(data) {
                    var data = jQuery.parseJSON(data);
                    if (data.error == 1) {
                        $('.valider').prop("disabled", false);
                        $('#resultat_new_pwd').html('<hr><h6 class="alert alert-danger close" data-dismiss="alert" >' + data.msg + '</h6><hr>');
                    } else if (data.suc == 1 && data.error == 0) {
                        $('#resultat_new_pwd').html('<h6 class="alert alert-success">' + data.msg + '</h6>');
                        setTimeout(function() {
                            window.location.replace(redirect);
                        }, 1000);
                    }

                },
                error: function(e) {

                    // $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    //$("#btnSubmit").prop("disabled", false);

                }
            });
        }, 3000);


        /*Fin aja*/

    });
});