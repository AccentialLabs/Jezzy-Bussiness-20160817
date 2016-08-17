<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <?php echo $this->Html->meta('icon'); ?>
        <title><?php echo $title_for_layout; ?></title>

        <!-- Bootstrap core CSS -->
        <?php echo $this->Html->css('bootstrap.min'); ?>
        <?php echo $this->Html->css('custom'); ?>
        <!-- Custom styles for this template -->
        <?php echo $this->Html->css('business'); ?>
        <!-- Add the CSS files -->
        <?php echo $this->fetch('css'); ?>
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <!--<script src="../../assets/js/ie-emulation-modes-warning.js"></script>-->
        <?php echo $this->Html->script('business/ie-emulation-modes-warning'); ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="dashboard"><?php echo $this->Html->image('jezzy_logo/jezzylogo.png', array('class' => 'logoNav')); ?></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" id="fancy-name-comp">

						<?php if($this->Session->read('userLoggedType') == 1){echo $this->Session->read('CompanyLoggedIn.Company.responsible_name'). ' - '; }else{
						echo $this->Session->read('SecondaryUserLoggedIn.0.secondary_users.name'). ' - '; } echo $this->Session->read('CompanyLoggedIn.Company.fancy_name'); ?> <div class="badge" id="notification-counter"></div></a></li>
                        <?php
                            if ($this->Session->read('userLoggedType') != 3 && $this->Session->read('userLoggedType') != 2) {
                                echo '<li><a href="'.$this->Html->url("/Settings").'"> Configurações</a></li>';
                            }
                        ?>
                        <li><a href="<?php echo $this->Html->url("/login/logout"); ?>">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar marginMenu"  id="menuBusiness">
                    <div id="menuBusinessIcon">
                        <ul class="nav nav-sidebar">
                            <li class="<?php echo $title_for_layout == "Dashboard" ? "active" : ""; ?>">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-home"></span>', '/dashboard', array('class' => 'dashboad', 'escape' => false)); ?>
                            </li>
							
                            <li class="<?php echo $title_for_layout == "Produtos" ? "active" : ""; ?>">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-tag"></span>', '/product', array('class' => 'product', 'escape' => false)); ?>
                            </li>
							
                            <li class="<?php echo $title_for_layout == "Agenda" ? "active" : ""; ?>">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-calendar"></span>', '/schedule', array('class' => 'schedule', 'escape' => false)); ?>
                            </li>
                            <li class="">
                                <a><span class="glyphicon glyphicon-list"></span></a>
                            </li>
                            <li class="">
                                <a><span class="glyphicon glyphicon-cog"></span></a>
                            </li>

                        </ul>
                    </div>

                    <div id="menuBusinessFull">
                        <ul class="nav nav-sidebar">
                            <li class="<?php echo $title_for_layout == "Dashboard" ? "active" : ""; ?>">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-home"></span> Dashboard', '/dashboard', array('class' => 'dashboad', 'escape' => false)); ?>
                            </li>
							
							<?php if ($this->Session->read('userLoggedType') != 2) { ?>
                            <li class="<?php echo $title_for_layout == "Produtos" ? "active" : ""; ?>">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-tag"></span> Prod./Ofertas', '/product', array('class' => 'product', 'escape' => false)); ?>
                            </li>
							<?php }?>
							
                            <li class="<?php echo $title_for_layout == "Agenda" ? "active" : ""; ?>">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-calendar"></span> Agenda', '/schedule', array('class' => 'schedule', 'escape' => false)); ?>
                            </li>
								<?php
                            if ($this->Session->read('userLoggedType') != 2) { ?>
                            <li class="">
                                <a><span class="glyphicon glyphicon-list"></span> Relatórios</a>
                            </li>
						
                            <li class="<?php echo $title_for_layout == "Rel.Vendas" ? "active" : ""; ?>">
                                <?php echo $this->Html->link('Vendas', '/saleReport', array('class' => 'linkMenu', 'escape' => false)); ?>
                            </li>
							
                            <li class="<?php echo $title_for_layout == "Rel.Agendamento" ? "active" : ""; ?>">
                                <?php echo $this->Html->link('Agendamentos', '/scheduleReport', array('class' => 'linkMenu', 'escape' => false)); ?>
                            </li>
							<?php }?>
								<?php
                            if ($this->Session->read('userLoggedType') != 2) { ?>
                            <li class="<?php echo $title_for_layout == "Rel.Cliente" ? "active" : ""; ?>">
                                <?php echo $this->Html->link('Clientes', '/clientReport', array('class' => 'linkMenu', 'escape' => false)); ?>
                            </li>
							
							 <li class="<?php echo $title_for_layout == "Rel.Voucher" ? "active" : ""; ?>">
                                <?php echo $this->Html->link('Vouchers', '/Voucher', array('class' => 'linkMenu', 'escape' => false)); ?>
                            </li>
							<?php } ?>
                            <?php
                            if ($this->Session->read('userLoggedType') != 2) {
                                $userActive = $title_for_layout == "Usuarios" ? "active" : "";
                                $seviceActive = $title_for_layout == "Servicos" ? "active" : "";
                                echo '
                                    <li class="">
                                        <a><span class="glyphicon glyphicon-cog"></span>Configurações</a>
                                    </li>
                                    <li class="'.$userActive.'">
                                        '.$this->Html->link('Usuarios', '/user', array('class' => 'linkMenu', 'escape' => false)).'
                                    </li>
                                    <li class="'.$seviceActive.'">
                                        '.$this->Html->link('Serviços', '/service', array('class' => 'linkMenu', 'escape' => false)).'
                                    </li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div id="mainBusiness" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <!-- CONTENT GOES HERE -->
<?php echo $this->fetch('content'); ?>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <?php echo $this->Html->script('bootstrap.min'); ?>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
        <?php echo $this->Html->script('business/ie10-viewport-bug-workaround'); ?> 
<?php echo $this->Html->script('View/Layouts.default_business', array('inline' => false)); ?>
<?php echo $this->fetch('script'); ?>
        <script type="text/javascript">

        </script>
		
    </body>
</html>
