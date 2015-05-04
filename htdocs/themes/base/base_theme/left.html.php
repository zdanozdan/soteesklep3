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

<!--
<div class="head_1">
<?php echo $lang->bar_title["katalog"]; ?>
</div>

<div id="block_1">
<a title="Przeglądaj lub pobierz teraz nasz katalog w formacie PDF" href="/katalog-mikran-do-pobrania"><img src="/katalog_pdf/mikran_katalog.jpg" width="170px" alt="Przegladaj lub pobierz katalog w formacie PDF"/><h2>Przegladaj lub pobierz katalog w formacie PDF</h2></a>
</div>
--!>


<?php
global $config;
//sprawdzenie czy opcja newsletter jest wybrana przez administratora
if (((@$config->catalog_mode==0) && ($config->newsletter==1))||((@$config->catalog_mode==1)&&(@$config->catalog_mode_options['newsletter']==1))){
    $this->newsletter();

}


?>
