   <?php //echo $lang->left_choose_category; ?>
<div>
 <ul class="nav nav-tabs nav-stacked">
   <?php include_once ("include/category.inc"); ?>
   <?php $cat = new NavbarCategory; ?>
   <?php $cat->init(); ?>
   <?php $cat->menu() ?>
</ul>
</div>

<div class="head_1">
Mikran Team
</div>
<div id="block_1">
<?php $this->file("infoline.html"); ?>
</div>

<div id="renfert">
    <a href="id10722/Obcinarka-MT3-Pro-z-tarcza-Marathon"><img src="/photo/_reklama/MT3_300x600px_Polen.png"></a>
</div>


<?php
global $config;
//sprawdzenie czy opcja newsletter jest wybrana przez administratora
if (((@$config->catalog_mode==0) && ($config->newsletter==1))||((@$config->catalog_mode==1)&&(@$config->catalog_mode_options['newsletter']==1))){
    $this->newsletter();
}


?>
