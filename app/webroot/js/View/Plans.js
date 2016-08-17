var plan = '';
$(function(){

	$("#diverror").fadeOut(0);
	
	$("#btnSubmitPlan").click(function(){
		//var plan = $("#myPlane").val();
		var plan = $("input[name='myPlane']:checked").val();
		
			$.ajax({			
			type: "POST",			
			data:{
				plan:plan
			},			
			url: "/../jezzy-portal/company/planos",
			success: function(result){	
				
				var jsonReturn = JSON.parse(result);
				
				console.log(jsonReturn);
					$("#CompanyResponsibleName").html(jsonReturn.companies.responsible_name);
					$("#CompanySelectedPlan").html(plan);
					
					if(plan == 'STANDARD'){
						$("#CompanySelectedPlanValue").html('R$149,80');
					}else if(plan == 'PREMIUM'){
						$("#CompanySelectedPlanValue").html('R$249,80');
					}
					
					$("#myModalCard").modal();
				//window.location = "https://secure.jezzy.com.br/jezzy-portal/Login";
				
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
		}
	  });
		
	});
	
	
	$("#btnSubmitBuyPlan").click(function(){
		
		var planName = $("#myPlane").val();
		var planCode = '';
		
		if(planName == 'STANDARD'){
			planCode = 'standard';
		}else if(planName == 'PREMIUM'){
				planCode = 'premium';
		}
		
		$.ajax({			
			type: "POST",			
			data:{
				nameFromCard: $("#nameFromCard").val(),
				numberCard: $("#numberCard").val(),
				monthExpirationCard: $("#monthExpirationCard").val(),
				yearExpirationCard: $("#yearExpirationCard").val(),
				planName: planName,
				planCode: planCode
			},			
			url: "/../jezzy-portal/company/createPlansSignatureMoIP",
			success: function(result){	
				
				
				//alert(result);
				
				var jsonReturn = JSON.parse(result);
				console.log(jsonReturn);
				
				if(jsonReturn.errors.length != 0){
				
					$("#error-message").html(jsonReturn.errors[0].description);
					$("#diverror").fadeIn(0);
					$("#myModalCard").modal();
					
				}else{
					window.location = "https://secure.jezzy.com.br/jezzy-portal/Login";
				}
				
				//window.location = "https://secure.jezzy.com.br/jezzy-portal/Login";
				
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
		}
	  });
	
	});

});