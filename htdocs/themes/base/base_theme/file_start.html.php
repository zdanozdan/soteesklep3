<?php
/**
* Kod HTML wyswietlany na poczatku pliku (pliki z edycji tekstów).
*
* @author  rp@sote.pl krzys@sote.pl
* @version $Id: file_start.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<?php 
global $lang;
$key_file=ereg_replace(".html","",$_REQUEST['file']);
$this->bar($lang->bar_title[$key_file]); 
?>
<div class="block_2">

