<?php
/**
* Nag��wek stron
* Nag��wek wi�kszo�ci stron widocznych w sklepie
* The header displayed on most of the shop's pages
*
* @version    $Id: head.html.php,v 1.9 2007/12/03 15:21:24 tomasz Exp $
* @package    themes
* @subpackage base_theme
* \@lang
* \@encoding
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php print @$config->google['title'];?></title>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?php print $config->encoding;?>">
<meta NAME="Keywords" CONTENT="<?php print @$config->google['keywords'];?>">
<meta NAME="Description"  CONTENT="<?php print @$config->google['description'];?>">
<link rel="stylesheet" href="/themes/base/base_theme/_style/style.css?version=3" type="text/css">
<style type="text/css">
<?php $this->theme_file("_common/style/style.css");?>
</style>
<?php 
   $jsp = "/themes/base/$config->base_theme/_common/javascript/script01.js";
   echo "<script language=\"javascript\" src=\"$jsp\" type=\"text/javascript\"></script>\n";
   $jsp = "/themes/base/$config->base_theme/_common/javascript/style_changer01.js";
   echo "<script language=\"javascript\" src=\"$jsp\" type=\"text/javascript\"></script>\n"; 
   $jsp = "/themes/base/$config->base_theme/_common/javascript/selections01.js";
   echo "<script language=\"javascript\" src=\"$jsp\" type=\"text/javascript\"></script>"; 
?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>

<body onload="Init();startBlink()">
<?php
global $prefix, $config;
?>
<center>
  <?php 
   // $this->google();
  ?>

  <div style="width:770px;margin-top:5px;margin-bottom:5px;border:1px solid #B8CEE9;padding:3px">
  <a href="\">
  <img alt="<?php print $lang->head_mainbanner ?>" title="<?php echo $lang->head_bannertitle ?>" src='<?php $this->img("header.png"); ?>' border="0">
  </a>
  </div>

  <?php //require_once("przenosiny.html.php") ?>
  
  <div id="header_2">
  		<a href="/">
        <?php print $lang->foot_main_page;?>
        </a>

        &nbsp;|&nbsp;
        <a href="/go/_promotion/saleoff.php"> 
        <span style="color:orange"><?php print $lang->head_saleoff; ?></span>
        </a>

 &nbsp;|&nbsp;
        <a href="/go/_promotion/kursy.php"> 
        <span style="color:orange"><?php print "Kursy"; ?></span>
        </a>

&nbsp;|&nbsp;<a href="/go/_promotion/?column=promotion"> 
        <?php print $lang->foot_promotions;?>
        </a>&nbsp;|&nbsp;<a href="/go/_promotion/?column=newcol"> 
        <?php print $lang->foot_news;?>

        </a>

           <!--
           &nbsp;|&nbsp;<a href="/go/_files/?file=terms.html"> 
        <?php print $lang->foot_terms;?>
        </a> -->

        &nbsp;|&nbsp;<a href="/go/_files/?file=howtobuy.html"> 
        <?php print $lang->foot_howtobuy;?>
        </a>

  <!--
        &nbsp;|&nbsp;<a href="/go/_files/?file=payments.html"> 
           <?php print $lang->foot_payments;?>
        </a>


        &nbsp;|&nbsp;<a href="/go/_files/?file=delivery.html"> 
        <?php print $lang->foot_delivery;?>
        </a>
-->

        &nbsp;|&nbsp;<a href="http://docs.google.com/leaf?id=0B12554jLABN2ZDExNTg1YjMtYzdlMy00YWJkLWJlZDgtNWFhNzJhMTUwM2Q0&hl=pl">
        Pliki do pobrania</a>
        
<!--<sup style="color: red;\">Nowosc !</sup> --> </a>

&nbsp;|&nbsp;<a href="/go/_files/?file=mikran_o_nas.html">Galeria</a>

           &nbsp;|&nbsp;<a href="/go/_files/?file=contact.html"> 
        <?php print $lang->head_contact;?>
        </a>
<hr/>
        <?php
        global $config;
     
        if (((@$config->cd!=1)&&(@$config->catalog_mode==0))||((@$config->catalog_mode==1) && (@$config->catalog_mode_options['users']==1))){
            // print "<a href=\"/go/_users/new.php\">$lang->head_register</a> | ";
            print "<a href=\"/go/_users/index.php\">$lang->head_my_account</a>";
        }
        ?>

<?php
 global $_SESSION;
 if ((! empty($_SESSION['global_id_user'])) && (! empty($_SESSION['global_login'])))
     {  
        print "<a href=\"$config->url_prefix/go/_users/orders.php\">"." --> ".$lang->users_login." : ".$_SESSION['global_login']."</a> ";
        //print " &nbsp&nbsp&nbsp&nbsp";
        //print "<a href=\"$config->url_prefix/go/_users/logout.php\">".$lang->users_logout."</a>";
}
?>

<?php
     // jesli user jest zalogowany, to pokaz login zalogowanego uzytkownika
     // dodatkowo tworzymy panel pod g��wnym menu gdzie pisze 'Zalogowany ......'
     // jak nie jest zalogowany to ten panel nie jest wyswietlany
    // global $_SESSION;
     //if ((! empty($_SESSION['global_id_user'])) && (! empty($_SESSION['global_login']))) 
     //{    
     //   print "<div id=\"header_3\">";
      //  print "<table>";
     //   print "<tr>";
     //   print "<td align=\"center\">";
     //   print "<a href=\"$config->url_prefix/go/_users/account.php\">".$lang->users_login.": <b>".$_SESSION['global_login']."</b></a> ";
     //   print "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
     //   $this->ask4price();
     //   print "</td></tr></table></div>";
    // }
?>
  </div>

<div id="block_search_header">

<?php
// odczytaj wyszukiwany ciag znakow
if (! empty($_REQUEST['search_query_words'])) {
    $query_words=my($_REQUEST['search_query_words']);
} else  $query_words="";

$this->search_form("vertical",$query_words);

?>

</div>

<div id="header_4">
<?php
global $_SESSION;
print "<table width=\"770\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"block_1_basket\">";
//if (isset($_SESSION['head_display']))
//{
   $display_in_head_basket = $_SESSION['head_display'];
   if ($display_in_head_basket == false)
   {
       $basket=& new My_Ext_Basket();
       $my_basket=&$basket;
       $basket->init();
       print "<tr><td>";
       $basket->showBasketFormLimited();
       print "</tr></td>";
   }
//else
//      print "<table><tr><td></table>";
//}
$_SESSION['head_display'] = false;
print "</table>";
?>
</div>  

</center>
