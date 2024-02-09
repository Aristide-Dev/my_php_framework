$(document).ready(function() {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 6000
    });


    $('#quickForm').on('submit', function(e) {
        e.preventDefault();
        let form = new FormData(this);
        // $('#btn_valider').prop("disabled", true);
        $('#resultat').html('<br/>Veuillez patienter...<img src="/../images/loading.gif" alt="char" width="50px" height="50px">');
        /*Debut ajax*/
        setTimeout(function() {
            $.ajax({
                url: "/admin/membre/ajouter",
                type: "POST",
                data: form,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function(data) {
                    $('#resultat').html('');
                    var data = jQuery.parseJSON(data);
                    if (data.error == 1) {
                        // Toast.fire({
                        //     icon: 'error',
                        //     title: data.msg,
                        // });
                        toastr.error(data.msg);
                    } else if (data.suc == 1) {
                        toastr.success(data.msg);
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
    
                },
                error: function(e) {
                    $('#resultat').html('');
                    // $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    //$("#btnSubmit").prop("disabled", false);
    
                }
            });
        }, 3000);
        

        /*Fin aja*/

    });
});