

<option>Selecione o Serviço</option>
	<?php foreach($services as $service){ ?>
                    
			<option value="<?php echo $service['services']['value'];?>" onclick="clickInSearch('<?php echo utf8_encode($service['subclasses']['name']);?>', <?php echo $service['subclasses']['id'];?>, <?php echo $service['services']['value'];?>)" ><?php echo utf8_encode($service['subclasses']['name']);?></option>
	
	<?php }?>
