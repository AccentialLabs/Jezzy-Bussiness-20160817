
<div class="media">
				<div class="media-left ">
						<a href="#">
							<img class="media-object" src="<?php echo $offer['Offer']['photo']; ?>" alt="...">
						</a>
				</div>
				<div class="media-body ">
					<h4 class="media-heading"><?php echo $offer['Offer']['title']; ?></h4>
					<?php echo $offer['Offer']['description']; ?>
					<span class="label">Inicio:</span> <span class="label-date"><?php $unDate = explode(" ", $offer['Offer']['begins_at']); $data = explode("-", $unDate[0]); echo $data[2].'/'.$data[1].'/'.$data[0]; ?></span><br/>
					<span class="label">Término:</span> <span class="label-date"><?php $unDate = explode(" ", $offer['Offer']['ends_at']); $data = explode("-", $unDate[0]); echo $data[2].'/'.$data[1].'/'.$data[0]; ?></span><br/>
					<span class="label">Valor Total:</span> <span class="label-date">R$ <?php echo str_replace(".", ",", $offer['Offer']['value']); ?></span><br/>
					<span class="label">Percentual de Desconto:</span> <span class="label-date"><?php echo $offer['Offer']['percentage_discount']; ?>%</span><br/>
					<span class="label">Quantidade em estoque:</span> <span class="label-date"><?php echo $offer['Offer']['amount_allowed']; ?></span><br/>
					
				</div>
			</div>
			
			<?php if(isset($offersComments)){?>
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
									
									
									<?php foreach($offersComments as $comment){ ?>
									<div class="col-md-12 comment-item"> 
									
									<div class="col-md-3 comment-item-photo-content">
											<img src="<?php echo $comment['User']['photo']; ?>" class="circular"/>
									</div>
									
									<div class="col-md-9 comment-item-content">
										<span class="comment-item-title"><?php echo $comment['User']['name']; ?></span><span class="comment-item-date">  <?php $data = explode("-",$comment['OffersComment']['date_register']); echo $data[2].'/'.$data[1].'/'.$data[0]; ?></span><br/>
										<span class="comment-item-desc">"<?php echo $comment['OffersComment']['description'];?>"</span><br/>
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Star_empty.svg/118px-Star_empty.svg.png" class="comment-item-star pull-right"/>
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Star_empty.svg/118px-Star_empty.svg.png" class="comment-item-star pull-right" />
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Star_empty.svg/118px-Star_empty.svg.png" class="comment-item-star pull-right" />
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Star_empty.svg/118px-Star_empty.svg.png" class="comment-item-star pull-right"/>
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Star_empty.svg/118px-Star_empty.svg.png" class="comment-item-star pull-right"/>
									</div>									
								</div>		
								<?php }?>								
									
							</div>
						</div>
					</div>
				</div>
			</div> 
			
			<?php }?>