<?php echo $this->Html->css('View/User.index', array('inline' => false)); ?>
<?php echo $this->Html->script('util', array('inline' => false)); ?>
<?php echo $this->Html->script('View/User.index', array('inline' => false)); ?>
<h1 class="page-header" style="margin-top: -38px;">Configurações de usuários</h1>
<div>
    <ul class="nav nav-tabs">
	<?php
                            if ($userLoggedType != 3 && $userLoggedType != 2) { ?>
        <li class="active"><a data-toggle="tab" href="#sectionA">Usuário Master</a></li>
		<?php }?>
        <li><a data-toggle="tab" href="#sectionB">Funcionários e Permissões</a></li>
        <li><a data-toggle="tab" href="#sectionC">Cargos</a></li>
        <li><a data-toggle="tab" href="#sectionD">Usuários Removidos</a></li>
		 <li><a data-toggle="tab" href="#sectionE">Funcionários Associados</a></li>
    </ul>
    <div class="tab-content">
	<?php
                            if ($userLoggedType != 3 && $this->Session->read('userLoggedType') != 2) { ?>
        <div id="sectionA" class="tab-pane fade in active">
			<h4>Alteração de Senha</h4>
            <form class="form-horizontal" id="primaryUserForm" action="<?php echo $this->Html->url("updatePrimaryUser"); ?>" method="post">
                <div class="form-group marginTop10">
                    <label for="inputEmail3" class="col-sm-2 control-label">Nome</label>
                    <div class="col-sm-6">
                        <input name="data[User][name]" required type="text" class="form-control" id="" placeholder="Nome" value="<?php echo $company['Company']['responsible_name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">E-mail</label>
                    <div class="col-sm-6">
                        <input name="data[User][email]" required type="email" class="form-control"  id="" placeholder="E-mail" value="<?php echo $company['Company']['email']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Senha antiga</label>
                    <div class="col-sm-6">
                        <input name="data[User][pass]" type="password" class="form-control" id="" placeholder="Senha antiga">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Senha nova</label>
                    <div class="col-sm-6">
                        <input name="data[User][passNew1]" type="password" class="form-control" id="" placeholder="Senha nova">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Repete senha</label>
                    <div class="col-sm-6">
                        <input name="data[User][passNew2]" type="password" class="form-control" id="" placeholder="Repete senha">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </div>
                <?php
                $message = $this->Session->flash();
                if ($message !== null && $message != "") {
                    echo '
                        <div class="alert alert-warning alert-dismissible col-sm-6 col-sm-offset-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Cuidado!</strong> ' . $message . '
                        </div>';
                } else {
                    echo '
                        <div class="alert alert-success alert-dismissible col-sm-6 col-sm-offset-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Atenção!</strong> Ao alterar sua senha o sistema vai te desviar para a tela de login.
                        </div>';
                }
                ?>
			<div class="col-md-12">
				<div class="col-md-12 help-icon" data-toggle="modal" data-target="#myModalHelper">
					<?php echo $this->Html->image('jezzy_icons/help-icon.png'); ?>
				</div>
			</div>
            </form>
        </div>
		<?php }?>
		
        <div id="sectionB" class="tab-pane <?php if ($userLoggedType != 1 && $this->Session->read('userLoggedType') != 2) { ?>fade<?php }?>">
            <table class="table table-bordered table-condensed small" id="secundaryUserTable">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cargo</th>
						<th>Editar</th>
                        <th>Exluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (is_array($secundaryUsers)) {
                        foreach ($secundaryUsers as $user) {
                            if ($user['secondary_users']['excluded'] == 0) {
                                echo '
                                <tr>
                                    <td>' . $user['secondary_users']['name'] . '</td>
                                    <td>' . $user['secondary_users']['email'] . '</td>
                                    <td>' . $user['secondary_users_types']['name'] . '</td>
									 <td><span id="edit-' . $user['secondary_users']['id'] . '" class="glyphicon glyphicon-pencil glyph-button" onclick="editUser(\''.$user['secondary_users']['name'].'\', \''.$user['secondary_users']['email'].'\', \''.$user['secondary_users_types']['name'].'\', \''.$user['secondary_users']['id'].'\')"></span></td>
                                    <td><span id="' . $user['secondary_users']['id'] . '" class="glyphicon glyphicon-remove-sign" glyph-button></span></td>
                                </tr>';
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
            <button id="buttonAddNewUser" type="button" class="btn btn-primary pull-right">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
			
			<button id="buttonAddAssociatedUser" type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#associatedUserModal">Adicionar Associado existente</button>
			
			<input type="text" id="editSecondaryUser" class="input-hidden"/>
			<input type="text" id="editSecondaryUserID" class="input-hidden"/>
        </div>
        <div id="sectionC" class="tab-pane fade">
            <table class="table table-bordered table-condensed small">
                <thead>
                    <tr>
                        <th>Cargos</th>
                        <th>Ofertas</th>
                        <th>Assinaturas</th>
                        <th>Vendas</th>
                        <th>Wishlist</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (is_array($secundaryUserTypes)) {
                        foreach ($secundaryUserTypes as $user) {
                            switch ($user['secondary_users_types']['assignment_offers']) {
                                case 1:
                                    $offers = 'Permissão Geral';
                                    break;
                                case 2:
                                    $offers = 'Incluir e Consultar dados';
                                    break;
                                case 3:
                                    $offers = 'Somente Consultar dados';
                                    break;
                                default:
                                    $offers = "";
                                    break;
                            }
                            switch ($user['secondary_users_types']['assignment_signatures']) {
                                case 1:
                                    $signatures = 'Permissão Geral';
                                    break;
                                case 2:
                                    $signatures = 'Incluir e Consultar dados';
                                    break;
                                case 3:
                                    $signatures = 'Somente Consultar dados';
                                    break;
                                default:
                                    $signatures = "";
                                    break;
                            }
                            switch ($user['secondary_users_types']['assignment_checkouts']) {
                                case 1:
                                    $checkouts = 'Permissão Geral';
                                    break;
                                case 2:
                                    $checkouts = 'Incluir e Consultar dados';
                                    break;
                                case 3:
                                    $checkouts = 'Somente Consultar dados';
                                    break;
                                default:
                                    $checkouts = "";
                                    break;
                            }
                            switch ($user['secondary_users_types']['assignment_wishlist']) {
                                case 1:
                                    $wishlist = 'Permissão Geral';
                                    break;
                                case 2:
                                    $wishlist = 'Incluir e Consultar dados';
                                    break;
                                case 3:
                                    $wishlist = 'Somente Consultar dados';
                                    break;
                                default:
                                    $wishlist = "";
                                    break;
                            }
                            echo '
                                <tr>
                                    <td id="cargo">' . $user['secondary_users_types']['name'] . '</td>
                                    <td>' . $offers . '</td>
                                    <td>' . $signatures . '</td>
                                    <td>' . $checkouts . '</td>
                                    <td>' . $wishlist . '</td>
                                </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div id="sectionD" class="tab-pane fade">
			<br/>
            <div class="panel panel-default">
                <div class="panel-body">
                    Se a lista não parece estar atualizada, recarregue a página.
                </div>
            </div>
            <table class="table table-bordered table-condensed small" id="secundaryUserTable">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cargo</th>
                        <th>*</th>
						<th>Reativar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (is_array($secundaryUsers)) {
                        foreach ($secundaryUsers as $user) {
                            if ($user['secondary_users']['excluded'] == 1) {
                                echo '
                                <tr id="reactive-'.$user['secondary_users']['id'].'">
                                    <td><a href="#">' . $user['secondary_users']['name'] . '</a></td>
                                    <td>' . $user['secondary_users']['email'] . '</td>
                                    <td>' . $user['secondary_users_types']['name'] . '</td>
                                    <td>REMOVIDO</td>
									<td><span id="reativar-' . $user['secondary_users']['id'] . '" class="glyphicon glyphicon-ok glyph-button" onclick="reativeUser('.$user['secondary_users']['id'].')"></span></td>
                                </tr>';
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
			
		<div id="sectionE" class="tab-pane fade">
			<div><h4>Solicitações Enviadas:</h4></div>
			
			<?php 
				if(!empty($associatedUserSolicitations)){ ?>
				
				 <table class="table table-bordered table-condensed small" id="secundaryUserTable">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Data da Solicitação</th>
						<th>Status</th>
                        <th>*</th>
                    </tr>
                </thead>
				<tbody>
					<?php 
						foreach($associatedUserSolicitations as $solicitation){
						if($solicitation['associated_user_solicitations']['status'] != 'DENIED'){
					?>
					<tr id="associatedSolicitation<?php echo $solicitation['associated_user_solicitations']['id'];?>">
						<td><strong><?php echo $solicitation['associated_users']['name'];?></strong></td>
						<td><?php echo $solicitation['associated_users']['email'];?></td>
						<td><?php echo date('d/m/Y', strtotime($solicitation['associated_user_solicitations']['date_request']));?></td>
						<td><?php echo $solicitation['associated_user_solicitations']['status'];?></td>
						<td><span class="glyphicon glyphicon-remove-sign associatedSolicitationRemove" id="<?php echo $solicitation['associated_user_solicitations']['id'];?>"></span></td>
					</tr>
					<?php
					} }
					?>
				</tbody>
				</table>
				
		<?php		}
			?>
			
			
		</div>
		
  </div>
</div>

<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" id="modelContent">
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group marginTop10">
                        <label for="inputEmail3" class="col-sm-2 control-label">Nome *</label>
                        <div class="col-sm-6">
                            <input name="data[secundary_user][name]" type="text" class="form-control" id="secundary_user_name" placeholder="Nome" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">E-mail *</label>
                        <div class="col-sm-6">
                            <input name="data[secundary_user][email]" type="email" class="form-control"  id="secundary_user_email" placeholder="E-mail" >
                        </div>
                    </div>
					<div class="form-group" id="cadSecondUserShowError" style="display: none;">
					<div class="col-sm-2"></div>
						<p class="col-sm-6">
							Este email já está sendo usado por outro usuário. 
						</p>
					</div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Cargo *</label>
                        <div class="col-sm-3">
                            <select  class="form-control" name="data[secundary_user][type]" id="secundary_user_type" >
                                <option value="">Selecione</option>
                                <?php
                                if (is_array($secundaryUserTypes)) {
                                    foreach ($secundaryUserTypes as $user) {
                                        echo '<option value="' . $user['secondary_users_types']['id'] . '">' . $user['secondary_users_types']['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
					
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button id="userModalButom" type="button" class="btn btn-success" disabled="true">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModalHelper" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md" >
        <div class="modal-content" id="modelContent">
            
			<div class="modal-body" id="recebe">
				<p>
					<div style="col-md-10">
						<h4>Usuário Master</h4><hr />
						O Usuário Master é o ....
					</div>
				</p>
			</div>
		</div>
	</div>
</div>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#deleteUserModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4> </h4>
      </div>
      <div class="modal-body">
        Deseja excluir este usuário?
		<input type="text" id="userIdDelete" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnDeleteUser">Excluir</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal REATIVAR -->
<div class="modal fade bs-example-modal-sm" id="reativeUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4> </h4>
      </div>
      <div class="modal-body">
        Deseja reativar este usuário?
		<input type="text" id="userIdReative" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnReativeUser">Reativar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal REATIVAR -->
<div class="modal fade bs-example-modal-sm" id="associatedUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4> </h4>
      </div>
      <div class="modal-body" id="modalBodyAssociatedUser">
        Digite o Email do associado:<br/>
		<input type="text" class="form-control" id="associatedUserEmailRequisition" />
		<br/>
		<div id="associatedSolicitationInfosUser">
		<strong>Nome: </strong><span id="associatedSolicitationName"></span><br />
		<strong>Email: </strong><span id="associatedSolicitationEmail"></span><br/>
		<input type="hidden" id="associatedSolicitationUserId" /> 
		</div>
		<strong id="associatedSolicitationError">Não existe funcionário cadastrado com esse email</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSendAssociatedRequisition">Enviar solicitação</button>
      </div>
    </div>
  </div>
</div>


<div class="">
	<?php echo $this->Html->image("loading.gif", array('class' => 'loading-image')); ?>
</div>
