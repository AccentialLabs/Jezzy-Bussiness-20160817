<?php

$totalColunas = count($cols);
$collunscolumns = array_filter($cols);
$totalLinhaDados = count($editDTLinhas);
$totalColunaDados = count($editDTColunas);
$newOrganizeArr = [];
if ($totalColunaDados > 0) {
    foreach ($editDTColunas as $metric) {
//        $newOrganizeArr[$metric['offers_metrics']['offer_metrics_y_id']][$metric['offers_metrics']['offer_metrics_x_id']] = $metric['offers_metrics']['amount'];
        $newOrganizeArr[$metric['offers_metrics']['offer_metrics_x_id']][$metric['offers_metrics']['offer_metrics_y_id']] = $metric['offers_metrics']['amount'];
    }
}
?>

<form action="" method="post" target="" id="offerFormOptions">
    <table class="table table-bordered table-condensed" id="tableProductOption">
        <thead>
            <tr>
                <th></th>
                <?php
                for ($i = 0; $i < $totalColunas; $i++) {
                   
                    if($cols[$i]['offers_domains']['offer_attribute_id'] != 3){
                        echo '<th id="' . $cols[$i]['offers_domains']['id'] . '"> ' . $cols[$i]['offers_domains']['name'] . ' </th>';
                    }else{
                        echo '<th id="' . $cols[$i]['offers_domains']['id'] . '"> <div style="width: 25px; height:25px; background:' . $cols[$i]['offers_domains']['name'] . '"></div> </th>';
                    }
                
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Preço</th>
                <?php
                $controle = "impar";
                for ($i = 0; $i < $totalColunas; $i++) {
                    echo '<td>';
                    for ($y = 0; $y < $totalColunaDados; $y++) {
                        if ($editDTLinhas[$y]['offers_domains']['id'] == $cols[$i]['offers_domains']['id']) {
                            echo '<input type="number" name="preco-column-' . $cols[$i]['offers_domains']['id'] . '" class="td-cont" id="preco" placeholder="R$ 0" value="' . $editDTColunas[$y]['offers_metrics']['value'] . '">';
                            $controle = "par";
                            break;
                        } else {
                            $controle = "impar";
                        }
                    }
                    if ($controle == "impar") {
                        echo '<input type="number" name="preco-column-' . $cols[$i]['offers_domains']['id'] . '" class="td-cont" id="preco" placeholder="R$ 0" >';
                    }
                    echo ' </td>';
                }
                ?>
            </tr>
            <?php
            if (!empty($lines)) {
                foreach ($lines as $line) {
                    echo '<tr>';
                  if($line['offers_domains']['offer_attribute_id']  != 3){
                    echo '  <td id="' . $line['offers_domains']['id'] . '">' . $line['offers_domains']['name'] .' </td>';
                  }else{
                      echo '  <td id="' . $line['offers_domains']['id'] . '"> <div style="width:25px; height:25px; background:' . $line['offers_domains']['name']  .'" ></div> </td>';                      
                  }
                    $valida = false;
//                    for ($i = 0; $i < $totalLinhaDados; $i++) {
//    
//                        if ($editDTLinhas[$i]['offers_domains']['id'] == $line['offers_domains']['id']) {
//                            $valida = true;
//                            for ($m = 0; $m < $totalColunas; $m++) {
//                                if ($editDTLinhas[$i]['offers_metrics']['offer_metrics_y_id'] == $colunas[$m]['offers_domains']['id']) {
//                                    echo '<td>' . $editDTLinhas[$i]['offers_metrics']['amount'] . '</td>';
//                                    $i++;
//                                } else {
//                                    echo '<td><input class="td-cont-line" name="cont-' . $line['offers_domains']['id'] . "-" . $cols[$i]['offers_domains']['id'] . '" id="td-cont"   type="number" maxlength="3" placeholder="0"/></td>';
//                                }
//                            }
//                        }
//                    }
                    if (count($newOrganizeArr) == 0) {
                        for ($i = 0; $i < $totalColunas; $i++) {
                            
                            echo '<td><input  class="td-cont-line" name="cont-' . $line['offers_domains']['id'] . "-" . $cols[$i]['offers_domains']['id'] . '" id="td-cont"  type="number" maxlength="3" placeholder="0" /></td>';
                        }
                    } else {
                        foreach ($newOrganizeArr as $arrayKey => $arraykeys) {
                            foreach ($arraykeys as $key => $element) {
                                $thisline = $key;
                                $thiscoll = $arrayKey;
                                echo '<td><input  class="td-cont-line" name="cont-' . $thiscoll . "-" . $thisline . '" id="td-cont"  type="number" maxlength="3" placeholder="0" value="' . $element . '" /></td>';
                            }
                            break;
                        }
                        unset($newOrganizeArr[$arrayKey]);
                    }
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary floatRight">Salvar</button>
</form>