<?php echo $this->Html->css('View/Schedule.index', array('inline' => false)); ?>
<?php echo $this->Html->script('util', array('inline' => false)); ?>
<?php echo $this->Html->script('View/Schedule.index', array('inline' => false)); ?>
<h1 class="page-header" id="code" style="margin-top: -38px;">Tabela de Agendamentos</h1>

<div class="">
    <div class="col-md-12">
	<div>
		<span class="fontTextTopTargetOffer">
			<a href="scheduleReport">Ver relatórios de agendamentos...</a>
		</span>
	</div>
	<br/>
        <div class="btn-group">
		<label for="dateSchedule">Filtrar data de agendamento</label>
            <input name="dateSchedule" id="dateSchedule" type="date" class="form-control" id="dateSchedule"/>
        </div>
	</div>
		
	<div class="col-md-12">
	<br/>
        Funcionarios: <br/>

        <?php
        if (isset($secundary_users)) {
            foreach ($secundary_users as $secundary_user) {
			$secSplit = split(" ", $secundary_user['secondary_users']['name']);
                echo '
                    <div class="btn-group">
                        <button name="employee" type="button" class="btn btn-primary" id="' . $secundary_user['secondary_users']['id'] . '" title="' . $secundary_user['secondary_users']['name'] . '">' . $secSplit[0] . '</button>
                    </div>';
            }
        }
        ?>
        <div class="btn-group">
            <button name="limpar" type="button" class="btn-sm btn-default " id="limpar">Limpar</button>
        </div>
    </div>

</div>
<div class="row" id="columnsSchecule">
    <div class="col-md-3 marginTop15" id="colSchedule_1">

    </div>
    <div class="col-md-3 marginTop15" id="colSchedule_2">

    </div>
    <div class="col-md-3 marginTop15 " id="colSchedule_3">

    </div>
    <div class="col-md-3 marginTop15" id="colSchedule_4">

    </div>
</div>

<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" >
        <div class="modal-content" id="modelContent">
            <div class="modal-body">
                <div class="form-horizontal">
                    <legend>Agendamento</legend>
								
					<div class="form-group">
                        <div class="col-sm-12">
							<label for="dateSchecule">Data</label>
                            <input type="date" class="form-control" id="dateSchecule" placeholder="Data">
                        </div>
                    </div>
										
                    <div class="form-group">
                        <div class="col-sm-12">
							<label for="initialTimeSchecule">Horário</label>
                            <input type="time" class="form-control" id="initialTimeSchecule" placeholder="Hora inicial">
                        </div>
                    </div>
		
                    <div class="form-group">
                        <div class="col-sm-12">
						<label for="serviceSchedule">Serviço a ser prestado</label>
                            <select class="form-control" id="serviceSchedule">
                                <option value="0" selected>Serviço</option>
                                <?php
                                if (isset($services)) {
                                    foreach ($services as $sevice) {
                                        echo '<option value="' . $sevice['services']['id'] . '">' . $sevice['subclasses']['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
						<label for="valueSchedule">Valor do Serviço</label>
						
							<div class="input-group">
									<span class="input-group-addon">R$</span>
									<input id="valueSchedule" type="number" class="form-control"  placeholder="Valor"  aria-label="Amount (to the nearest dollar)">
									
							</div>
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
						<label for="clientSchedule">Nome do Cliente</label>
                            <input id="clientSchedule" type="text" class="form-control" placeholder="Nome do cliente">
							<div class="content-names" id="content-names">
								
							</div>
                        </div>
						
                    </div>
					
					<div class="form-group">
						<div class="col-sm-12">
							<a href="#" class="see-user-profile" id="user-profile-link" onclick="showUserDetail()">ver perfil do cliente</a>
						</div>
					</div>
					
					<div class="form-group">
                        <div class="col-sm-12">
						<label for="emailSchedule">Email do Cliente</label>
                            <input id="emailSchedule" type="text" class="form-control" placeholder="Email do cliente">
                        </div>
                    </div>
					
                    <div class="form-group">
                        <div class="col-sm-12">
						<label for="phoneSchedule">Telefone do Cliente</label>
                            <input id="phoneSchedule" maxlength="15"  type="tel" class="form-control numbersOnly"  placeholder="Telefone do cliente">
                        </div>
						<br/><br/>
						<div class="col-sm-12">
                            <input id="newUserSchedule"  type="checkbox" class="checkbox pull-left" checked="checked">
							<span class="pull-left"> Novo Cliente</span>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 buttonLocation">
                                <input type="hidden" name="userId" id="userId" value="" />
								<input type="hidden" name="secondUserId" id="secondUserId" value="" />
                                <button type="button" class="btn btn-success" id="btnNewSchedule">Agendar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DETALHE DE USUÁRIO -->
<div id="myModalUserDetails" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md" >
        <div class="modal-content" id="modelContent">
            <div class="modal-body">
			<form action="<?php echo $this->Html->url("addSubclass"); ?>" method="post">
			<legend>Detalhes do Usuário</legend>
                <div class="form-horizontal" id="recebe">
                    
                    <div class="form-group notification-body" id="notification-body">
                      <div class="col-md-4">
						<img src="http://coolspotters.com/files/photos/95058/jorge-garcia-profile.jpg" class="user-details-photo"/>
					  </div>
					  <div class="col-md-8">
						<h3>Jorge Michael</h3>
						<hr />
						<div>
							<span class="glyphicon glyphicon-envelope pull-left"></span>  <div class="description-info-user">jorge@michael.com</div>
							<span class="glyphicon glyphicon-user pull-left"></span> <div class="description-info-user">Masculino</div>
							<span class="glyphicon glyphicon-calendar pull-left"></span> <div class="description-info-user">11/08/1994</div>
							<span class="glyphicon glyphicon-home pull-left"></span><div class="description-info-user">De Ferraz de Vasconcelos - São Paulo, Rua Hermenegildo Barreto, 120 - 08540-500</div>
						</div>
					  </div>
                    </div>
					<div>
						<div class="info-user-galery">
							<div class="pull-left quad">
								<a href="#" class="thumbnail">
									<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
								</a>
							</div>
							<div class="pull-left quad">
								<a href="#" class="thumbnail">
									<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
								</a>
							</div>
							<div class="pull-left quad">
								<a href="#" class="thumbnail">
									<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
								</a>
							</div>
							<div class="pull-left quad">
								<a href="#" class="thumbnail">
									<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
								</a>
							</div>
							<div class="pull-left quad">
								<a href="#" class="thumbnail">
									<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
								</a>
							</div>
							<div class="pull-left quad">
								<a href="#" class="thumbnail">
									<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
								</a>
							</div>
							<div class="pull-left quad">
								<a href="#" class="thumbnail">
									<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
								</a>
							</div>
							<div class="pull-left quad">
								<a href="#" class="thumbnail">
									<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
								</a>
							</div>
						</div>
							<div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion"
									href="#collapseOne">Compras</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in">
							<div class="panel-body">
									
								<!-- checkout box-->
								<div class="col-md-4 checkouts-box">
									<div class="col-md-12 img-content" >
										<img src="http://bimg2.mlstatic.com/camiseta-adulto-e-infantil-zelda-triforce_MLB-F-219462707_2113.jpg" class="checkouts-box-img" />
									</div>
									
									<div class="col-md-12 checkouts-content">
										<div class="checkout-label">Camiseta qualquer por no brasil</div>
										<hr class="checkouts-divisor"/>
												
											<div class="checkouts-descriptions col-md-12">												
										<div>
											<div class="col-md-7 checkouts-collums left-collum">
											Quantidade:
										</div>
										<div class="col-md-5 checkouts-collums">
										3
										</div>
										
										
											<div class="col-md-7 checkouts-collums left-collum">
											Pagamento:
										</div>
										<div class="col-md-5 checkouts-collums">
										DÉBITO
										</div>
										
									
											<div class="col-md-7 checkouts-collums left-collum">
											Data:
										</div>
										<div class="col-md-5 checkouts-collums">
										21/12/2015
										</div>
										
										<div class="col-md-7 checkouts-collums left-collum">
											Status:
										</div>
										<div class="col-md-5 checkouts-collums">
											RECEBIDO
										</div>
										
										<div class="col-md-7 checkouts-collums left-collum">
											TOTAL:
										</div>
										<div class="col-md-5 checkouts-collums">
											R$ 1999,00
										</div>
										</div>
										</div>										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
						</div>
                    </div>
				</form>
				<div class="form-group">
                            <div class=" buttonLocation">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
