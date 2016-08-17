		 <meta name="viewport" content="width=device-width, initial-scale=1.0">
		 <?php echo $this->Html->css('bootstrap.min'); ?>
		 <?php echo $this->Html->css('View/Register'); ?>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
				<?php echo $this->Html->script('bootstrap.min'); ?>
				<?php echo $this->Html->script('jquery.mask'); ?>
				<?php echo $this->Html->script('jquery.mask.min'); ?>
				 <?php echo $this->Html->script('View/Register'); ?>
				 <?php echo $this->Html->script('View/Plans'); ?>
				 
				 
				 <div class="headerrr">
				 </div>
				 
				 <!-- MODAL QUE MOSTRARÁ OS PLANOS-->
				 
				 
		 <div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header" style="padding:35px 50px;">
				 <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
				  <h4> Selecione seu plano JEZZY:</h4>
				</div>
				<div class="modal-body" style="padding:40px 50px;">
				  <form role="form">
					<div class="form-group">
					  
					  <div class="row plano-row">
					 <div class="item-plano pull-left" >
						<div class="plano-header" >
							<h4> STANDARD</h4>
						</div>
						<div class="almost-jumbotron">
							<ul>
								<li>Aplicativo para o Salão (web) com todas as funcionalidades disponíveis;</li>
								<li>Aplicativos mobile (iOs e Android) para o Cabelereiro(a) e para o Cliente final com todas as funcionalidades disponíveis;</li>
								<li>Venda e entrega de produtos para o Cliente final (<i>nós entregamos e comissionamos seu Salão!</i>);</li>
								<li>Kit de divulgação para ponto de venda (<i>adesivos e folhetos</i>).</li>

							</ul>
							</div>
							<div class="plano-valor" >
							<h4>R$149,80 <small class="plano-small">mensal, debitados no Cartão de Crédito -- 15 dias GRATUITO!</small></h4>
						</div>
						<div class="text-center">
							<input type="radio" class="form-control"  id="myPlane" name="myPlane" value="STANDARD"/>
					  </div>
					  </div>
					  
					   <div class="item-plano pull-left" >
						<div class="plano-header" >
							<h4> PREMIUM</h4>
						</div>
						<div class="almost-jumbotron">
							<ul>
								<li>Aplicativo personalizado com logotipo e cores para o Salão (web) com todas as funcionalidades disponíveis;</li>
								<li>Aplicativos mobile (iOs e Android) personalizados nas lojas de aplicativos AppStore e GooglePlay, com logotipo e cores do Salão para o Cabelereiro(a) e para o Cliente final com todas as funcionalidades disponíveis;</li>
								<li>Venda e entrega de produtos para o Cliente final (<i>nós entregamos e comissionamos seu Salão!</i>);</li>
								<li>Kit de divulgação personalizado para ponto de venda (<i>adesivos e folhetos</i>).</li>
								
							</ul>
							
							
							
						</div>
						<div class="plano-valor" >
							<h4>R$249,80 <small class="plano-small">mensal, debitados no Cartão de Crédito -- sem custo de personalização ou implantação!
		</small></h4>
						</div>
						<div class="text-center">
							<input type="radio" class="form-control" id="myPlane" name="myPlane" value="PREMIUM"/>
					  </div>
					  </div>
					  
					</div>
				
				  </form>
				</div>
				<div class="modal-footer text-right">
				  <button type="reset" class="btn btn-default btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
				  <button type="button" class="btn btn-default btn-success" data-dismiss="modal" id="btnSubmitPlan"><span class="glyphicon glyphicon-ok"></span> Continuar</button>
				</div>
			  </div>
			  
			</div>
		  </div> 
		  </div>
		  
		  
		  
		  <!-- MODAL RESPONSAVEL POR CAPTAR DADOS DO CARTÃO DO USUÁRIO -->
		  
		  <div class="modal fade" id="myModalCard" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header" style="padding:35px 50px;">
				 <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
				<h4>Insira seus dados para finalizar a adesão do plano JEZZY:</h4>
				</div>
				<div class="modal-body" style="padding:40px 50px;">
				  <form role="form">
					<div class="form-group">
					
						<p><small>Olá <span id="CompanyResponsibleName"></span>, estamos quase finalizando o cadastro de sua empresa...</small></p>
						<br>
						<strong>Plano Selecionado: </strong> <span id="CompanySelectedPlan">PREMIUM</span> <span id="CompanySelectedPlanValue">R$249,80</span> <small>mensal</small>
						
						<div id="diverror">
						<small><strong><span style="color: red;" id="error-message">Essa é a mensagem de erro</span></strong></small>
						</div>
						
						
					   <div class="form-group">
						<label for="usrname">Titular do Cartão</label>
						<input type="text" class="form-control" placeholder="Nome" aria-describedby="basic-addon1" id="nameFromCard">
						</div>
						
						<div class="form-group">
						<label for="usrname">Número do Cartão <small><small>(Somente números)</small></small></label>
						<input type="text" class="form-control" placeholder="Número" aria-describedby="basic-addon1" id="numberCard">
						</div>
						
						<div class="form-group col-md-6">
						<label for="usrname">Mês de Expiração</label>
						<select class="form-control" id="monthExpirationCard">
							<option value="01">Janeiro</option>
							<option value="02">Fevereiro</option>
							<option value="03">Março</option>
							<option value="04">Abril</option>
							<option value="05">Maio</option>
							<option value="06">Junho</option>
							<option value="07">Julho</option>
							<option value="08">Agosto</option>
							<option value="09">Setembro</option>
							<option value="10">Outubro</option>
							<option value="11">Novembro</option>
							<option value="12">Dezembro</option>
						</select>
						</div>
						
						<div class="form-group col-md-6">
						<label for="usrname">Ano de Expiração</label>
						<select class="form-control" id="yearExpirationCard">
							<option value="16">2016</option>
							<option value="17">2017</option>
							<option value="18">2018</option>
							<option value="19">2019</option>
							<option value="20">2020</option>
							<option value="21">2021</option>
							<option value="22">2022</option>
							<option value="23">2023</option>
							<option value="24">2024</option>
							<option value="25">2025</option>
							<option value="26">2026</option>
							<option value="27">2027</option>
						</select>
						</div>
						
						<div class="form-group text-right">
						
				  <button type="button" class="btn btn-default btn-success" data-dismiss="modal" id="btnSubmitBuyPlan"><span class="glyphicon glyphicon-ok"></span> Finalizar adesão</button>
						</div>
				
						<div class="text-center">
							<p>
								<small><small><span class="glyphicon glyphicon-lock"></span> O ambiente JEZZY é totalmente seguro e<br/>não mantemos NENHUM dado de seu cartão em nossa base.</small></small>
							</p>
						</div>
						</div>
				  </form>
				  
				  <div class="text-center col-md-12"><i>ou</i></div><br/>
				  <div class="text-center">
					<a href="../Login"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-gift"></span> Não desejo completar adesão agora. <small>15 dias Trial</small></button></a>
				  </div>
				</div>
			
			  </div>
			  
			</div>
		  </div> 
		  
		  
			 <!-- <button type="button" class="btn btn-default btn-lg" id="myBtn">Login</button>
			
			 ESTILO E COMPORTAMENTO DA MODAL -->
			<script>
		$(document).ready(function(){
		 
				$("#myModal").modal();

		});
		</script>