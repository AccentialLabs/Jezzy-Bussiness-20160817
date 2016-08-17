 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <?php echo $this->Html->css('bootstrap.min'); ?>
 <?php echo $this->Html->css('View/Register'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <?php echo $this->Html->script('bootstrap.min'); ?>
		<?php echo $this->Html->script('jquery.mask'); ?>
		<?php echo $this->Html->script('jquery.mask.min'); ?>
		 <?php echo $this->Html->script('View/Register'); ?>
		
		
		<div class="headerrr">
			<div class="bem-vindo col-md-4">
				<?php echo $this->Html->image('jezzy_logo/jezzy_logo_empresas.png'); ?>
				<br/>
				<a href="#cadastro-recebe" class="btn btn-dark btn-lg">Quero me Cadastrar</a>
			</div>
		</div>
		
 <div class="modal-body col-md-12" id="cadastro-recebe"> 
				  <form class="form-horizontal" role="form" method="post" action="inserCompany" id="companyForm"  enctype="multipart/form-data" >
                    <!-- 1 -->
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label  class="control-label label-padding"
                                    for="data[Company][logo]">Logo</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control mandatory_fild" 
                                       id="data[Company][logo]" name="data[Company][logo]" placeholder="Logo"/>
                            </div>
                        </div>
                    </div>

                    <!-- 2 -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label  class="control-label label-padding"
                                    for="data[Company][corporate_name]">Razão social</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild" 
                                       id="data[Company][corporate_name]" name='data[Company][corporate_name]' placeholder="Razão Social"/>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label  class="control-label label-padding"
                                    for="data[Company][fancy_name]">Nome Fantasia</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild" 
                                       id="data[Company][fancy_name]" name='data[Company][fancy_name]' placeholder="Nome Fantasia"/>
                            </div>
                        </div>
                    </div>


                    <!-- 3 -->
                    <div class="row">

                        <div class="form-group col-md-3">
                            <label  class="control-label label-padding"
                                    for="data[Company][cnpj]">CNPJ</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control cnpj mandatory_fild registerCompanyCNPJ" 
                                       id="data[Company][cnpj]" name="data[Company][cnpj]" placeholder="CNPJ"/>
									   <small id="cnpjMsgError">Esse cnpj não é válido</small>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label  class="control-label label-padding"
                                    for="data[Company][phone]">Telefone </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control phone mandatory_fild" 
                                       id="data[Company][phone]" name="data[Company][phone]" placeholder="Telefone"/>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label  class="control-label label-padding"
                                    for="data[Company][phone_2]">Telefone 2</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control phone" 
                                       id="data[Company][phone_2]" name="data[Company][phone_2]" placeholder="Telefone 2"/>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label  class="control-label label-padding"
                                    for="data[Company][email]">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control mandatory_fild registerCompanyEmail" 
                                       id="data[Company][email]" name="data[Company][email]" placeholder="Email"/>
									   <small id="emailMsgError">Email já cadastrado</small>
                            </div>

                        </div>
                    </div>

                    <!-- 4 -->
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label  class="control-label label-padding"
                                    for="data[Company][site]">Site</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" 
                                       id="data[Company][site]" name="data[Company][site]" placeholder="Site"/>
                            </div>
                        </div>
                    </div>


                    <!-- 5 -->
                    <hr />
                    <h4 class="modal-title" id="myModalLabel">Responsável pela conta</h4>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label  class="control-label label-padding"
                                    for="data[Company][responsible_name]">Nome</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild" 
                                       id="data[Company][responsible_name]" name="data[Company][responsible_name]" placeholder="Nome e Sobrenome"/>
                            </div>
                        </div>
                    </div>

                    <!-- 6 -->
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label  class="control-label label-padding"
                                    for="data[Company][responsible_email]">Email <small>  Será usado para acesso ao sistema</small></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild registerCompanyResponsibleEmail" 
                                       id="data[Company][responsible_email]" name="data[Company][responsible_email]" placeholder="Email"/>
									   <small id="responsibleEmailMsgError">Email já cadastrado</small>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label  class="control-label label-padding"
                                    for="data[Company][responsible_birthday]">Data de Nascimento</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild registerCompanyResponsibleBirthday" 
                                       id="data[Company][responsible_birthday]" name="data[Company][responsible_birthday]" placeholder="Data de Nascimento"/>
                            </div>
                        </div>
                    </div>

                    <!-- 7 -->
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label  class="control-label label-padding"
                                    for="data[Company][responsible_cpf]">CPF</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control cpf mandatory_fild registerCompanyCPF" 
                                       id="data[Company][responsible_cpf]" name="data[Company][responsible_cpf]" placeholder="CPF"/>
									   <small id="cpfMsgError">Digite um cpf válido</small>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label  class="control-label label-padding"
                                    for="data[Company][responsible_phone]">Telefone</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control phone mandatory_fild" 
                                       id="data[Company][responsible_phone]" name="data[Company][responsible_phone]" placeholder="Telefone"/>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label  class="control-label label-padding"
                                    for="data[Company][responsible_phone_2]">Telefone 2</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control phone" 
                                       id="data[Company][responsible_phone_2]" name="data[Company][responsible_phone_2]" placeholder="Telefone 2"/>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label  class="control-label label-padding"
                                    for="data[Company][responsible_cell]">Celular</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control phone" 
                                       id="data[Company][responsible_cell]" name="data[Company][responsible_cell]" placeholder="Celular"/>
                            </div>
                        </div>
                    </div>

                    <!-- 8 -->
                    <hr />
                    <h4 class="modal-title" id="myModalLabel">Endereço</h4>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label  class="control-label label-padding"
                                    for="data[Company][cep]">CEP</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild" 
                                       id="cep" name="data[Company][cep]" placeholder="CEP"/>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label  class="control-label label-padding"
                                    for="data[Company][address]">Rua</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild" 
                                       id="logradouro" name="data[Company][address]" placeholder="Endereço"/>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label  class="control-label label-padding"
                                    for="data[Company][number]">Número</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild" 
                                       id="data[Company][number]" name="data[Company][number]" placeholder="Número"/>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label  class="control-label label-padding"
                                    for="data[Company][complement]">Complemento</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" 
                                       id="data[Company][complement]" name="data[Company][complement]" placeholder="Complemento"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label  class="control-label label-padding"
                                    for="data[Company][district]">Bairro</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild" 
                                       id="bairro" name="data[Company][district]" placeholder="Bairro"/>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label  class="control-label label-padding"
                                    for="data[Company][city]">Cidade</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild" 
                                       id="localidade" name="data[Company][city]" placeholder="Cidade"/>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label  class="control-label label-padding"
                                    for="data[Company][uf]">UF</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control mandatory_fild" 
                                       id="uf" name="data[Company][uf]" placeholder="UF"/>
                            </div>
                        </div>
                    </div>
					 <hr />
					 
					 <div class="jumbotron text-center jumbotron-personal">
					 
					Ao clicar em <strong>Cadastrar</strong> significa que você concorda com os<br/> <a href="http://www.jezzy.com.br/site/termos-e-condicoes-de-uso/">Termos de Uso e Condições</a> e a
					<a href="http://www.jezzy.com.br/site/politica-de-privacidade/">política de privacidades.</a>
					<br/><br/>
					<div class="checkbox">
    <label><input type="checkbox" id="notRobot" name="notRobot"> <strong>Eu não sou um robô</strong></label>
  </div>
							
					 </div>
					 
	<div>
		<button type="submit" id="btnSubmit" class="btn btn-default pull-right form-button">Cadastrar</button>
		<a class="" href="<?php echo $this->Html->url("../login/index"); ?>"> <button type="button" class="btn btn-danger pull-right">Cancelar</button></a>
	</div>
	</form>
                </div>
				<footer class="footerrr"><span class="footer-content">JEZZY</span> <span class="footer-content">• +55 11 38792-7737| +55 11 3142-9776</span> <span class="footer-content">• contato@jezzy.com.br</span></footer>
				
<?php echo $this->Html->image('loading.gif', array('alt' => 'Loading', 'id' => 'loading-addres')); ?>					
<?php echo $this->Html->image('loading.gif', array('alt' => 'Loading', 'id' => 'loading')); ?>		


<!-- MODAL QUE MOSTRARÁ OS PLANOS-->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4> Selecione seu plano JEZZY:</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form">
            <div class="form-group">
              
			  <div class="row plano-row">
			 <div class="item-plano pull-left" >
				<div class="plano-header" >
					<h4> STANDARD</h4>
				</div>
				<div class="almost-jumbotron">
					<ul>
						<li>Aplicativo para o Salão (web) com todas as funcionalidades disponíveis;</li>
						<li>Aplicativos mobile (iOs e Android) para o Cabelereiro(a) e para o Cliente final com todas as funcionalidades disponíveis;</li>
						<li>Venda e entrega de produtos para o Cliente final (<i>nós entregamos e comissionamos seu Salão!</i>);</li>
						<li>Kit de divulgação para ponto de venda (<i>adesivos e folhetos</i>).</li>

					</ul>
					</div>
					<div class="plano-valor" >
					<h4>R$149,80 <small class="plano-small">mensal, debitados no Cartão de Crédito -- 15 dias GRATUITO!</small></h4>
				</div>
			  </div>
			  
			   <div class="item-plano pull-left" >
				<div class="plano-header" >
					<h4> PREMIUM</h4>
				</div>
				<div class="almost-jumbotron">
					<ul>
						<li>Aplicativo personalizado com logotipo e cores para o Salão (web) com todas as funcionalidades disponíveis;</li>
						<li>Aplicativos mobile (iOs e Android) personalizados nas lojas de aplicativos AppStore e GooglePlay, com logotipo e cores do Salão para o Cabelereiro(a) e para o Cliente final com todas as funcionalidades disponíveis;</li>
						<li>Venda e entrega de produtos para o Cliente final (<i>nós entregamos e comissionamos seu Salão!</i>);</li>
						<li>Kit de divulgação personalizado para ponto de venda (<i>adesivos e folhetos</i>).</li>
						
					</ul>
					
					
					
				</div>
				<div class="plano-valor" >
					<h4>R$249,80 <small class="plano-small">mensal, debitados no Cartão de Crédito -- sem custo de personalização ou implantação!
</small></h4>
				</div>
			  </div>
			  </div>
			  
            </div>
        
          </form>
        </div>
        <div class="modal-footer text-right">
          <button type="submit" class="btn btn-default btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
		  <button type="submit" class="btn btn-default btn-success" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span> Continuar</button>
        </div>
      </div>
      
    </div>
  </div> 
  
    <!-- <button type="button" class="btn btn-default btn-lg" id="myBtn">Login</button> -->
	
	<!-- ESTILO E COMPORTAMENTO DA MODAL -->
	<script>
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});
</script>


