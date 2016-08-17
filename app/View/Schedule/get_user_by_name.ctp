
<table class="table table-hover table-content-names">
	<?php 
		$contador = 0;
	foreach($users as $user){ ?>
		<tr>
			<td onclick="userItemClicked('<?php echo utf8_encode($user['users']['name']);?>', <?php echo $user['users']['id'];?>, '<?php echo utf8_encode($user['users']['email']);?>','<?php echo utf8_encode($user['users']['phone']);?>')"><?php echo utf8_encode($user['users']['name']);?></td>
		<tr>
	<?php $contador++;}?>
</table>
