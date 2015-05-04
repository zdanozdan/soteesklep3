<!DOCTYPE html>
<html lang="<?php print $config->lang ?>">
  <head>
    <?php require_once('header.html.php') ?>
  </head>
<body>

<?php require_once('banner.html.php') ?>

<div class="container">  
  <div class="row">
    <div class="span12">
      <p><?php $o_main->$main();?></p>
    </div>
  </div>
  <div class="row">
    <div class="span12">
      <?php $this->foot() ?>
    </div>
  </div>
</div>
</body>