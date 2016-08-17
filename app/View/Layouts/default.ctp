<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8"/>
        <title>
            Primeira Aplicação com CakePHP
        </title>
  <?php
    echo $this->fetch('css');
  ?>
    </head>
    <body>
        <div id="container">
            <div id="content">
      <?php echo $this->fetch('content'); ?>
            </div>
        </div>
  <?php
   echo $this->fetch('script');
  ?>
    </body>
</html>