     
			<div class="modal-body">
				<div class=" row">
				<div class="col-md-12">
				<h5>Cliente</h5>
					 <div class="col-md-3">
					 <img src="../portal/app/img/jezzy_images/user.png"  class="schedule-detail"/></div>
					 <div class="col-md-9" >
						<span class='label'><?php echo  $schedule[0]['schedules']['client_name'];?></span><br/>
						<small><?php  echo $schedule[0]['schedules']['client_phone'];?></small><br/>
					 
					 </div>
				</div>
				</div>
				<hr />
				<div class=" row">
				<div class="col-md-12">
				<h5>Profissional</h5>
					 <div class="col-md-3">
					 <img src="../portal/app/img/jezzy_images/professional.jpg"  class="schedule-detail"/></div>
					 <div class="col-md-9" >
						<span class='label'><?php  echo $schedule[0]['secondary_users']['name'];?></span><br/>
						<span class="labely label-success">Funcionário</span><br/>
						<span><small><a href="mailto:<?php echo  $schedule[0]['secondary_users']['email'];?>"><?php  echo $schedule[0]['secondary_users']['email'];?></a></small></span><br/>

					 </div>
				</div>
				</div>
				
				<hr />
				<div class=" row">
					<div class="col-md-12">
					<h5>Serviço</h5>
						<div class="col-md-12" >
							<span class='label'><?php echo $schedule[0]['schedules']['subclasse_name'];?></span><br/>
							<span class='label'>Data: </span><?php $data =  explode("-",$schedule[0]['schedules']['date']); echo $data[2]."/".$data[1]."/".$data[0];?><br/>
							<span class='label'>Ínicio: </span><?php echo  $schedule[0]['schedules']['time_begin'];?><br/>
							<span class='label'>Término: </span><?php echo  $schedule[0]['schedules']['time_end'];?><br/>
							<span class="label">TOTAL: </span>R$<?php echo $schedule[0]['schedules']['valor'];?>
						</div>
					</div>
				</div>
			</div>
    