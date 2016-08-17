$(document).ready(function() {

	$("#services-select").change(function(){
			
		$("#offerPrice").val($(this).val());
		
	});


	$("#offerTypeServiceRadio").change(function(){
				 if ($("#offerTypeServiceRadio").is(":checked")) {
				 
					  $.ajax({
                type: "POST",
                data: {},
                url: "/../jezzy-portal/service/getServiceByNameForCompanySelect",
                success: function(result) {
                    
                    $('#services-select').html(result);
					$("#services-select").fadeIn(100);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
				 					
				 }else{

					$("#services-select").fadeOut(100);
				 }
	});
	
	$("#offerTypeProductRadio").change(function(){
		 if ($("#offerTypeProductRadio").is(":checked")) {
			$("#services-select").fadeOut(100);
		 }
	});

    //lista automaticamente nomes dos serviços
	/*
    $("#OfferTitle").keyup(function() {
        var inputValue = $("#OfferTitle").val();
        if ($("#offerTypeServiceRadio").is(":checked")) {

            $.ajax({
                type: "POST",
                data: {
                    searchService: inputValue},
                url: "/../jezzy-portal/service/getServiceByNameForCompany",
                success: function(result) {
                    $("#search-return").fadeIn(0);
                    $('#search-return').html(result);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });

        } else {
            $("#search-return").fadeIn(0);
        }
    });*/


    var elementoHelper = false;
    //mostrando text de help para cada campo
    $(".helper-field").click(function() {
        elementoHelper = $(this).attr("id");
        $("#" + elementoHelper + "Helper").fadeIn(100);
    });

    $(".helper-field").mouseout(function() {
        $("#" + elementoHelper + "Helper").fadeOut(300);
    });

    $("#uper").change(function() {
        readURL(this, 'principal-editimage');
    });

    $("#uper1").change(function() {
        readURL(this, 'editimage1');
    });

    $("#uper2").change(function() {
        readURL(this, 'editimage2');
    });

    $("#uper3").change(function() {
        readURL(this, 'editimage3');
    });

    $("#uper4").change(function() {
        readURL(this, 'editimage4');
    });

    $("#uper5").change(function() {
        readURL(this, 'editimage5');
    });

    $("#offerNoEnds").change(function() {
        if ($(this).is(":checked")) {
            $("#dateHtmlEnd").val("00/00/0000");
            $("#dateHtmlEnd").attr("disabled", "disabled");
        } else {
            $("#dateHtmlEnd").removeAttr('disabled');
        }
    });

    //executar input file quando imagem for clicada
    $("#principal-editimage").bind('click', function() {
        if ($("#offer_id").val() == "") {
            return showErrorAlert("Salve sua oferta antes de começar a colocar as imagens");
        } else {
            $('#uper').click( );
        }
    });
    $("#editimage1").bind('click', function() {
        if ($("#offer_id").val() == "") {
            return showErrorAlert("Salve sua oferta antes de começar a colocar as imagens");
        } else {
            $('#uper1').click( );
        }
    });
    $("#editimage2").bind('click', function() {
        if ($("#offer_id").val() == "") {
            return showErrorAlert("Salve sua oferta antes de começar a colocar as imagens");
        } else {
            $('#uper2').click( );
        }
    });
    $("#editimage3").bind('click', function() {
        if ($("#offer_id").val() == "") {
            return showErrorAlert("Salve sua oferta antes de começar a colocar as imagens");
        } else {
            $('#uper3').click( );
        }
    });
    $("#editimage4").bind('click', function() {
        if ($("#offer_id").val() == "") {
            return showErrorAlert("Salve sua oferta antes de começar a colocar as imagens");
        } else {
            $('#uper4').click( );
        }
    });
    $("#editimage5").bind('click', function() {
        if ($("#offer_id").val() == "") {
            return showErrorAlert("Salve sua oferta antes de começar a colocar as imagens");
        } else {
            $('#uper5').click( );
        }
    });

    $("#optionIfNotPostOffice").hide();

    $("#postNotOfficeOption").click(function() {
        $("#optionIfNotPostOffice").show();
    });

    $("#postOfficeOption").click(function() {
        $("#optionIfNotPostOffice").hide();
    });

    $("#productWeith").hide();

    $("#offerTypeProduct").click(function() {
        $("#productWeithInputField").addClass("requireFild");
        $("#productWeithInputField").attr("required", true);
        $("#productWeith").show();
        //$("#productFreight").show();
    });

    $("#offerTypeService").click(function() {
        $("#productWeithInputField").removeClass("requireFild");
        $("#productWeithInputField").attr("required", false);
        $("#productWeith").hide();
        //$("#productFreight").fadeOut(0);

    });

    $("#canParcelOfferYes").click(function() {
        $("#parcelOfferPercentage").addClass("requireFild");
        $("#parcelOfferPercentage").attr("required", true);
    });

    $("#canParcelOfferNo").click(function() {
        $("#parcelOfferPercentage").removeClass("requireFild");
        $("#parcelOfferPercentage").attr("required", false);
        $("#parcelOfferPercentage").val("0");
    });

    $("#addOptionOnOffer").click(function() {
        $('#myModalOfferOptions').modal('show');

    });

    $("#mountTableButton").click(function() {
        if ($("#categoryOfferModal").val() === "0" || $("#selectboxY").val() === "0" || $("#selectboxX").val() === "0") {
            var htmlErro = '<div class="well well-sm wellExtraElemnts">Todos os campos são obrigatórios.</div>';
            $('#productOptionsContent').html(htmlErro);
        } else {
            productsOptions();
        }
    });

    $("#targetOffer").click(function() {
        $('#myModalOfferTarget').modal('show');
    });

    $(".glyphicon.glyphicon-remove").click(function() {
        removeImage(this.id);
    });

    $('#resume').summernote({
        height: 150, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear', 'fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    $('#description').summernote({
        height: 150, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear', 'fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    $('#specification').summernote({
        height: 150, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear', 'fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });


    $("#saveProduct").click(function() {
	
        //alert("PASSO 1");
        if (validadeMinimalFilds()) {
            //alert("PASSO 2");
            var data = {
                offer_id: $("#offer_id").val(),
                offer_type: $("input[name='data[Offer][extra_infos][offer_type]']:checked").val(),
                weight: $("#productWeithInputField").val(),
                title: $("#OfferTitle").val(),
                resume: $('#resume').code(),
                price: $("#offerPrice").val(),
                price_offer: $("#Offer_discounted_value").val(),
                qtd: $("#offerQtd").val(),
                use_correios_api: $("input[name='data[CompanyPreference][use_correios_api]']:checked").val(),
                delivery_dealine: $("#delivery_dealine").val(),
                delivery_value: $("#delivery_value").val(),
                parcels: $("input[name='data[Offer][parcels]']:checked").val(),
                percentage: $("#parcelOfferPercentage").val(),
                begins_at: $("#dateHtmlBegin").val(),
                ends_at: $("#dateHtmlEnd").val(),
                description: $('#description').code(),
                specification: $('#specification').code(),
                sku: $("#offer_sku").val(),
				parcels_quantity: $("#parcels_quantity").val(),
				selectedServiceId: $("#selectedServiceId").val()
            };
            $.ajax({
                url: getControllerPath("Product") + "addEditBasicOfferInformation",
                type: "POST",
                data: data
            }).done(function(msg) {
                console.log(msg);
                var arr_from_json = JSON.parse(msg);
                if (arr_from_json.status === 'SAVE_OK') {
                    //alert("PASSO 4");
                    if (showSuccessAlert()) {
                        //alert("PASSO 5");
                        window.location.replace(getControllerPath("Product") + "productManipulation/" + arr_from_json.data.Offer.id);
                    }
                } else {
                    //alert("PASSO 6");
                    return showErrorAlert("Não foi possivel realizar sua requisição. Tente novamente mais tarde.", "Bad, bad server. No donuts for you!");
                }
                //alert("PASSO 7");
            });
        }
        return false;

    });


    $("#myModalOfferOptions").on("submit", "#offerFormOptions", function() {
        var offerId = $("#offer_id").val();
        var actionUrl = getControllerPath("Product") + "saveOptions";
        $('#offerFormOptions').attr('action', actionUrl);
        $('<input>').attr({type: 'hidden', value: offerId, name: 'offerId'}).appendTo('#offerFormOptions');
        return true;
    });

    $("#myModalOfferTarget").on("submit", "#offerTargetOptions", function() {
        var offerId = $("#offer_id").val();
        var actionUrl = getControllerPath("Product") + "saveFilters";
        $('#offerTargetOptions').attr('action', actionUrl);
        $('<input>').attr({type: 'hidden', value: offerId, name: 'offerId'}).appendTo('#offerTargetOptions');
        return true;
    });

    lastFormConfiguration();
	
	
	//mostra ou esconde quantidade de parcelas permitidas
	$("#canParcelOfferYes").click(function(){
		$("#qtdParcelasPermitidas").fadeIn(200);
	});
	
	$("#canParcelOfferNo").click(function(){
		$("#qtdParcelasPermitidas").fadeOut(200);
	});
	
	$("#offerTypeService").click(function(){
		
		//$("#saveProduct").prop("disabled", "true");
		
	});
	
		$("#dateHtmlEnd").onkeyup(function(){
		 var v = this.value;
		 alert(v);
/*        if (v.match(/^\d{2}$/) !== null) {
            this.value = v + '/';
        } else if (v.match(/^\d{2}\/\d{2}$/) !== null) {
            this.value = v + '/';
        }
*/	});
	
});

function lastFormConfiguration() {

    if ($('#dateHtmlBegin').val() === "") {
       // $('#dateHtmlBegin').val(returnTodayDateDatabaseFormat());
	   
	   var m = moment().format('DD/MM/YYYY');
	   //alert(m);
	   $('#dateHtmlBegin').val(m);
	
    }

    if ($("#offer_type_jquery").val() !== "") {
        if ($("#offer_type_jquery").val() === "PRODUCT") {
            $("#offerTypeProduct").trigger("click");
        } else {
            $("#offerTypeService").trigger("click");
        }
    }

    if ($("#offer_parcels_jquery").val() !== "") {
        if ($("#offer_parcels_jquery").val() === "INACTIVE") {
            $("#canParcelOfferNo").trigger("click");
        } else {
            $("#canParcelOfferYes").trigger("click");
        }
    }

    if ($("#use_correios_api_jquery").val() !== "") {
        if ($("#use_correios_api_jquery").val() === "CORREIO") {
            $("#postOfficeOption").trigger("click");
        } else {
            $("#postNotOfficeOption").trigger("click");
        }
    }

    if ($("#selectboxY").val() != 0 && $("#selectboxX").val() != 0 && $("#categoryOfferModal").val() != 0) {
        productsOptions();
    }

}

function validadeMinimalFilds() {
    if (!$("input[name='data[Offer][extra_infos][offer_type]']").is(":checked")) {
        return showErrorAlert("Campo " + $("input[name='data[Offer][extra_infos][offer_type]']").attr("placeholder") + " é obrigatório.");
    }
    if ($("input[name='data[Offer][extra_infos][offer_type]']:checked").val() === "PRODUCT") {
        if ($("#productWeithInputField").val() === "") {
            return showErrorAlert("Campo " + $("#productWeithInputField").attr("placeholder") + " é obrigatório.");
        }
    }
    if ($("#OfferTitle").val() === "") {
        return showErrorAlert("Campo " + $("#OfferTitle").attr("placeholder") + " é obrigatório.");
    }
    if ($('#resume').code() === "") {
        return showErrorAlert("Campo Resumo é obrigatório.");
    }
    if ($("#offerPrice").val() === "") {
        return showErrorAlert("Campo " + $("#offerPrice").attr("placeholder") + " é obrigatório.");
    }
    if ($("#offerQtd").val() === "") {
        return showErrorAlert("Campo " + $("#offerQtd").attr("placeholder") + " é obrigatório.");
    }
    if ($("input[name='data[CompanyPreference][use_correios_api]']:checked").val() === "2") {
        if ($("#delivery_dealine").val() === "") {
            return showErrorAlert("Campo " + $("#delivery_dealine").attr("placeholder") + " é obrigatório.");
        }
        if ($("#delivery_value").val() === "") {
            return showErrorAlert("Campo " + $("#delivery_value").attr("placeholder") + " é obrigatório.");
        }
    }
    if (!$("input[name='data[Offer][parcels]']").is(":checked")) {
        return showErrorAlert("Campo " + $("input[name='data[Offer][parcels]']").attr("placeholder") + " é obrigatório.");
    }
    if ($("input[name='data[Offer][parcels]']:checked").val() === "ACTIVE") {
        if ($("#parcelOfferPercentage").val() === "") {
            return showErrorAlert("Campo " + $("#parcelOfferPercentage").attr("placeholder") + " é obrigatório.");
        }
    }
    return true;
}

function showErrorAlert(mesage, msgHeader) {
    if (msgHeader != null && msgHeader != "" && msgHeader != undefined) {
        $("#errorModalHeader").html(msgHeader);
    }
    $("#modelContent").removeClass("textCenterModal");
    $("#alertContent").html(mesage);
    $('#divMessageErrorOffer').modal('show');
    return false;
}

function showSuccessAlert() {
    $("#modelContent").addClass("textCenterModal");
    $("#modelContent").html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Salvo com sucesso');
    $('#divMessageErrorOffer').modal('show');
    return true;
}

function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#' + id).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
        sendImage(id, input.files[0]);
    }
}

function sendImage(id, input) {
    console.log("PASSO 1");
    var dataForm = new FormData();
    if (id === "principal-editimage") {
        dataForm.append("sendImageFirst", input);
        console.log("PASSO 2");
    } else {
        dataForm.append("sendImage", input);
        dataForm.append("photo_id", $('#' + id).attr('photo_id'));
    }
    console.log("PASSO 3");
    dataForm.append("offerId", $("#offer_id").val());
    console.log("PASSO 4");
    $('#loading').show();
    $.ajax({
        url: getControllerPath("Product") + "uploadOfferImage",
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        data: dataForm
    }).done(function(msg) {
        console.log("PASSO 5");
        $('#loading').hide();
        if (msg !== 'false') {
            if (showSuccessAlert()) {
                window.location.replace(getControllerPath("Product") + "productManipulation/" + $("#offer_id").val());
            }
        } else {
            return showErrorAlert("Não foi possivel realizar sua requisição. Tente novamente mais tarde.", "Bad, bad server. No donuts for you!");
        }
    });
}

function removeImage(id) {
    var data = {
        offer_id: $("#offer_id").val(),
        photo_id: id
    };
    $.ajax({
        url: getControllerPath("Product") + "removeImage",
        type: "POST",
        data: data
    }).done(function(msg) {
        if (msg !== 'false') {
            console.log(msg);
            if (showSuccessAlert()) {
                window.location.replace(getControllerPath("Product") + "productManipulation/" + $("#offer_id").val());
            }
        } else {
            return showErrorAlert("Não foi possivel realizar sua requisição. Tente novamente mais tarde.", "Bad, bad server. No donuts for you!");
        }
    });
}

function productsOptions() {
    eixoY = $("#selectboxY").val();
    eixoX = $("#selectboxX").val();
    $.ajax({
        method: "POST",
        url: getControllerPath("Product") + "productOptionsTable",
        data: {col: eixoY, line: eixoX, offerId: $("#offer_id_modal").val(), category: $("#categoryOfferModal").val()}
    }).done(function(msg) {
        if (msg !== 'false') {
            $('#productOptionsContent').html(msg);
        } else {
            return showErrorAlert("Não foi possivel realizar sua requisição. Tente novamente mais tarde.", "Bad, bad server. No donuts for you!");
        }
    }).error(function(XMLHttpRequest, textStatus, errorThrown) {
        //alert(errorThrown);
    });
}

function clickInSearch(elementValue, id, valor) {
	
	$("#selectedServiceId").val(id);
	$("#saveProduct").removeProp( "disabled" );
    $('#search-return').fadeOut(200);
    $("#OfferTitle").val(elementValue);
	
	//$("#offerPrice").val(valor);
	
}