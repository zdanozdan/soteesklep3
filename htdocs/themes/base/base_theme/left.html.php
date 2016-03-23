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

<div id="myCarousel" class="carousel slide">
    <ol class="carousel-indicators">
	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	<li data-target="#myCarousel" data-slide-to="1"></li>
	<li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
	<div class="item active" id="renfert">
	    <a href="http://www.renfert.com/pol/en/renfert-sandblasters-pl.html?utm_source=mikran&utm_medium=webbanner&utm_campaign=strahlgeraete"><img src="/photo/_reklama/Banner_300x600px.png"></a>
	</div>
	<div class="item" id="dreve">
	    <a href="/id8415/Drufosmart-Scan-z-funkcja-rozpoznawania-folii"><img src="/photo/_reklama/drufosmart_banner.jpg"></a>
	</div>
	<div class="item" id="eveevolution">
	    <a href="/pl/id10424/Dreve-Lampa-Eye-Volution-MAX-PROMOCJA-kompozyt-SR-Nexco-Promo-Kit-oraz-Dreve-Multispot-GRATIS"><img src="/photo/_reklama/banner_dreve_dentamid_eyevolution.png"></a>
	</div>
    </div>
    <!-- Carousel nav -->
    <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>

<?php
global $config;
//sprawdzenie czy opcja newsletter jest wybrana przez administratora
if (((@$config->catalog_mode==0) && ($config->newsletter==1))||((@$config->catalog_mode==1)&&(@$config->catalog_mode_options['newsletter']==1))){
    $this->newsletter();
}


?>

<script>
$( document ).ready(function() {
    $('.carousel').carousel({
    interval: 5000
    })
})
</script>
