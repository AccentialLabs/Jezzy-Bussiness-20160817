$(document).ready(function () {
    $("#menuBusinessIcon").hide();
    resizeAllWindown();
});

jQuery(window).resize(function () {
    resizeAllWindown();
});

function resizeAllWindown(){
    var width = jQuery(window).width();
    if (width > 800) {
        $("#menuBusinessIcon").hide();
        $("#menuBusinessFull").show();
        
        $("#mainBusiness").removeClass("margirCorrectBootstrap col-sm-11 col-sm-offset-1 col-md-11 col-md-offset-1");
        $("#mainBusiness").addClass("col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2");
        
        $("#menuBusiness").removeClass("col-sm-1 col-md-1");
        $("#menuBusiness").addClass("col-sm-3 col-md-2");
    } else {
        $("#menuBusinessIcon").show();
        $("#menuBusinessFull").hide();

        $("#mainBusiness").removeClass("col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2");
        $("#mainBusiness").addClass("margirCorrectBootstrap col-sm-11 col-sm-offset-1 col-md-11 col-md-offset-1");

        $("#menuBusiness").removeClass("col-sm-3 col-md-2");
        $("#menuBusiness").addClass("col-sm-1 col-md-1");
    }
}