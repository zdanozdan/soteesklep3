<?php
/**
* Kod HTML wyswietlany na ko�cu wy�wietlanego pliku  (pliki z edycji tekst�w).
*
* @author  rp@sote.pl
* @version $Id: file_end.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
* @package htdocs_theme
* @subpackage file
*/
?>
<br/>
<br/>
<hr/>
<?php 
global $_REQUEST;
$this->print_page("/go/_files/print.php?file=".$_REQUEST['file']);?>
</div>

