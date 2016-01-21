<?php
global $config;
?>

<div class="block_1">
<ul class="nav nav-pills">

<div class="btn-group pull-right">
  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
  <i class="icon-user"></i> <?php print $lang->head_my_account ?>
  <span class="caret"></span>
  </a>
  <ul class="dropdown-menu">
  <?php  if ((! empty($_SESSION['global_id_user'])) && (! empty($_SESSION['global_login']))) : ?>
  <li><a href="<?php print $config->url_prefix?>/go/_users/index.php"><?php print $lang->head_my_account ?></a></li>
  <li><a href="<?php print $config->url_prefix?>/go/_users/orders.php"><?php print $lang->users_trans ?></a></li>
  <li><a href="<?php print $config->url_prefix?>/go/_users/register1.php"><?php print $lang->users_change_data ?></a></li>
  <li><a href="<?php print $config->url_prefix?>/go/_users/logout.php"><?php print $lang->users_logout ?></a></li>
  <?php else: ?>
  <li><a href="/go/_users/index.php"><?php print $lang->users_log_in ?></a></li>
  <?php endif ?>
    <!-- dropdown menu links -->
  </ul>
</div>

<div class="btn-group pull-right">
  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
  <?php $this->get_lang_img() ?>
  <span class="caret"></span>
  </a>
  <ul class="dropdown-menu" style="min-width:60px;min-height:44px">
    <!-- dropdown menu links -->
  <li><?php $this->lang_list(); ?></li>
  </ul>
</div>


  <li><a href="/"><?php print $lang->foot_main_page;?></a></li>
  <li><a href="/go/_promotion/saleoff.php"><?php print $lang->head_saleoff; ?></a></li>
  <li><a href="/go/_promotion/promo.php"><?php print $lang->foot_promotions; ?></a></li>
  <li><a href="/go/_files/?file=kursy.html"><?php print $lang->training; ?></a></li>
  <li><a href="/go/_files/?file=payments.html"><?php print $lang->foot_payments;?></a></li>
  <li><a href="/go/_files/?file=delivery.html"><?php print $lang->foot_delivery;?></a></li>
  <li><a href="https://drive.google.com/folderview?id=0B12554jLABN2Y1AtQ2FrRUVFdFk&usp=sharing"><?php print $lang->download_files ?></a></li>
<!--  <li><a href="/go/_files/?file=mikran_o_nas.html"><?php print $lang->gallery;?></a></li> -->
  <li><a href="/go/_files/?file=contact.html"><?php print $lang->head_contact;?></a></li>
</ul>

<?php
// odczytaj wyszukiwany ciag znakow
if (is_null($_REQUEST['search_query_words']) == False) 
  {
    $query=my($_REQUEST['search_query_words']);
  } 
//else  $query="";

?>

<div class="search-block">
<fieldset>
<legend class="text-center"><?php echo $lang->search_title ?></legend>
<form action="<?php echo $config->url_prefix?>/go/_search/full_search.php" method="get" name="SearchForm" class="search-form">
  <?php //if ($_SERVER['QUERY_STRING'] && !is_null($query)) : ?>
  <!-- <div class="alert alert-error">Nic nie znaleziono</div> -->
  <?php //endif ?>
  <div class="input-append">
  <input id="box" type="search" value="<?php echo $query ?>" name="search_query_words" placeholder="<?php echo $lang->search_title ?>">
  <button type="submit" class="btn btn-primary">
  <i class="icon-search"></i>
  <?php echo $lang->search ?>
  </button>
  </div>
</form>
</fieldset>
<!-- <a href='/go/_search/advanced_search.php'><?php print @$lang->search_advanced ?></a> -->
</div>
</div>

<?php
$display_in_head_basket = $_SESSION['head_display'];
if ($display_in_head_basket == false)
  {
       $basket=& new My_Ext_Basket();
       $my_basket=&$basket;
       $basket->init();
       print "<div class='block_1'>";
       $basket->showBasketFormLimited();
       print "</div>";
  }
$_SESSION['head_display'] = false;
?>
