
$(function(){


	$("#btnNewSchedule").click(function(){

		var time = $("#repeatScheduleHour").val();
		var chooseDay = $("#repeatScheduleDate").val();
		var service= 	$("#repeatService").val();
		var price =	$("#repeatPrice").val();
		var client =	$("#repeatClient").val();
		var phone =	$("#repeatPhone").val();
		var userId =	$("#repeatUserId").val();
		var secondaryId =	$("#repeatSecondaryID").val();
			
			
		$.ajax({
        method: "POST",
        url: "/../jezzy-portal/schedule/ajaxAddSchedule",
        data: {Schedule: {
                schedulehour: time,
                serviceId: service,
                schedulePrice: price,
                scheduleClient: client,
                schedulePhone: phone,
                scheduleSecondaryUser: secondaryId,
                scheduleDate: chooseDay,
				userId: userId
            }
        },
		success: function(result){	
			alert("sucesso");
		$('#myModalRepeatSchedule').modal('toggle');
	$('#myModalRepeatSchedule').modal('hide');
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert("ERROR: " + textStatus);
		}
    }); 
	
	
			
		});
	
});

function showUserDetail(id){
		
	$.ajax({			
			type: "POST",			
			data:{
				userId:id
			},			
			url: "/../jezzy-portal/clientReport/getClienteDetail",
			success: function(result){	
				
			$("#recebe-user-details").html(result);
			$('#myModalUserDetails').modal('toggle');
			 $('#myModalUserDetails').modal('show');
			
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert("Houve algume erro no processamento dos dados desse usuário, atualize a página e tente novamente!");
		}
	  });
	
}

function showScheduleDetail(id){
	
	$.ajax({			
			type: "POST",			
			data:{
				checkoutId:id
			},			
			url: "/../jezzy-portal/scheduleReport/getScheduleDetail",
			success: function(result){	
				
				//alert(result);
			$("#recebe").html(result);
			$('#myModalSchedulesRequisitions').modal('toggle');
			 $('#myModalSchedulesRequisitions').modal('show');
			
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert("Houve algume erro no processamento dos dados dessa compra, atualize a página e tente novamente!");
		}
	  });
}

function addNewSchedule(service, price, client, phone, userId, secondaryID) {
	$("#repeatService").val(service);
	$("#repeatPrice").val(price);
	$("#repeatClient").val(client);
	$("#repeatPhone").val(phone);
	$("#repeatUserId").val(userId);
	$("#repeatSecondaryID").val(secondaryID);
	
	$('#myModalRepeatSchedule').modal('toggle');
	$('#myModalRepeatSchedule').modal('show');

}


