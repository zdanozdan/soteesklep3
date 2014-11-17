<?php
/**
* @version    $Id: newsedit_row.html.php,v 2.3 2004/12/20 18:02:48 maroslaw Exp $
* @package    themes
* @subpackage redball
*/
global $theme;
?>
<tr bgcolor=#ffffff>
<td>
<table cellpadding=0 cellspacing=0 border=0 width=388px bgcolor=#ffffff>
<tr> 
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
</tr>

<tr>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
<td width=398 style="padding: 4"> 

<?php
global $DOCUMENT_ROOT;

// config
$align="right";

$id=$rec->data['id'];       
if (! empty($rec->data["photo_small"])) {
    $photo=$rec->data["photo_small"];    
    if (file_exists("$DOCUMENT_ROOT/plugins/_newsedit/news/$id/$photo")) {
        print "<a href=/plugins/_newsedit/news/$id/index.php>" ;        
        print "<img src=/plugins/_newsedit/news/$id/$photo align=$align border=0>";
        print "</a>\n";
    } 
}
?>

<a href=/plugins/_newsedit/news/<?php print $id;?>/index.php><b><?php print @$rec->data['subject'];?></b> (<?php print @$rec->data['category'];?>; <?php print @$rec->data['date_add'];?>)</a> <p>

<?php print @$rec->data['short_description'];?> 
<div align=right>
<a href=/plugins/_newsedit/news/<?php print $id;?>/index.php><u>wiecej informacji</u></a>
</div>
</td>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
</tr>

<tr> 
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
<td bgcolor="#646464"><IMG src="/themes/base/redball/_layout/mask.gif" width="1" height="1"></td>
</tr>

</table>


</td>
</tr>
