<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<?php $this->Html->css('View/Product.index', array('inline' => false)); ?>
<?php $this->Html->script('View/Vouchers', array('inline' => false)); ?>
<?php $this->Html->css('View/ClientReport.index', array('inline' => false)); ?>
<div>
    <h1 class="page-header letterSize" ><span>Vouchers</span></h1>
</div>

<ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#sectionA">Todos os Vouchers</a></li>
        <li class="active"><a data-toggle="tab" href="#sectionB">Vouchers Aprovados/ Em Aberto</a></li>
        <li><a data-toggle="tab" href="#sectionC">Vouchers Inativos/ Usados</a></li>
    </ul>
    <div class="tab-content" id="sections">
        <div id="sectionA" class="tab-pane fade">
			<table class="table table-bordered table-condensed small" id="approvedVouchers">
			<thead>
				<tr>
					<th>Id</th>
					<th>Oferta</th>
					<th><?php echo utf8_encode("Serviço");?></th>
					<th><?php echo utf8_encode("Expiração");?></th>
					<th>Valor Pago</th>
					<th><?php echo utf8_encode("Usuário");?></th>
					<th><?php echo utf8_encode("Data de Aquisição");?></th>
					<th>Status</th>
					<th>Agendado</th>
				</tr>
				</thead>
				<tbody>
				<?php 
					if(!empty($vouchers)){
				foreach($vouchers as $voucher){?>
					
				<tr>
					<td><?php echo $voucher['services_vouchers']['id']; ?></td>
					<td><?php echo $voucher['offers']['title'].'<br/><small>'; ?></td>
					<td><?php echo $voucher['subclasses']['name']; ?></td>
							<td><?php echo date('d/m/Y',strtotime($voucher['offers']['ends_at']));?></td>
								<td><?php echo str_replace(".", ",", $voucher['checkouts']['total_value']);?></td>
					<td><a href="#" onclick="showUserDetail(<?php echo $voucher['users']['id']; ?>)"><?php echo $voucher['users']['name'].'</a><br/><small>';?></td>
					<td>R$<?php echo date('d/m/Y',strtotime($voucher['services_vouchers']['acquisition_date']));?></td>
					<td><?php if($voucher['services_vouchers']['status'] == 'APPROVED'){
									echo "APROVADO PARA USO";
								}else if($voucher['services_vouchers']['status'] == 'USED'){
									echo "USADO";
								}?></td>
					<td><?php if(!$voucher['services_vouchers']['pre_scheduled_date']){
						echo utf8_encode("não agendado");
					}else{
					if($voucher['services_vouchers']['pre_scheduled_date'] == '0000-00-00 00:00:00'){
						echo utf8_encode("não agendado");
					}else{
						echo date('d/m/Y',strtotime($voucher['services_vouchers']['pre_scheduled_date']));
					}
					} ?></td>
				</tr>
				<?php }}?>
				</tbody>
			</table>
		
		</div>
		
		<div id="sectionB" class="tab-pane fade in active">
		
			<table class="table table-bordered table-condensed small" id="approvedVouchers">
			<thead>
				<tr>
					<th>Id</th>
					<th>Oferta</th>
					<th><?php echo utf8_encode("Serviço");?></th>
					<th><?php echo utf8_encode("Expiração");?></th>
					<th>Valor Pago</th>
					<th><?php echo utf8_encode("Usuário");?></th>
					<th><?php echo utf8_encode("Data de Aquisição");?></th>
					<th>Agendado</th>
				</tr>
				</thead>
				<tbody>
				<?php if(!empty($vouchers)){
				foreach($vouchers as $voucher){
					if($voucher['services_vouchers']['status'] == 'APPROVED'){
					
					?>
					
				<tr>
					<td><?php echo $voucher['services_vouchers']['id']; ?></td>
					<td><?php echo $voucher['offers']['title'].'<br/><small>'; ?></td>
					<td><?php echo $voucher['subclasses']['name']; ?></td>
							<td><?php echo date('d/m/Y',strtotime($voucher['offers']['ends_at']));?></td>
					<td>R$<?php echo str_replace(".", ",", $voucher['checkouts']['total_value']);?></td>
					<td><a href="#" onclick="showUserDetail(<?php echo $voucher['users']['id']; ?>)"><?php echo $voucher['users']['name'].'</a><br/><small>';?></td>
					<td><?php echo date('d/m/Y',strtotime($voucher['services_vouchers']['acquisition_date']));?></td>
					<td><?php if(!$voucher['services_vouchers']['pre_scheduled_date']){
						echo utf8_encode("não agendado");
					}else{
					if($voucher['services_vouchers']['pre_scheduled_date'] == '0000-00-00 00:00:00'){
						echo utf8_encode("não agendado");
					}else{
						echo date('d/m/Y',strtotime($voucher['services_vouchers']['pre_scheduled_date']));
					}
					} ?></td>
				</tr>
				<?php }}}?>
				</tbody>
			</table>
		</div>
		
		<div id="sectionC" class="tab-pane fade">
			<table class="table table-bordered table-condensed small" id="approvedVouchers">
			<thead>
				<tr>
					<th>Id</th>
					<th>Oferta</th>
					<th><?php echo utf8_encode("Serviço");?></th>
					<th><?php echo utf8_encode("Expiração");?></th>
					<th>Valor Pago</th>
					<th><?php echo utf8_encode("Usuário");?></th>
					<th><?php echo utf8_encode("Data de Aquisição");?></th>
					<th>Agendado</th>
				</tr>
				</thead>
				<tbody>
				<?php 
					if(!empty($vouchers)){
				foreach($vouchers as $voucher){
				if($voucher['services_vouchers']['status'] != 'APPROVED'){?>
					
				<tr>
					<td><?php echo $voucher['services_vouchers']['id']; ?></td>
					<td><?php echo $voucher['offers']['title'].'<br/><small>'; ?></td>
					<td><?php echo $voucher['subclasses']['name']; ?></td>
							<td><?php echo date('d/m/Y',strtotime($voucher['offers']['ends_at']));?></td>
								<td>R$<?php echo str_replace(".", ",", $voucher['checkouts']['total_value']);?></td>
					<td><a href="#" onclick="showUserDetail(<?php echo $voucher['users']['id']; ?>)"><?php echo $voucher['users']['name'].'</a><br/><small>';?></td>
					<td><?php echo date('d/m/Y',strtotime($voucher['services_vouchers']['acquisition_date']));?></td>
					<td><?php if(!$voucher['services_vouchers']['pre_scheduled_date']){
						echo utf8_encode("não agendado");
					}else{
					if($voucher['services_vouchers']['pre_scheduled_date'] == '0000-00-00 00:00:00'){
						echo utf8_encode("não agendado");
					}else{
						echo date('d/m/Y',strtotime($voucher['services_vouchers']['pre_scheduled_date']));
					}
					} ?></td>
				</tr>
				<?php }
				}}?>
				</tbody>
			</table>
		
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