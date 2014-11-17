<?php
/**
* Szablon rozszerzonej prezentacji produktu na li¶cie produktów.
* Prezentacja z opisem i pomniejszonym zdjêciem.
*
* @author  rp@sote.pl m@sote.pl lech@sote.pl krzys@sote.pl
* @version $Id: record_row.html.php,v 1.1 2005/08/08 14:16:05 maroslaw Exp $
* @package    themes
* @subpackage google
*/
?>
<div align="left">
<b><?php print $rec->data['name'];?></b>

<?php 
//wyswietlenie producenta jesli istnieje
if (!empty($rec->data['producer'])){
    print "<BR><BR>".$lang->cols['producer'].":&nbsp;".LangF::translate($rec->data['producer'])."<BR><BR>";
}
?> 
<?php print $description->short($rec->data['xml_short_description'],$rec->data['xml_description']);?>
</div>
<hr />