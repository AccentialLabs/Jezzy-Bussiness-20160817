<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php $this->Html->css('View/Service.index', array('inline' => false)); ?>
<?php $this->Html->script('View/Services.index', array('inline' => false)); ?>

<h1 class="page-header" style="margin-top: -38px;">Configurações de Serviços</h1>
<?php
$message = $this->Session->flash();
if ($message !== null && $message != "") {
    echo '<div class="alert alert-info" role="alert">' . $message . '</div>';
}
?>

	<div style="col-md-12">
		
			<input type="text" class="form-control" placeholder="Buscar Serviço" id="searchService" name="date[searchService]">
		
		<div style="col-md-12">		
			<div id="search-return" class="return-box">
				
			</div>
		</div>
	</div>
	<br/>
<form  action="<?php echo $this->Html->url("updateServices"); ?>" method="post" id="serviceForm">
    <div class="panel-group" id="accordion">
        <?php
		//print_r($allServices);
        if (isset($allServices)) {
            $collapseCount = 0;
            foreach ($allServices as $key => $service) {
				
                $position = key ( $service );
                $servicesUser = "";
				if(!empty($service[$position]['users'])){
                foreach ($service[$position]['users'] as $user) {
					if($user['excluded'] == 0){
                    $servicesUser .= '<th class=" text-center" title="'.$user['name_complete'].'"><h6>' .strtoupper(substr($user['name_complete'], 0, 15)) . '</h6></th>';
                }}}
                echo '
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse' . $collapseCount . '">
                        <h4 class="panel-title">' . utf8_encode($key) . '</h4>
                    </a>
                </div>
                <div id="collapse' . $collapseCount . '" class="panel-collapse collapse out" name="' . utf8_encode($key) . '">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th class="valueWidth">Valor</th>
                                        <th class="timeWidth">Tempo</th>
                                        ' . utf8_encode($servicesUser) . '
                                    </tr>
                                </thead>
                                <tbody>';

                foreach ($service as $details) {
                    $servicesUser = "";
					if(!empty($details['users'])){
                    foreach ($details['users'] as $user) {
						//if($user['excluded'] == 0){
                        if ($user['has_service']) {
                            $servicesUser .= '<td><input title="'.$user['name_complete'].'" type="checkbox" class="form-control" name="data[' . $details['service_id'] . '][user][]" value="' . $details['service_id'] . '-' . $user['id'] . '" checked="checked"/></td>';
                        } else {
                            $servicesUser .= '<td><input title="'.$user['name_complete'].'" type="checkbox" class="form-control" name="data[' . $details['service_id'] . '][user][]" value="' . $details['service_id'] . '-' . $user['id'] . '" /></td>';
                        }
						//}
                    }}
                    $service_value = "";
                    $service_time = "";
                    if ($details['service_value'] != 0) {
                        $service_value = $details['service_value'];
                    }
                    if ($details['service_value'] != 0) {
                        $service_time = $details['service_time'];
                    }
                    echo '
                                    <input type="hidden" value="' . $details['service_id'] . '" name="data[' . $details['service_id'] . '][id]" />
                                    <tr>
                                        <td>
                                            <input type="hidden" class="form-control" name="data[' . $details['service_id'] . '][subclasses]" value="' . $details['id'] . '">
                                           <span id="'. $details['service_id'].'"> ' .  utf8_encode($details['subcategory_name']) . '</span>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input type="text" class="form-control" id="inputAmount" placeholder="Valor" value="' . $service_value . '" name="data[' . $details['service_id'] . '][value]">
                                                <div class="input-group-addon">.00</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="inputTime" placeholder="Tempo" value="' . $service_time . '" name="data[' . $details['service_id'] . '][time]">
                                                <div class="input-group-addon">Min</div>
                                            </div>
                                        </td>
                                        ' . $servicesUser . '
                                    </tr>

                                    ';
                }
                echo '
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>';
                $collapseCount++;
				
            }
        }
        ?>
    </div>
    <div class="panel-body">
		
        <button type="submit" class="btn btn-primary pull-right ">Salvar</button>
		<button type="button" class="btn btn-default pull-right " data-toggle="modal" data-target="#myModal">Criar Serviço</button>
				
    </div>
</form>
<!-- POP UP -->
<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" >
        <div class="modal-content" id="modelContent">
            <div class="modal-body">
			<form action="<?php echo $this->Html->url("addSubclass"); ?>" method="post">
                <div class="form-horizontal">
                    <legend>Novo Serviço</legend>
                    <div class="form-group">
                        <div class="col-sm-12">
							<label for="serviceCategory">Categoria do Serviço</label>
                           <select class="form-control" id="serviceCategory" name="data[serviceCategory]" required="required">
								<?php foreach($allClasses as $class){?>
								<option id="<?php echo $class['classes']['id']?>" value="<?php echo $class['classes']['id']?>"><?php echo utf8_encode($class['classes']['name']); ?> </option>
								<?php }?>
						   </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
						<label for="serviceName">Nome do Serviço</label>
                           <input type="text" class="form-control" id="serviceName" name="data[serviceName]" required="required" />
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="col-sm-12 buttonLocation">
                                <input type="hidden" name="userId" id="userId" value="" />
                                <button type="submit" class="btn btn-success" id="btnNewService">Cadastrar</button>
								<button type="button" class="btn btn-danger" id="btnCancelNewService" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
				</form>
                </div>
            </div>
        </div>
    </div>
</div>



