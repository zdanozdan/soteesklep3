<?php
/**
* Stopka strony (wy¶wietlana na ka¿dej podstronie sklepu).
*
* @author  rp@sote.pl
* @version $Id: foot.html.php,v 1.11 2007/12/01 11:15:52 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>

<p />

<center>
  <table align="center" border="0" width="770" cellpadding="0" cellspacing="0">
    <?php
    global $__start_page;
    if ($__start_page==true) {
        /* Elementy pokazywane tylko na g³wnej stronie */
    ?>
    <tr>
      <td>      

    
      </td>
    </tr>
    <?php
    }
    /* koniec elementów pokazywanych tylko na g³ównej stronie */
    ?>
    <tr> 
      <td align="center" valign="middle" ></td>
    </tr>
    <tr> 
      <td align="center" valign="middle">
	    <div id="footer_2">
	  	<a href="/"> 
        <?php print $lang->foot_main_page;?>
        </a>&nbsp;|&nbsp;<a href="/go/_promotion/?column=promotion"> 
        <?php print $lang->foot_promotions;?>
        </a>&nbsp;|&nbsp;<a href="/go/_promotion/?column=newcol"> 
        <?php print $lang->foot_news;?>
        </a>&nbsp;|&nbsp;<a href="/go/_files/?file=terms.html"> 
        <?php print $lang->foot_terms;?>
        </a>

	&nbsp;|&nbsp;<a href="/go/_files/?file=privacy.html">
        <?php print $lang->foot_privacy;?>
        </a>
 
        &nbsp;|&nbsp;<a href="/go/_files/?file=payments.html"> 
           <?php print $lang->foot_payments;?>
        </a>


        &nbsp;|&nbsp;<a href="/go/_files/?file=delivery.html"> 
        <?php print $lang->foot_delivery;?>
        </a>

        <?php 
        if ($config->catalog_mode==0){ 
        ?> 
        &nbsp;|&nbsp;<a href="/go/_basket/"> 
        <?php print $lang->foot_basket_state;?>
        </a>
        <?php
        }
        ?>
        &nbsp;|&nbsp;<a href="/go/_files/?file=help.html"> 
        <?php print $lang->foot_help;?>
        </a>
        &nbsp;|&nbsp;<a href="/mapa-strony">Mapa strony</a>          
        </div></td>
    </tr>
    <tr> 
      <td align="center" valign="middle"></td>
    </tr>
  </table>


<br>
<?php
           //if ($config->users_online) {
           //              include_once ("include/online.inc");
           //     print "$lang->head_users_online: ".$online->check_users_online();
              // }
?>

	  <?php if (!$_COOKIE['privacy_ok']): ?>
	  <div id="cookie-law-info-bar" class="center-text" style="display: block; background-color: rgb(238, 241, 244); border-top-width: 4px; border-top-style: solid; border-top-color: rgb(68, 68, 68)">
    <span><?php print $lang->cookie1 ?>
	  <br><?php print $lang->cookie2 ?>
	  <a href="/go/_info/cookie.php" style="color: rgb(255, 255, 255); background-color: rgb(0, 0, 0);"><?php print $lang->cookie3; ?></a><br/><a href="/go/_files/?file=privacy.html"><?php print $lang->foot_privacy;?></a>
	  </span>
	  </div>
	<?php endif ?>

</center>

<?php
error_reporting(0);
$crawlturl =urlencode($_SERVER['REQUEST_URI']);
$crawltagent =urlencode($_SERVER['HTTP_USER_AGENT']);
if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
{
$crawltip = urlencode($_SERVER['HTTP_X_FORWARDED_FOR']);
}
elseif(isset($_SERVER['HTTP_CLIENT_IP']))
{
$crawltip = urlencode($_SERVER['HTTP_CLIENT_IP']);
}
else
{
$crawltip = urlencode($_SERVER['REMOTE_ADDR']);
}
$crawltreferer=urlencode($_SERVER['HTTP_REFERER']);
$crawltvariablescodees = "url=".$crawlturl."&agent=".$crawltagent."&ip=".$crawltip."&referer=".$crawltreferer."&site=1";
$url_crawlt2=parse_url("http://www.spiders.mikran.pl/crawltrack.php");
$crawlthote=$url_crawlt2['host'];
$crawltscript=$url_crawlt2['path'];
$crawltentete = "POST ".$crawltscript." HTTP/1.1\r\n";
$crawltentete .= "Host: ".$crawlthote." \r\n";
$crawltentete .= "Content-Type: application/x-www-form-urlencoded\r\n";
$crawltentete .= "Content-Length: " . strlen($crawltvariablescodees) . "\r\n";
$crawltentete .= "Connection: close\r\n\r\n";
$crawltentete .= $crawltvariablescodees . "\r\n";
$crawltsocket = fsockopen($url_crawlt2['host'], 80, $errno, $errstr);
if($crawltsocket)
{
fputs($crawltsocket, $crawltentete);
fclose($crawltsocket);
}
?>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1222712-1";
urchinTracker();
</script>
<!---
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script src="http://connect.facebook.net/pl_PL/all.js#xfbml=1"></script>
--->
</body>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<?php 
   //$jsp = "/themes/base/$config->base_theme/_common/javascript/facebook_slider.js";
   //echo "<script language=\"javascript\" src=\"$jsp\" type=\"text/javascript\"></script>\n";
?>
<link rel="stylesheet" href="/themes/base/base_theme/_style/facebook_slider.css?version=1" type="text/css">

<!---
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1&appId=257729355793";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

--->

<!---
<div id="wysuwane"> 
<div id="wewnatrz" style="float:left;width:150px; display:block; margin-left:0px;">
<div class="fb_mikran">
<div class="fb-like-box" style="background-color:white" data-href="http://www.facebook.com/mikranpl" data-width="190" data-height="350" data-show-faces="true" data-stream="false" data-header="true"></div>
<a href="http:://www.mikran.pl">(c) <?php echo date('Y') ?> http://www.mikran.pl</a>
</div>
</div>
</div>
--->

</html>
