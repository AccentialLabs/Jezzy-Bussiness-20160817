<meta charset="utf-8">
<?php 
	$user = $allCheckouts['User'];
	$checkouts = $allCheckouts['Checkouts'];
?>

<div class="form-horizontal">
    <div class="form-group notification-body" id="notification-body">
        <div class="col-md-4">
            <img src="<?php echo $user['User']['photo'];?>" class="user-details-photo"/>
        </div>
        <div class="col-md-8">
            <h3><?php echo $user['User']['name'];?></h3>
            <hr />
            <div>
                <div><span class="glyphicon glyphicon-star pull-left"></span> <div class="description-info-user"><?php echo count($checkouts). ' Compras';?></div></div>
                <span class="glyphicon glyphicon-envelope pull-left"></span>  <div class="description-info-user"><?php echo $user['User']['email'];?></div>
                <span class="glyphicon glyphicon-user pull-left"></span> <div class="description-info-user"><?php if($user['User']['gender']=='male'){echo "Masculino"; }else{echo "Feminino";};?></div>
                <span class="glyphicon glyphicon-calendar pull-left"></span> <div class="description-info-user">
							<?php
							
								$birth = explode("-",$user['User']['birthday']);
								if($birth[0] != 0){
							echo $birth[2].'/'.$birth[1].'/'.$birth[0]; }?></div>
                                                        <?php if(!empty($user['User']['address'])){?>
                <span class="glyphicon glyphicon-home pull-left"></span><div class="description-info-user">De <?php echo $user['User']['district'].' - '.$user['User']['city'].'; '. $user['User']['state'];?> </div>
                                                        <?php }?>
            </div>
        </div>
    </div>

    <div>
        <div class="info-user-galery">
            <!--<div class="pull-left quad">
                    <a href="#" class="thumbnail">
                            <img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
                    </a>
                </div>	-->
        </div>
        <div class="panel-group" id="accordion">
            <div class="panel panel-default bordaa">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapseOne">Compras</a>
                    </h4>
                </div>

                <div id="collapseOne" class="panel-collapse collapse">
                    <div class="panel-body" id="panel-body">
                        <div class="checkouts-body col-md-12">

								<?php
								if($checkouts){
								foreach($checkouts as $check){ ?>

                            <div class="col-md-4 checkouts-box">
                                <div class="col-md-12 img-content" >
                                    <img src="<?php echo $check['offers']['photo'];?>" class="checkouts-box-img"/>
                                </div>

                                <div class="col-md-12 checkouts-content">
                                    <div class="checkout-label"><?php echo $check['offers']['title'];?></div>
                                    <hr class="checkouts-divisor"/>

                                    <div class="checkouts-descriptions col-md-12">												
                                        <div>
                                            <div class="col-md-7 checkouts-collums left-collum">
                                                Quantidade:
                                            </div>
                                            <div class="col-md-5 checkouts-collums">
											<?php 
											echo $check['checkouts']['amount'];?>
                                            </div>


                                            <div class="col-md-7 checkouts-collums left-collum">
                                                Pagamento:
                                            </div>
                                            <div class="col-md-5 checkouts-collums">
											<?php 
												switch($check['checkouts']['payment_method_id']){
												case 3:
														echo "Credito Visa";
														break;
												case 5:
														echo "Credito Mast.";
														break;
												case 7:
														echo "Credito Amer.";
														break;
												case 73:
														echo "Boleto Brad.";
														break;
												}
											?>
                                            </div>


                                            <div class="col-md-7 checkouts-collums left-collum">
                                                Data:
                                            </div>
                                            <div class="col-md-5 checkouts-collums">
										<?php 		$t = strtotime($check['checkouts']['date']);
													echo date('d/m/Y',$t);
										?>
                                            </div>

                                            <div class="col-md-7 checkouts-collums left-collum">
                                                Status:
                                            </div>
                                            <div class="col-md-5 checkouts-collums">
											<?php 
												
												switch($check['checkouts']['payment_state_id']){
												case 1:
														echo "AUTORIZAD";
														break;
												case 2:
														echo "INICIADO";
														break;
												case 3:
														echo "BOLETO IMP";
														break;
												case 4:
														echo "CONCLUIDO";
														break;
														
												case 5:
														echo "CANCELADO";
														break;
														
												case 6:
														echo "EM ANALISE";
														break;
														
												case 7:
														echo "ESTORNADO";
														break;
														
												case 8:
														echo "EM REVISAO";
														break;
														
												case 9:
														echo "REEMBOLSADO";
														break;
														
												case 14:
														echo "TRANS. INIC";
														break;
												}
												
											?>
                                            </div>

                                            <div class="col-md-7 checkouts-collums left-collum">
                                                TOTAL:
                                            </div>
                                            <div class="col-md-5 checkouts-collums">
                                                R$ <?php echo str_replace(".", ",", $check['checkouts']['total_value']);?>
                                            </div>
                                        </div>
                                    </div>										
                                </div>
                            </div>
								<?php }}else{?>
                            <div class="col-md-7 checkouts-collums left-collum">
                                Este usuário ainda não efetuou nenhuma compra!
                            </div>
								<?php }?>
                        </div>
                    </div>
                </div>


                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapseTwo">Serviços e Agendamentos</a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body" id="panel-body">


                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>SERVIÇO</th>
                                    <th>DATA</th>
                                    <th>VALOR</th>
                                    <th>PROFISSIONAL</th>
                                    <th>FOTOS</th>
                                    </th>
                            </thead>

                            <tbody>
								<?php 
									if(!empty($schedules)){
								foreach($schedules as $schedule){?>
                                <tr>
                                    <td>
                                        <strong><?php echo $schedule['schedules']['classe_name']; ?></strong><br/>
                                        <span><?php echo $schedule['schedules']['subclasse_name']; ?></span>
                                    </td>
                                    <td>
										<?php $data = explode("-", $schedule['schedules']['date']); echo $data[2].'/'.$data[1].'/'.$data[0]; ?>
                                    </td>
                                    <td>
                                        R$<?php echo $schedule['schedules']['valor']; ?>
                                    </td>
                                    <td>
										<?php echo $schedule['secondary_users']['name']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if(!empty($schedule['photos'])){
                                            foreach ($schedule['photos'] as $photo){?>
                                        <div class="hoverzoom"><img src="<?php echo $photo['services_photos']['photo'];?>" height="100%" width="100%" onclick="showServicePhoto(this)" class="service-photo"/></div>
                                        <?php }}?>
                                    </td>
                                </tr>
								<?php }}?>
                            <tbody>
                                </div>
                                </div>


                                </div>
                                </div>
                                </div>

                                </div>