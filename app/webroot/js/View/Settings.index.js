$(document).ready(function () {

    $("#useAPI").change(function () {
        $("#sendTax").hide();
    });

    $("#dontUseAPI").change(function () {
        $("#sendTax").show()();
    });

    $("#comp-logo-preview").on('click', function () {
        $("#comp-logo-upper").click();
    });

    $("#comp-logo-upper").change(function () {
        readLogoURL(this);
    });

    $("#file-img").change(function () {
        readURL(this);
    });

});

function readLogoURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#comp-logo-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#back-comp-img').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}