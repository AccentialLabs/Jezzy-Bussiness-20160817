		$(function(){

			//SUBMITAR FORMULARIO SEM DAR REFRESH
				$("#companyform").submit(function(e) {
			e.preventDefault();
		});


			$("#btnSubmit").prop("disabled",true);
			
			//ativa botão CADASTRAR caso o checkbox seja clicado (EU NAO SOU UM ROBO)
			$("#notRobot").change(function(){
				
				if ($("#notRobot").is(':checked')) {
					$("#btnSubmit").prop("disabled",false);
				}else{
					$("#btnSubmit").prop("disabled",true);
				}
			
			});
			

			$("#responsibleEmailMsgError").fadeOut();
			$("#emailMsgError").fadeOut();
			$("#cpfMsgError").fadeOut();
			$("#cnpjMsgError").fadeOut();

			$(".registerCompanyCNPJ").keyup(function(){
				
				var cnpj = $(".registerCompanyCNPJ").val();
				var isValid = validarCNPJ(cnpj);
				
				if(isValid == false){
					$(".registerCompanyCNPJ").css({"border":"1px solid red"});
					$("#cnpjMsgError").fadeIn();
					//$("#btnSubmit").prop("disabled",true);
					$("#btnSubmit").fadeOut();
				}else if(isValid == true){
					$(".registerCompanyCNPJ").css({"border":"1px solid green"});
					//$("#btnSubmit").prop("disabled",false);
					$("#btnSubmit").fadeIn()
					$("#cnpjMsgError").fadeOut();
					
					/**
				* Verifica se alguma outra empresa utiliza esse cnpj
				**/
				if(cnpj.length == 18){
				
					$.ajax({			
					type: "POST",			
					data:{
						cnpj:cnpj
					},			
					url: "/../jezzy-portal/company/verifyExistentCNPJ",
					success: function(result){	
											
						if(result == false){
							$(".registerCompanyCNPJ").css({"border":"1px solid green"});
							$("#btnSubmit").fadeIn();
							$("#cnpjMsgError").fadeOut();
						}else{
							$(".registerCompanyCNPJ").css({"border":"1px solid red"});
							$("#cnpjMsgError").html("Este CNPJ já está sendo utilizado");
							$("#cnpjMsgError").fadeIn();
							$("#btnSubmit").fadeOut();
						}
						
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
				}
			  });
				
				}
					
				}
				
				
				
			});
			
			$(".registerCompanyCPF").keyup(function(){
			
				var cpf = $(".registerCompanyCPF").val().replace(".", "").replace("-", "").replace(".", "");
				var isValid = TestaCPF(cpf);
				
				if(isValid == false){
				console.log("nao valido: " + cpf);
					$(".registerCompanyCPF").css({"border":"1px solid red"});
					//$("#btnSubmit").prop("disabled",true);
					$("#btnSubmit").fadeOut();
					$("#cpfMsgError").fadeIn();
				}else if(isValid == true){
						console.log("valido: " + cpf);
					$(".registerCompanyCPF").css({"border":"1px solid green"});
					//$("#btnSubmit").prop("disabled",false);
					$("#btnSubmit").fadeIn();
					$("#cpfMsgError").fadeOut();
				}
			});
			
			$(".registerCompanyEmail").keyup(function(){
				
				var email = $(".registerCompanyEmail").val();
				
					$.ajax({			
					type: "POST",			
					data:{
						email:email
					},			
					url: "/../jezzy-portal/company/verificaEmailCompany",
					success: function(result){	
						
						if(result == false){
							$(".registerCompanyEmail").css({"border":"1px solid green"});
							//$("#btnSubmit").prop("disabled",false);
							$("#btnSubmit").fadeIn();
							$("#emailMsgError").fadeOut();
						}else{
							$(".registerCompanyEmail").css({"border":"1px solid red"});
							//$("#btnSubmit").prop("disabled",true);
							$("#btnSubmit").fadeOut();
							$("#emailMsgError").fadeIn();
						}
						
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
				}
			  });
			
			});
			
			$(".registerCompanyResponsibleEmail").keyup(function(){
			
				var email = $(".registerCompanyResponsibleEmail").val();
				
					$.ajax({			
					type: "POST",			
					data:{
						email:email
					},			
					url: "/../jezzy-portal/company/verificaEmailCompany",
					success: function(result){	
						
						if(result == false){
							$(".registerCompanyResponsibleEmail").css({"border":"1px solid green"});
							//$("#btnSubmit").prop("disabled",false);
							$("#btnSubmit").fadeIn();
							$("#responsibleEmailMsgError").fadeOut();
						}else{
							$(".registerCompanyResponsibleEmail").css({"border":"1px solid red"});
							//$("#btnSubmit").prop("disabled",true);
							$("#btnSubmit").fadeOut();
							$("#responsibleEmailMsgError").fadeIn();
						}
						
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
				}
			  });
			
			});

			$(".phone").mask("(00) 0000-00009");
			
			$(".cnpj").mask("99.999.999/9999-99");
			
			$(".cpf").mask("999.999.999-99");
			
			$(".registerCompanyResponsibleBirthday").mask("00/00/0000");
			
			$("#cep").keyup(function(){
				var zipcode = $("#cep").val();                                             
				
				
				
				if(zipcode.length == 8){
				$("#loading-addres").fadeIn();
				
					$.ajax({			
					type: "GET",			
					data:{
						//cep:zipcode
					},			
					url: "https://api.postmon.com.br/v1/cep/"+zipcode,
					success: function(result){	
						//alert(result);
						console.log(result);
						 //var objReturn = JSON.parse(result);
						 //var objReturn = jQuery.parseJSON(result);
						 //console.log(objReturn);
						 
						 $("#bairro").val(result.bairro);
						 $("#localidade").val(result.cidade);
						 $("#logradouro").val(result.logradouro);
						 $("#uf").val(result.estado);
						 
						 $("#loading-addres").fadeOut(200);
					
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
				}
			  });
				}
			});
			
			$("#btnSubmit").click(function(){
				$("#loading").fadeIn();
			});
			
			
			
		});

		function TestaCPF(strCPF) {

			var Soma;
			var Resto;
			Soma = 0;
			if (strCPF == "00000000000")
				return false;
			for (i = 1; i <= 9; i++)
				Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
			Resto = (Soma * 10) % 11;
			if ((Resto == 10) || (Resto == 11)) Resto = 0;
			if (Resto != parseInt(strCPF.substring(9, 10)))
				return false;
			Soma = 0;
			for (i = 1; i <= 10; i++)
				Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
			Resto = (Soma * 10) % 11;
			if ((Resto == 10) || (Resto == 11)) Resto = 0;
			if (Resto != parseInt(strCPF.substring(10, 11)))
				return false;
			return true;
		}

		function validarCNPJ(cnpj) {
		 
			cnpj = cnpj.replace(/[^\d]+/g,'');
		 
			if(cnpj == '') return false;
			 
			if (cnpj.length != 14)
				return false;
		 
			// Elimina CNPJs invalidos conhecidos
			if (cnpj == "00000000000000" || 
				cnpj == "11111111111111" || 
				cnpj == "22222222222222" || 
				cnpj == "33333333333333" || 
				cnpj == "44444444444444" || 
				cnpj == "55555555555555" || 
				cnpj == "66666666666666" || 
				cnpj == "77777777777777" || 
				cnpj == "88888888888888" || 
				cnpj == "99999999999999")
				return false;
				 
			// Valida DVs
			tamanho = cnpj.length - 2
			numeros = cnpj.substring(0,tamanho);
			digitos = cnpj.substring(tamanho);
			soma = 0;
			pos = tamanho - 7;
			for (i = tamanho; i >= 1; i--) {
			  soma += numeros.charAt(tamanho - i) * pos--;
			  if (pos < 2)
					pos = 9;
			}
			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			if (resultado != digitos.charAt(0))
				return false;
				 
			tamanho = tamanho + 1;
			numeros = cnpj.substring(0,tamanho);
			soma = 0;
			pos = tamanho - 7;
			for (i = tamanho; i >= 1; i--) {
			  soma += numeros.charAt(tamanho - i) * pos--;
			  if (pos < 2)
					pos = 9;
			}
			resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
			if (resultado != digitos.charAt(1))
				  return false;
				   
			return true;  
		}

		function VerificaCPF(strCpf) {

		var soma;
		var resto;
		soma = 0;
		if (strCpf == "00000000000") {
			return false;
		}

		for (i = 1; i <= 9; i++) {
			soma = soma + parseInt(strCpf.substring(i - 1, i)) * (11 - i);
		}

		resto = soma % 11;

		if (resto == 10 || resto == 11 || resto < 2) {
			resto = 0;
		} else {
			resto = 11 - resto;
		}

		if (resto != parseInt(strCpf.substring(9, 10))) {
			return false;
		}

		soma = 0;

		for (i = 1; i <= 10; i++) {
			soma = soma + parseInt(strCpf.substring(i - 1, i)) * (12 - i);
		}
		resto = soma % 11;

		if (resto == 10 || resto == 11 || resto < 2) {
			resto = 0;
		} else {
			resto = 11 - resto;
		}

		if (resto != parseInt(strCpf.substring(10, 11))) {
			return false;
		}

		return true;
		}
