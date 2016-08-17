$(document).ready(function() {

    
    $(".offer-for-client").click(function() {

        id = $(this).attr('id');



        $.ajax({
            type: "POST",
            data: {
                id: id
            },
            url: "/../jezzy-portal/clientReport/offerByUser",
            success: function(result) {

                //MUDA LOCAL
                window.location = "/../jezzy-portal/product/productManipulation";

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
            }
        });

    });


    $(".offer-for-profile").click(function() {

        var id = $(this).attr('id');


        $.ajax({
            type: "POST",
            data: {
                id: id
            },
            url: "/../jezzy-portal/clientReport/getProfileByUser",
            success: function(result) {

                //MUDA LOCAL
                window.location = "/../jezzy-portal/product/productManipulation";

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
            }
        });

    });

});

function showUserDetail(id) {

    $.ajax({
        type: "POST",
        data: {
            userId: id
        },
        url: "/../jezzy-portal/clientReport/getClienteDetail",
        success: function(result) {

            $("#recebe").html(result);
            $('#myModalUserDetails').modal('toggle');
            $('#myModalUserDetails').modal('show');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
        }
    });

}

function showPhotoInZoom(src){
    
        $('#imagepreview').attr('src', src); // here asign the image to the modal when the user click the enlarge link
        $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function

   
}