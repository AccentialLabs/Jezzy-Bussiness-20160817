$(document).ready(function () {

    $("#uper").change(function () {
        readURL(this, 'principal-editimage');
    });

    $("#uper1").change(function () {
        readURL(this, 'editimage1');
    });

    $("#uper2").change(function () {
        readURL(this, 'editimage2');
    });

    $("#uper3").change(function () {
        readURL(this, 'editimage3');
    });

    $("#uper4").change(function () {
        readURL(this, 'editimage4');
    });

    $("#uper5").change(function () {
        readURL(this, 'editimage5');
    });

    //executar input file quando imagem for clicada
    $("#principal-editimage").bind('click', function () {
        $('#uper').click( );
    });
    $("#editimage1").bind('click', function () {
        $('#uper1').click( );
    });
    $("#editimage2").bind('click', function () {
        $('#uper2').click( );
    });
    $("#editimage3").bind('click', function () {
        $('#uper3').click( );
    });
    $("#editimage4").bind('click', function () {
        $('#uper4').click( );
    });
    $("#editimage5").bind('click', function () {
        $('#uper5').click( );
    });

    $("#selectboxX").change(function () {
        showTableOptions();
    });

    $("#selectboxY").change(function () {
        showTableOptions();
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

    $('#datePickerBegin').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true

    });

    $('#datePickerEnd').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $("#offer_discounted_value").keyup(function () {
        var original = $("#offer_value").val().replace(".", "").replace(",", ".");
        var newValue = $("#offer_discounted_value").val().replace(".", "").replace(",", ".");
        var discount = 100 - (newValue / original) * 100;
        $("#offer_percentage_discount").val(discount);
        $("#percentage_discount").html(Math.floor(discount));
    });

    $("#offerForm").submit(function (event) {

        if ($("#radioSenderMethod2").is(":checked")) {
            $('#delivery_dealine').addClass("require");
            $('#delivery_dealine').addClass("require");
        }
        if ($("#radioSenderMethod1").is(":checked")) {
            $('#delivery_dealine').removeClass("require");
            $('#delivery_dealine').removeClass("require");
        }

        if (!$("input[name='data[Offer][public]']").is(":checked")) {
            event.preventDefault();
            return showErrorAlert("Campo " + $("input[name='data[Offer][public]']").attr("placeholder") + " é obrigatório.");
        }

        if (!$("input[name='data[Offer][extra_infos][offer_type]']").is(":checked")) {
            event.preventDefault();
            return showErrorAlert("Campo " + $("input[name='data[Offer][extra_infos][offer_type]']").attr("placeholder") + " é obrigatório.");
        }

        $(":input.require").each(function () {
            if ($.trim(this.value) === "") {
                event.preventDefault();
                return showErrorAlert("Campo " + this.placeholder + " é obrigatório.");
            }
        });

        if ($('#description').code() === "") {
            event.preventDefault();
            return showErrorAlert("Campo Descrição é obrigatório.");
        } else {
            $('<input />')
                    .attr('type', 'hidden')
                    .attr('name', "data[Offer][description]")
                    .attr('value', $('#description').code())
                    .appendTo(this);
        }

        if ($('#specification').code() === "") {
            event.preventDefault();
            return showErrorAlert("Campo Especificação é obrigatório.");
        } else {
            $('<input />')
                    .attr('type', 'hidden')
                    .attr('name', "data[Offer][specification]")
                    .attr('value', $('#specification').code())
                    .appendTo(this);
        }

        if ($("input[name='data[Offer][extra_infos][category_id]']").val() === 0) {
            event.preventDefault();
            return showErrorAlert("Campo Especificação é obrigatório.");
        }

        return true;

    });


});


function deletePhoto(id) {
    var control = $("#upser" + id);
    control.replaceWith(control = control.clone(true));
    $('#editimage' + id).attr('src', '../img/adv/Nova Oferta/Adventa Icones Empresas-14.png');

}

function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + id).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function showErrorAlert(mesage) {
    $("#alertContent").html(mesage);
    $('.bs-example-modal-sm').modal('show');
    return false;
}

function showTableOptions() {
    eixoY = $("#selectboxY").val();
    eixoX = $("#selectboxX").val();
    if(eixoY === "false"|| eixoX === "false"){
        return false;
    }
    $.ajax({
        method: "POST",
        url: getControllerPath("Product") + "productOptionsTable",
        data: {col: eixoY, line: eixoX, offerId: $("#offerId").val()}
    }).done(function (result) {
        $('#recebe').html(result);
    }).error(function (XMLHttpRequest, textStatus, errorThrown){
        alert(errorThrown);
    });
}


//table options of product functions
function mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1);
}

function execmascara() {
    v_obj.value = v_fun(v_obj.value);
}

function mvalor(v) {
    v = v.replace(/\D/g, "");//Remove tudo o que não é dígito
    v = v.replace(/(\d)(\d{8})$/, "$1.$2");//coloca o ponto dos milhões
    v = v.replace(/(\d)(\d{5})$/, "$1.$2");//coloca o ponto dos milhares

    v = v.replace(/(\d)(\d{2})$/, "$1,$2");//coloca a virgula antes dos 2 últimos dígitos
    return v;
}

function validar(dom, tipo) {
    var regex = "";
    switch (tipo) {
        case'num':
            regex = /[A-Za-z]/g;
            break;
        case'text':
            regex = /\d/g;
            break;
    }
    dom.value = dom.value.replace(regex, '');
}

function mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1);
}

function execmascara() {
    v_obj.value = v_fun(v_obj.value);
}

function mvalor(v) {
    v = v.replace(/\D/g, "");//Remove tudo o que não é dígito
    v = v.replace(/(\d)(\d{8})$/, "$1.$2");//coloca o ponto dos milhões
    v = v.replace(/(\d)(\d{5})$/, "$1.$2");//coloca o ponto dos milhares

    v = v.replace(/(\d)(\d{2})$/, "$1,$2");//coloca a virgula antes dos 2 últimos dígitos
    return v;
}

function validar(dom, tipo) {
    var regex = "";
    switch (tipo) {
        case'num':
            regex = /[A-Za-z]/g;
            break;
        case'text':
            regex = /\d/g;
            break;
    }
    dom.value = dom.value.replace(regex, '');
}