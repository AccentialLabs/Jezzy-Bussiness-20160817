$(document).ready(function () {


    $('#minhaTabela').each(function () {
        var currentPage = 0;
        var numPerPage = 18;
        var $table = $(this);
        $table.bind('repaginate', function () {
            $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number"></span>').text(page + 1).bind('click', {
                newPage: page
            }, function (event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($pager).addClass('clickable');
        }
        $pager.insertAfter($table).find('span.page-number:first').addClass('active');

    });

    $('#activeOffers').each(function () {
        var currentPage = 0;
        var numPerPage = 18;
        var $table = $(this);
        $table.bind('repaginate', function () {
            $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number"></span>').text(page + 1).bind('click', {
                newPage: page
            }, function (event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($pager).addClass('clickable');
        }
        $pager.insertAfter($table).find('span.page-number:first').addClass('active');

    });

    $('#inactiveOffer').each(function () {
        var currentPage = 0;
        var numPerPage = 18;
        var $table = $(this);
        $table.bind('repaginate', function () {
            $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number"></span>').text(page + 1).bind('click', {
                newPage: page
            }, function (event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($pager).addClass('clickable');
        }
        $pager.insertAfter($table).find('span.page-number:first').addClass('active');

    });

    $(".glyphicon-share").click(function () {
        var id = $(this).attr("id");
        shareOffer('ACTIVE', 'ACTIVE', 'ACTIVE', id);
    });
    /*
     $("#sections").on("click", ".glyphicon-pause", function () {
     var offerId = $(this).closest('td')[0].id;
     changeOfferStatus(offerId, "INATIVO").done(function (msg) {
     console.log(msg);
     if (msg === "1") {
     $("#"+offerId).html('<span class="glyphicon glyphicon-play"></span>');
     } else {
     alert("Não foi possivel ativar sua oferta. Refresh a pagina e tente novamente.");
     }
     });
     });
     
     $("#sections").on("click", ".glyphicon-play", function () {
     var offerId = $(this).closest('td')[0].id;
     changeOfferStatus(offerId, "ATIVO").done(function (msg) {
     if (msg === "1") {
     $("#"+offerId).html('<span class="glyphicon glyphicon-pause"></span>');
     } else {
     alert("Não foi possivel pausar sua oferta. Refresh a pagina e tente novamente.");
     }
     });
     });*/

    $(".active-icon").click(function () {
        var id = $(this).attr("id");
        $.ajax({
            type: "POST",
            data: {
                id: id
            },
            url: "/../jezzy-portal/product/reactiveOffer",
            success: function (result) {


                //$("#"+id).attr("class", "glyphicon glyphicon-pause inactive-iconn");
                $("#row-f" + id).html('<span class="glyphicon glyphicon-pause inactive-icon" id="' + id + '"></span>');
                location.reload();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
            }
        });

    });

    $(".inactive-icon").click(function () {
        var id = $(this).attr("id");

        $.ajax({
            type: "POST",
            data: {
                id: id
            },
            url: "/../jezzy-portal/product/inactiveOffer",
            success: function (result) {
                //alert("#row-f"+id);
                $("#row-f" + id).html('<span class="glyphicon glyphicon-play active-icon" id="' + id + '"></span>');
                location.reload();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
            }
        });
    });


});

function changeOfferStatus(offerId, offerStatus) {
    return $.ajax({
        method: "POST",
        url: getControllerPath("Product") + "changeOfferStatus",
        data: {Offer: {id: offerId, status: offerStatus}}
    });
}

function shareOffer(fbk, twt, gplus, id) {
    var link = getControllerPath("product") + 'product/offerDetail?offer=' + id;
    if (fbk == 'ACTIVE') {
        window.open('http://www.facebook.com/sharer.php?u=' + link + '?title=facebook', 'share', 'toolbar=0, status=0, width=650, height=450');
    }
    if (twt == 'ACTIVE') {
        window.open("https://twitter.com/intent/tweet?text= &url=" + link, 'share1', 'toolbar=0, status=0, width=650, height=450');
    }
    if (gplus == 'ACTIVE') {
        window.open('https://plus.google.com/share?url=' + link, 'share2', 'toolbar=0, status=0, width=650, height=450');
    }
}

function showOfferDetail(id) {

    $.ajax({
        type: "POST",
        data: {
            OfferId: id
        },
        url: getControllerPath("Product") + "getOfferDetails",
        success: function (result) {

            $("#recebe-offer-detail").html(result);
            $('#myModal').modal('toggle');
            $('#myModal').modal('show');

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
        }
    });

}
