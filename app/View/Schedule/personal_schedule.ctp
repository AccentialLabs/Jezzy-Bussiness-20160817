<table class="table table-bordered tabelSchedule">    
    <thead>        
        <tr>            

            <?php
            if (isset($schedules)) {
				$secN = split(" ", $schedules[0]['secondary_users']['name']);
                echo '
                    <th class="topBorderSchedule" title="' . $schedules[0]['secondary_users']['name'] . '">
                        ' . $secN[0] . ' 
                        <span title="Adicionar Agendamento" name="' . $schedules[0]['secondary_users']['id'] . '" class="glyphicon glyphicon-plus"></span>
                    </th>';
            } else {
                if (isset($userInformation)) {
				$sec = split(" ", $userInformation[0]['secondary_users']['name']);
                    echo '
                    <th class="topBorderSchedule" title="' . $userInformation[0]['secondary_users']['name'] . '">
                        ' . $sec[0] . ' 
                        <span title="Adicionar Agendamento" name="' . $userInformation[0]['secondary_users']['id'] . '" class="glyphicon glyphicon-plus"></span>
                    </th>';
                }
            }
            ?>
            </th>        
        </tr>    
    </thead>    
    <tbody>        
        <?php
        if (isset($schedules)) {
            foreach ($schedules as $schedule) {
                $classGreen = "";
                if ($schedule['schedules']['status'] == 0) {
                    $classGreen = " greenColor ";
                }
				$second = split(" ", $schedule['schedules']['client_name']);
				$subN = substr($schedule['schedules']['time_end'], 0, 5);
                echo '
                    <tr>            
                        <td>' . substr($schedule['schedules']['time_begin'], 0, 5) . ' - ' . $subN . '<br>' .$schedule['schedules']['subclasse_name'] . '<br/>' . $second[0] . ' 
                            <span title="Remover Agendamento" name="removeSchedule" id="' . $schedule['secondary_users']['id'] . '-' . $schedule['schedules']['id'] . '" class="glyphicon glyphicon-minus"></span> | <span title="Agendamento realizado" name="removeSchedule" id="' . $schedule['secondary_users']['id'] . '-' . $schedule['schedules']['id'] . '" class="glyphicon glyphicon-ok ' . $classGreen . '"></span>
                        </td>        
                    </tr> ';
            }
        }
        ?>
    </tbody>
</table>