<?php 
/**
* Szablon PHP prezentacji produktu w okienkach promocyjnych (nowo¶ci/promocje/itp)
*
* @author  m@sote.pl
* @version $Id: random_record.html.php,v 1.1 2005/08/08 14:16:05 maroslaw Exp $
* @package    themes
* @subpackage google
*/

global $shop;
?>

<li><a href="/html/<?php print $rec->data['id'].".html";?>">
<?php print $rec->data['name'];?>,  <?php print $rec->data['producer'];?> 
</a></li>
