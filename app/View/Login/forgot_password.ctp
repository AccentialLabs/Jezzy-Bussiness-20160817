<?php $this->Html->css('View/Login.forgot_password', array('inline' => false)); ?>

<form class="form-signin" action="<?php echo $this->Html->url("sendPassword"); ?>" method="post">
    <h2 class="form-signin-heading">Esqueceu sua senha?</h2>
    <?php 
        $message = $this->Session->flash();
        if($message !== null && $message != ""){
            echo '<div class="alert alert-danger centerText" role="alert">'.$message.'</div>';
        }
    ?>
    <label for="inputEmail" class="sr-only">E-mail</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="E-mail" required autofocus name="data[Company][email]">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Envia nova senha no e-mail</button>
</form>
<div class="form-signin">
    <a href="<?php echo $this->Html->url("index"); ?>">
        <button class="btn btn-lg btn-warning btn-block" type="button"><span class="glyphicon glyphicon-arrow-left"></span> Lembrei, me leve de volta!</button>
    </a>
</div>
