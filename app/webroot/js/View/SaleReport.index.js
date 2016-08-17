$(document).ready(function () {

    $(".classForClick tr .glyphicon-tags").click(function () {
        //console.log($(this).children("td").context.id);
        openModalSaleTag($(this).children("td").context.id);
    });

    $("#btnPrint").click(function () {
        //get the modal box content and load it into the printable div
        $(".printable").html($("#myModal").html());
        $(".printable").printThis();
    });
	
	   (function ($) {

        $('#filter').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();

        })

    }(jQuery));
	
	$("#selectFilterMonth").change(function(){
			
			$(".month-loading").fadeIn(200);
			var month = $(this).val();
			
			$.ajax({			
			type: "POST",			
			data:{
				month:month
			},			
			url: "/../jezzy-portal/saleReport/getAllSalesByMonth",
			success: function(result){	
				
			console.log(result);
			$("#tableAllSales").html(result);
			$(".month-loading").fadeOut(200);
			
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert("Houve algume erro no processamento dos dados dessa compra, atualize a página e tente novamente!");
			alert(errorThrown);
		}
	  });
			
    });

});

function openModalSaleTag(saleCode) {
    $.ajax({
        method: "POST",
        url: getControllerPath("SaleReport") + "getTagInfomation",
        data: {Checkout: {id: saleCode}}
    }).done(function (msg) {
        if (msg != false) {
            var checkoutFull = $.parseJSON(msg)[0];
            $("#senderName").html(checkoutFull.User.name);
            $("#senderAddress").html(checkoutFull.Checkout.address + checkoutFull.Checkout.number + " - " + checkoutFull.Checkout.complement);
            $("#senderCity").html(checkoutFull.Checkout.city + " - " + checkoutFull.Checkout.state);
            $("#senderPostal").html(checkoutFull.Checkout.zip_code);
            updateBarcode(checkoutFull.Checkout.id+checkoutFull.Checkout.company_id+checkoutFull.Checkout.user_id);
            $('#myModal').modal('show');
        } else {
            alert("Não foi possivel salvar os dados");
            return false;
        }
    });
}

function updateBarcode(barCodeValue) {
    barCodeValue = typeof barCodeValue !== 'undefined' ? barCodeValue : '1234567890';
    var barcode = new bytescoutbarcode128();
    barcode.valueSet(barCodeValue);
    barcode.setMargins(5, 5, 5, 5);
    barcode.setBarWidth(2);
    var width = barcode.getMinWidth();
    barcode.setSize(width, 80);
    var barcodeImage = $('#barcodeImage');
    barcodeImage.attr('src', barcode.exportToBase64(width, 80, 0));
}

function showCheckoutDetail(id){
	
	$.ajax({			
			type: "POST",			
			data:{
				checkoutId:id
			},			
			url: "/../jezzy-portal/saleReport/getCheckoutDetail",
			success: function(result){	
				
			$("#recebe").html(result);
			/*$('#myModalSchedulesRequisitions').modal('toggle');
			$('#myModalSchedulesRequisitions').modal('show');*/
			$("#btnShowModal").trigger("click");
			
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert("Houve algume erro no processamento dos dados dessa compra, atualize a página e tente novamente!");
			alert(errorThrown);
		}
	  });
}