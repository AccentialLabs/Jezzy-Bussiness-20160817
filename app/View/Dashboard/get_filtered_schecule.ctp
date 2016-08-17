	 <a href="#" class="list-group-item disabled">
        Agendamentos para <?php echo $dataDeHoje;?>
    </a>
	<?php
	if(!empty($schedules)){
  foreach($schedules as $sche){
		if($sche['schedules']['status'] != 2){?>
    <a href="#" class="list-group-item"><strong><?php echo $sche['schedules']['client_name']?></strong>/ <?php echo $sche['schedules']['subclasse_name']; ?> de <strong><?php echo substr($sche['schedules']['time_begin'], 0, 5); ?></strong> <?php utf8_encode('até');?> <strong><?php echo substr($sche['schedules']['time_end'], 0, 5); ?></strong>
        <br /> <strong>Profissional: </strong><?php echo $sche['secondary_users']['name'] ?></a>
  <?php }}}else{
	echo "<p> Sem agedamentos para hoje, até o momento!</p>";
  }?>