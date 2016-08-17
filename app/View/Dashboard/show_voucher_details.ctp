
<h4>Detalhe do Voucher</h4><br/>

<table class="table table-bordered">
	<thead>
		<tr>
			<th><?php echo utf8_encode('Servi�o');?></th>
			<th><?php echo utf8_encode('Expira��o');?></th>
			<th>Valor Pago</th>
			<th>Data da Compra</th>
			<th>Tipo pagamento</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $voucher[0]['subclasses']['name'];?></td>
			<td><?php echo date('d/m/Y', strtotime($voucher[0]['offers']['ends_at']));?></td>
			<td>R$<?php echo str_replace('.', ',', $voucher[0]['checkouts']['total_value']);?></td>
			<td><?php echo date('d/m/Y', strtotime($voucher[0]['checkouts']['date']));?></td>
			<td><?php echo $voucher[0]['payment_methods']['type']. ' '. $voucher[0]['payment_methods']['name'];?></td>
		</tr>
	</tbody>
</table>