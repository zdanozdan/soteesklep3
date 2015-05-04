<html lang="<?php print $config->lang ?>">
  <head>
    <?php require_once('header.html.php') ?>
  </head>
<body>

<?php require_once('banner.html.php') ?>

<div class="container">
  <div class="row">
    <div class="span12">
      <?php 
	 include_once ("include/category.inc"); 
	 $cat = new NavbarCategory;
	 $cat->init();
	 ?>      

      <ul class="breadcrumb">
	<li><a href="/">Home</a> <span class="divider">/</span></li>
	<li><a href="/">Sitemap</a> <span class="divider">/</span></li>

	<?php if (is_null($_REQUEST['search_query_words']) == False) : ?>
	<li><?php echo $lang->search ?><span class="divider">/</span></li>
	<li><a href="#"><?php echo $_REQUEST['search_query_words'] ?></a> <span class="divider">/</span></li>
	<?php endif ?>
      </ul>

    </div>
  </div>
  <div class="row">
    <div class="span4">
      <p><?php $this->left();?></p>
    </div>
    <div class="span8">
      <ul class='unstyled block_1'><?php $o_main->$main();?></ul>
    </div>
  </div>
  <div class="row">
    <div class="span12">
      <?php $this->foot() ?>
    </div>
  </div>
</div>
</body>

