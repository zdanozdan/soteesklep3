<!DOCTYPE html>
<html lang="pl">
  <head>
    <?php require_once('header.html.php') ?>
  </head>
<body>

<?php require_once('banner.html.php') ?>

<div class="container">
  <div class="row">
    <div class="span12">
      <ul class="breadcrumb">
	<li><a href="/">Home</a> <span class="divider">/</span></li>
	<li><a href="/koszyk-start"><?php echo $lang->head_products_show;?></a> <span class="divider">/</span></li>
	<li><a href="/koszyk-start"><?php echo $lang->step_one_of_two; ?></a> <span class="divider">/</span></li>
      </ul>
    </div>
  </div>
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