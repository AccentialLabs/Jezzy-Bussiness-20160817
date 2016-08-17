<?php $this->Html->css('View/ClientReport.index', array('inline' => false)); ?>
<script src="../../resources/js/bootstrap-collapsible-fieldset.js"></script>
<?php echo $this->Html->script('View/ClientReport', array('inline' => false)); ?>
<h1 class="page-header letterSize" style="margin-top: -38px;"><span>Clientes</span></h1>

	<?php date_default_timezone_set("America/Sao_Paulo"); ?>

            <table class="table table-bordered table-condensed small" id="tableId">
                <thead>
                    <tr>
                        <th class="col-md-3">Nome</th>
                        <th>Idade</th>
                        <th>Cidade</th>
                        <th>Ultima Compra</th>
                        <th>Ultimo Agendamento</th>
                        <th>Criar oferta para cliente</th>
                        <th>Criar oferta para perfil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					if(!empty($allClients)){
                   if (is_array($allClients)) {
                        foreach ($allClients as $client) {
                            if (!empty(trim($client['User']['lastCheckout']))) {
							
							$dtStr = strtotime($client['User']['lastCheckout']);
                                $lastCheckoutDate = $client['User']['lastCheckout'] = date('d/m/Y', $dtStr);
                            }else{
                                 $lastCheckoutDate =  'Nenhuma compra realizada';
                            }
                            if (!empty($client['User']['lastSchedule'])) {
							$strSr = strtotime($client['User']['lastSchedule'][0]['schedules']['date']);
                               $lastScheduleDate = date('d/m/Y', $strSr);
                            }else{
                                 $lastScheduleDate = 'Não realizado nenhum';
                            }
                            echo '
                                <tr>
                                    <td><a href="#" onclick="showUserDetail('.$client["User"]["id"].')">' . $client['User']['name'] . '</a></td>
                                    <td>' . $client['User']['age'] . '</td>
                                    <td>' . $client['User']['city'] . '</td>
                                    <td>' . $lastCheckoutDate . '</td>
                                     <td>'. $client['User']['lastSchedule'][0]['schedules']['classe_name'].' - '.$client['User']['lastSchedule'][0]['schedules']['subclasse_name'] .'<br/>' .$lastScheduleDate  . '</td>
                                    <td><span class="glyphicon glyphicon-send offer-for-client" id="' . $client['User']['id'] . '"></span></td>
                                    <td><span class="glyphicon glyphicon-screenshot offer-for-profile" id="' . $client['User']['id'] . '"></span></td>
                                </tr>';
                        }
                    }}
                    ?>
                </tbody>
            </table>

<!-- DETALHE DE USU¡RIO -->
<div id="myModalUserDetails" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
<div class="modal-dialog modal-md" >
<div class="modal-content" id="modelContent">
<div class="modal-body">
<form action="<?php echo $this->Html->url("addSubclass"); ?>" method="post">
<legend>Detalhes do Usu·rio</legend>
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
<span class="glyphicon glyphicon-home pull-left"></span><div class="description-info-user">De Ferraz de Vasconcelos - S„o Paulo, Rua Hermenegildo Barreto, 120 - 08540-500</div>
</div>
</div>
</div>
<div>
<div class="info-user-galery">
<div>
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
</div><div>
<div class="pull-left quad">
<a href="#" class="thumbnail">
<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
</a>
</div>
<div class="pull-left quad">
<a href="#" class="thumbnail">
<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
</a><
</div></div>
<div class="pull-left quad">
<a href="#" class="thumbnail">
<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
</a>
</div>
<div class="pull-left quad">
<a href="#" class="thumbnail">
<img src="http://www.pontoabc.com/wp-content/uploads/2014/01/quadrados-dentro-de-um-quadrado.jpg" alt="...">
</a>
</div></br>
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
D…BITO
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


