
<table class="table table-hover" id="serviceByNameTb">
	<?php foreach($services as $service){ ?>
		<tr>
                    <!-- <td onclick="clickInSearch('<?php echo $service['classes']['name'];?>', <?php echo $service['subclasses']['id'];?>)" ><?php echo utf8_encode($service['subclasses']['name']);?></td> -->
			<td onclick="clickInSearch('<?php echo $service['classes']['name'];?>', <?php echo $service['subclasses']['id'];?>)" ><?php echo utf8_encode($service['subclasses']['name']);?></td>
		<tr>
	<?php }?>
</table>