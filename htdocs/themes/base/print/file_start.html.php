<?php
/**
* Kod HTML wyswietlany na poczatku pliku (pliki z edycji tekstów).
*
* @author  rp@sote.pl krzys@sote.pl
* @version $Id: file_start.html.php,v 1.2 2005/08/11 08:16:01 krzys Exp $
* @package    themes
* @subpackage base_theme
*/
?>

<?php 
global $lang;
$key_file=ereg_replace(".html","",$_REQUEST['file']);
?>

<TABLE BORDER=0 align="left" cellpadding="5" cellspacing="0">
<TR>
    <TD style="text-align:justify">
    <?php 
    print "http://".$_SERVER['HTTP_HOST'];
    print " - ".$lang->bar_title[$key_file];
    ?>
    <BR><BR>
    
   
