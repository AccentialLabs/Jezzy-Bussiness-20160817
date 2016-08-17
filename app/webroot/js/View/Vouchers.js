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