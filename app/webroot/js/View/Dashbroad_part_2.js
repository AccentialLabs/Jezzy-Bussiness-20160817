
function sendEmailDefaultBirthday(){
		
		$(".loading").fadeIn(200);
		var typeSend = $("#birthdaySendEmail").val();
		if(typeSend == 'birthdayDefaultLayoutEmail'){
		
			var userId = $("#UserBirthdaySelected").val();
			var userEmail = $("#UserBirthdaySelectedEmail").val();
			
			
			  $.ajax({
                type: "POST",
                data: {
                    id: userId,
                    userEmail: userEmail
                },
                url: "/../jezzy-portal/dashboard/ajaxDefaultEmailBirthday",
                success: function(result) {
					
					$("#sucessEmailMsg").html("<h5>Email enviado com sucesso!</h5>");
					$(".loading").fadeOut(200);

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("ERROR");
                }
            });
			
		}
	
}