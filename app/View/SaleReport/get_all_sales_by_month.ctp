 <table class="table table-bordered table-condensed small" id="tableId">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Status</th>
                            <th class="col-md-3">Produto</th>
                            <th>Comprador</th>
                            <th>Valor</th>
                            <th>Comentario</th>
                            <th>Etiqueta</th>
							<th>Detalhe</th>
                        </tr>
                    </thead>
                    <tbody class="searchable">
                        <?php
                        if (is_array($allSales)) {
                            foreach ($allSales as $saleAll) {
                                $payment_state_id = "";
                                switch ($saleAll['Checkout']['payment_state_id']) {
                                    case 1:
                                        $payment_state_id = "AUTORIZADO";
                                        break;
                                    case 2:
                                        $payment_state_id = "INICIADO";
                                        break;
                                    case 3:
                                        $payment_state_id = "BOLETO IMPRESSO";
                                        break;
                                    case 4:
                                        $payment_state_id = "CONCLUIDO";
                                        break;
                                    case 5:
                                        $payment_state_id = "CANCELADO";
                                        break;
                                    case 6:
                                        $payment_state_id = "EM ANALISE";
                                        break;
                                    case 7:
                                        $payment_state_id = "ESTORNADO";
                                        break;
                                    case 8:
                                        $payment_state_id = "EM REVISAO";
                                        break;
                                    case 9:
                                        $payment_state_id = "REEMBOLSADO";
                                        break;
                                    case 14:
                                        $payment_state_id = "INICIO DA TRANSACAO";
                                        break;
                                    case 73:
                                        $payment_state_id = "BOLETO IMPRESSO";
                                        break;
                                }

                                if ($saleAll['OffersComment']) {
                                    $offerComment = substr($saleAll['OffersComment']['description'], 0, 300);
                                } else {
                                    $offerComment = "Não possui comentário.";
                                }
								
								
								
                                echo '
                                    <tr>
                                        <td class="registerDate">' . date('d/m/Y', strtotime($saleAll['Checkout']['date'])) . '</td>
                                        <td>' . $payment_state_id . '</td>
                                        <td>' . $saleAll['Offer']['title'] . '</td>
                                        <td>' . $saleAll['User']['name'] . '</td>
                                        <td> R$' . $saleAll['Checkout']['total_value'] . '</td>

                                        <td>' . $offerComment . '</td>
                                        <td><span id="' . $saleAll['Checkout']['id'] . '" class="glyphicon glyphicon-tags"></span></td>
										<td><a href="#" onclick="showCheckoutDetail('.$saleAll['Checkout']['id'] .')"><span class="glyphicon glyphicon-plus"></span></a></td>
                                    </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>