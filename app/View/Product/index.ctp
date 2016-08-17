<?php $this->Html->css('View/Product.index', array('inline' => false)); ?>
<?php $this->Html->script('util', array('inline' => false)); ?>
<?php $this->Html->script('View/Product.index', array('inline' => false)); ?>

<script>

</script>

<h1 class="page-header" style="margin-top: -38px;">Produtos/Ofertas</h1>
<a href="<?php echo $this->Html->url("productManipulation"); ?>">
    <button type="button" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span></button>
</a>

<div id="">
    <ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#sectionA">Todas as Ofertas</a></li>
        <li class="active"><a data-toggle="tab" href="#sectionB">Ofertas Ativas</a></li>
        <li><a data-toggle="tab" href="#sectionC">Ofertas Inativas</a></li>
    </ul>
    <div class="tab-content" id="sections">
        <div id="sectionA" class="tab-pane fade">
            <table class="table table-bordered table-condensed small" id="minhaTabela">
                <thead>
                    <tr>
                        <th class="col-md-3">Titulo</th>
                        <th>Valor Total</th>
                        <th>Valor Com Desconto</th>
                        <th>Porcentagem de desconto</th>
                        <th>Inicio</th>
                        <th>Final</th>
                        <th>Status</th>
                        <th>Cliques em detalhe</th>
                        <th>Cliques em comprar</th>
                        <th>Compras com boleto</th>
                        <th>Compras com cartão</th>
                        <th>Avaliação</th>
                        
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (is_array($allOffers)) {
                        foreach ($allOffers as $offer) {
                            if ($offer['Offer']['status'] == 'INACTIVE') {
                                $imgs = $this->Html->image('play.png', array('class' => 'status-icon status-icon-inactive active-icon', 'id'=> $offer["Offer"]["id"], 'name' => 'play-'.$offer["Offer"]["id"])).''.$this->Html->image('pause-red.png', array('class' => 'status-icon', 'name' => 'pause-'.$offer["Offer"]["id"]));
                                $iconPlayPause = '<span class="glyphicon glyphicon-play active-icon" id="'.$offer["Offer"]["id"].'" ></span>';
                            } else {
                                $imgs = $this->Html->image('green-play.png', array('class' => 'status-icon', 'name' => 'play-'.$offer["Offer"]["id"])).''.$this->Html->image('pause.png', array('class' => 'status-icon status-icon-inactive inactive-icon', 'id' =>$offer["Offer"]["id"], 'name' => 'pause-'.$offer["Offer"]["id"]));
                                $iconPlayPause = '<span class="glyphicon glyphicon-pause inactive-icon" id="'.$offer["Offer"]["id"].'"></span>';
                            }
                            $numeroVotantes = $offer['Statistics'][0]['votantes'];
                            if (!empty($offer['Statistics'][0]['votantes'])) {
                                $nota = $offer['Statistics'][0]['evaluation'] / $offer['Statistics'][0]['votantes'];
                            } else {
                                $nota = 0;
                            }
                            $estrelas = $this->Html->image('jezzy_icons/' . $nota . '.png', array('class' => 'starOffer', 'title' => $nota));
                            $configIcon = "";
                            if ($this->Session->read('secondUserLogado') == false || $this->Session->read('SecondaryUserLoggedIn.0.secondary_users.type') == 1 || $this->Session->read('SecondaryUserLoggedIn.0.secondary_users.type') == 2) {
                                $configIcon = '<span class="glyphicon glyphicon-cog"></span>';
                            }
                            $editOfferLink = $this->Html->url("productManipulation/" . $offer['Offer']['id']);
                            
                            $descontoPorCem = $offer['Offer']['percentage_discount']/100;
                            $valorDoDesconto = $offer['Offer']['value']*$descontoPorCem;
                            $valorComDesconto = $offer['Offer']['value']-$valorDoDesconto;
                            
                            echo '
                            <tr>
                                <td><a href="#" onclick="showOfferDetail('.$offer['Offer']['id'].')">' . $offer['Offer']['title'] . '</a></td>
                                <td>R$' . str_replace(".", ",", $offer['Offer']['value']) . '</td>
                                <td>R$'.number_format($valorComDesconto, 2, ',', '.').'</td>
                                <td>' . str_replace(".", ",", $offer['Offer']['percentage_discount']) . '%</td>
                                <td>' . date('d/m/Y', strtotime($offer['Offer']['begins_at'])) . '</td>
                                <td>' . date('d/m/Y', strtotime($offer['Offer']['ends_at'])) . '</td>
                                <td class="rowCenter" id="row-' . $offer['Offer']['id'] . '">'. $imgs .'</td>
                                <td>' . $offer['Statistics']['offers_statistics']['details_click'] . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['checkouts_click'] . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['purchased_billet'] . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['purchased_card'] . '</td>
                                <td>' . $estrelas . '</td>
                               
                                <td class="rowCenter">
                                    <a href="' . $this->Html->url("productManipulation/" . $offer['Offer']['id']) . '">' . $configIcon . '</a></td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div id="sectionB" class="tab-pane fade in active">
            <table class="table table-bordered table-condensed small" id="activeOffers">
                <thead>
                    <tr>
                        <th class="col-md-3">Titulo</th>
                        <th>Valor Total</th>
                        <th>Valor Com Desconto</th>
                        <th>Porcentagem de desconto</th>
                        <th>Inicio</th>
                        <th>Final</th>
                        <th>Status</th>
                        <th>Cliques em detalhe</th>
                        <th>Cliques em comprar</th>
                        <th>Compras com boleto</th>
                        <th>Compras com cartão</th>
                        <th>Avaliação</th>
                        
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (is_array($allOffersActive)) {
                        foreach ($allOffersActive as $offer) {
                            if ($offer['Offer']['status'] == 'INACTIVE') {
                                $imgs = $this->Html->image('play.png', array('class' => 'status-icon status-icon-inactive active-icon', 'id'=> $offer["Offer"]["id"])).''.$this->Html->image('pause-red.png', array('class' => 'status-icon'));
                                $iconPlayPause = '<span class="glyphicon glyphicon-play active-icon" id="'.$offer["Offer"]["id"].'" ></span>';
                            } else {
                                $imgs = $this->Html->image('green-play.png', array('class' => 'status-icon')).''.$this->Html->image('pause.png', array('class' => 'status-icon status-icon-inactive inactive-icon', 'id' =>$offer["Offer"]["id"]));
                                $iconPlayPause = '<span class="glyphicon glyphicon-pause inactive-icon" id="'.$offer["Offer"]["id"].'"></span>';
                            }
                            $numeroVotantes = $offer['Statistics'][0]['votantes'];
                            if (!empty($offer['Statistics'][0]['votantes'])) {
                                $nota = $offer['Statistics'][0]['evaluation'] / $offer['Statistics'][0]['votantes'];
                            } else {
                                $nota = 0;
                            }
                            $estrelas = $this->Html->image('jezzy_icons/' . $nota . '.png', array('class' => 'starOffer', 'title' => $nota));
                            $configIcon = "";
                            if ($this->Session->read('secondUserLogado') == false || $this->Session->read('SecondaryUserLoggedIn.0.secondary_users.type') == 1 || $this->Session->read('SecondaryUserLoggedIn.0.secondary_users.type') == 2) {
                                $configIcon = '<span class="glyphicon glyphicon-cog"></span>';
                            }
                            
                             $descontoPorCem = $offer['Offer']['percentage_discount']/100;
                            $valorDoDesconto = $offer['Offer']['value']*$descontoPorCem;
                            $valorComDesconto = $offer['Offer']['value']-$valorDoDesconto;
                            
                            echo '
                            <tr>
                                <td><a href="#" onclick="showOfferDetail('.$offer['Offer']['id'].')">' . $offer['Offer']['title'] . '</td>
                                <td>R$' . str_replace(".", ",", $offer['Offer']['value']) . '</td>
                                    <td>R$'.number_format($valorComDesconto, 2, ',', '.').'</td>
                                <td>' . str_replace(".", ",", $offer['Offer']['percentage_discount']) . '%</td>
                                <td>' . date('d/m/Y', strtotime($offer['Offer']['begins_at'])) . '</td>
                                <td>' . date('d/m/Y', strtotime($offer['Offer']['ends_at'])) . '</td>
                                <td class="rowCenter" id="row-f' . $offer['Offer']['id'] . '">' .$imgs . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['details_click'] . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['checkouts_click'] . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['purchased_billet'] . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['purchased_card'] . '</td>
                                <td>' . $estrelas . '</td>
                             
                              <td class="rowCenter">
                                    <a href="' . $this->Html->url("productManipulation/" . $offer['Offer']['id'])  . '">' . $configIcon . '</a></td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div id="sectionC" class="tab-pane fade">
            <table class="table table-bordered table-condensed small" id="inactiveOffer">
                <thead>
                    <tr>
                        <th class="col-md-3">Titulo</th>
                        <th>Valor Total</th>
                        <th>Valor Com Desconto</th>
                        <th>Porcentagem de desconto</th>
                        <th>Inicio</th>
                        <th>Final</th>
                        <th>Status</th>
                        <th>Cliques em detalhe</th>
                        <th>Cliques em comprar</th>
                        <th>Compras com boleto</th>
                        <th>Compras com cartão</th>
                        <th>Avaliação</th>
                        
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (is_array($allOffersInactive)) {
                        foreach ($allOffersInactive as $offer) {
                            if ($offer['Offer']['status'] == 'INACTIVE') {
                                $imgs = $this->Html->image('play.png', array('class' => 'status-icon status-icon-inactive active-icon', 'id'=> $offer["Offer"]["id"])).''.$this->Html->image('pause-red.png', array('class' => 'status-icon'));
                                $iconPlayPause = '<span class="glyphicon glyphicon-play active-icon" id="'.$offer["Offer"]["id"].'" ></span>';
                            } else {
                                $imgs = $this->Html->image('green-play.png', array('class' => 'status-icon')).''.$this->Html->image('pause.png', array('class' => 'status-icon status-icon-inactive inactive-icon', 'id' =>$offer["Offer"]["id"]));
                                $iconPlayPause = '<span class="glyphicon glyphicon-pause inactive-icon" id="'.$offer["Offer"]["id"].'"></span>';
                            }
                            $numeroVotantes = $offer['Statistics'][0]['votantes'];
                            if (!empty($offer['Statistics'][0]['votantes'])) {
                                $nota = $offer['Statistics'][0]['evaluation'] / $offer['Statistics'][0]['votantes'];
                            } else {
                                $nota = 0;
                            }
                            $estrelas = $this->Html->image('jezzy_icons/' . $nota . '.png', array('class' => 'starOffer', 'title' => $nota));
                            $configIcon = "";
                            if ($this->Session->read('secondUserLogado') == false || $this->Session->read('SecondaryUserLoggedIn.0.secondary_users.type') == 1 || $this->Session->read('SecondaryUserLoggedIn.0.secondary_users.type') == 2) {
                                $configIcon = '<span class="glyphicon glyphicon-cog"></span>';
                            }
                            
                             $descontoPorCem = $offer['Offer']['percentage_discount']/100;
                            $valorDoDesconto = $offer['Offer']['value']*$descontoPorCem;
                            $valorComDesconto = $offer['Offer']['value']-$valorDoDesconto;
                            
                            echo '
                            <tr>
                                <td><a href="#" onclick="showOfferDetail('.$offer['Offer']['id'].')">' . $offer['Offer']['title'] . '</td>
                                <td>R$' . str_replace(".", ",", $offer['Offer']['value']) . '</td>
                                  <td>R$'.number_format($valorComDesconto, 2, ',', '.').'</td>
                                <td>' . str_replace(".", ",", $offer['Offer']['percentage_discount']) . '%</td>
                                <td>' . date('d/m/Y', strtotime($offer['Offer']['begins_at'])) . '</td>
                                <td>' . date('d/m/Y', strtotime($offer['Offer']['ends_at'])) . '</td>
                                <td class="rowCenter" id="row-f' . $offer['Offer']['id'] . '">' . $imgs . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['details_click'] . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['checkouts_click'] . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['purchased_billet'] . '</td>
                                <td>' . $offer['Statistics']['offers_statistics']['purchased_card'] . '</td>
                                <td>' . $estrelas . '</td>
                            
                                <td class="rowCenter">
                                    <a href="' . $this->Html->url("productManipulation/" . $offer['Offer']['id'])  . '">' . $configIcon . '</a></td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4  id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body" id="recebe-offer-detail">
			
			<div class="media">
				<div class="media-left ">
						<a href="#">
							<img class="media-object" src="http://www.matematica.seed.pr.gov.br/arquivos/Image/imagens_relatos/imagem_relato_quadrado_vermelho_danielle.jpg" alt="...">
						</a>
				</div>
				<div class="media-body ">
					<h4 class="media-heading">Camiseta OFICIAL Seleção Brasileira</h4>
					Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.<br/>
					<br/>
					<span class="label">Inicio:</span> <span class="label-date">12/12/2016</span><br/>
					<span class="label">Término:</span> <span class="label-date">20/12/2016</span><br/>
					<span class="label">Valor Total:</span> <span class="label-date">R$ 12,00</span><br/>
					<span class="label">Percentual de Desconto:</span> <span class="label-date">5%</span><br/>
					<span class="label">Quantidade em estoque:</span> <span class="label-date">45</span><br/>
					
				</div>
			</div>
			
			<div>
			
					<div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion"
									href="#collapseOne">Comentários</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in">
							<div class="panel-body">
									
								<div class="col-md-12 comment-item"> 
									
									<div class="col-md-3 comment-item-photo-content">
											<img src="http://www.robolaranja.com.br/wp-content/uploads/2014/10/Primeira-imagem-do-filme-de-Angry-Birds-%C3%A9-revelada-2.jpg" class="circular"/>
									</div>
									
									<div class="col-md-9 comment-item-content">
										<span class="comment-item-title">Matheus Odilon</span><span class="comment-item-date">  12/12/2016</span><br/>
										<span class="comment-item-desc">"Ótimo produto, vender muito atencioso e rápida entrega!"</span><br/>
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Star_empty.svg/118px-Star_empty.svg.png" class="comment-item-star pull-right"/>
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Star_empty.svg/118px-Star_empty.svg.png" class="comment-item-star pull-right" />
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Star_empty.svg/118px-Star_empty.svg.png" class="comment-item-star pull-right" />
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Star_empty.svg/118px-Star_empty.svg.png" class="comment-item-star pull-right"/>
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Star_empty.svg/118px-Star_empty.svg.png" class="comment-item-star pull-right"/>
									</div>
									
									
								</div>									
									
							</div>
						</div>
					</div>
				</div>
			
			</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>