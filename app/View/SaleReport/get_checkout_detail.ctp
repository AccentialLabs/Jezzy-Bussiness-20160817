				
				<fieldset>
					<legend>Compra <?php echo $checkout[0]['checkouts']['id'];?></legend>
					<div class="checkout-text">
<span>Data da compra: <strong><?php $data =  explode("-",$checkout[0]['checkouts']['date']); echo str_replace(" 00:00:00", "", $data[2])."/".$data[1]."/".$data[0];?></strong> via
<strong><?php echo $checkout[0]['payments_methods']['type']. ' ' .$checkout[0]['payments_methods']['name'];?></strong><br/>Status: <strong>
						<?php echo $checkout[0]['payment_states']['name']; ?></strong>.<br/> Quantidade: <strong><?php echo $checkout[0]['checkouts']['amount'];?></strong><br/>
						Valor pago: <strong>R$<?php echo str_replace(".", ",", $checkout[0]['checkouts']['total_value']);?></strong></span>
					</div>
				</fieldset>
				
				<br />
				<fieldset>
					 <h3><?php echo $offer[0]['offers']['title'];?><br/></h3>
					<div class="col-md-12">
						<div class="col-md-3">
<?php if($offer[0]['offers']['photo'] == '') {$offer[0]['offers']['photo'] = 'http://52.67.24.232/secure/jezzy-mobile/public_html/img/icons/ImagemIndisponivel2.png';}?>
							<img src="<?php echo $offer[0]['offers']['photo'];?>" style="width: 100%;"/>
						</div>
						<div class="col-md-9">
						
						
						 Oferta <strong><?php  if($offer[0]['offers']['public'] == 'ACTIVE'){echo "Pública"; }else{echo "Direcionada";}?></strong><br/>Válida de <strong><?php $data =  explode("-",$offer[0]['offers']['begins_at']); echo str_replace(" 00:00:00", "", $data[2])."/".$data[1]."/".$data[0];?></strong> a <strong><?php $data =  explode("-",$offer[0]['offers']['ends_at']); echo str_replace(" 00:00:00", "", $data[2])."/".$data[1]."/".$data[0];?></strong>.<br/>
						 Valor unitário R$ <strong><?php echo str_replace(".", ",", $offer[0]['offers']['value']);?></strong> com desconto de <strong><?php echo $offer[0]['offers']['percentage_discount'];?></strong>%.
						</div>
					</div>
				</fieldset>
				<br/><br/>
				<fieldset>

					<div class="col-md-12">
						<div class="col-md-3">
                            <?php if($checkout[0]['users']['photo'] == '') {$checkout[0]['users']['photo'] = 'http://52.67.24.232/secure/jezzy-mobile/public_html/img/icons/ImagemIndisponivel2.png';}?>
							<img src="<?php echo $checkout[0]['users']['photo'];?>" style="width: 100%;"/>
						</div>
						<div class="col-md-9">
						<h3><?php echo $checkout[0]['users']['name'];?><br/> <small>Cliente desde <strong><?php $data =  explode("-",$checkout[0]['users']['date_register']); echo $data[0];?></strong></small></h3>
						 <strong><?php echo $checkout[0]['users']['district'];?> - <?php echo $checkout[0]['users']['city'];?> </strong><br/>
						 <span><?php if($checkout[0]['users']['gender'] == 'male'){ echo "Masculino";}else{echo "Feminino";};?></span>
						</div>
					</div>
				</fieldset>
				
            