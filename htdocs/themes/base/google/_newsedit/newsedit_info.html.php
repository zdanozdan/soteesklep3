<?php
/**
* Informacja szczegó³owa newsa.
* 
* @author  m@sote.pl
* @version    $Id: newsedit_info.html.php,v 1.1 2005/08/08 14:21:44 maroslaw Exp $
* @package    themes
* @subpackage google
*/
global $theme;$config;
?>

<div align="left">
<b><?php print @$rec->data['subject'];?></b><br />
<font style="font-size: 10px;">(<?php print @$rec->data['date_add'];?>)</font>
<p>
<?php 
@include_once ("news.html");
print @$rec->data['description'];
?>
</p>

<?php
global $DOCUMENT_ROOT;
for ($i=1;$i<=8;$i++) {
    $id=$rec->data['id'];
    if (! empty($rec->data["photo$i"])) {
        $photo=$rec->data["photo$i"];
        if (file_exists("$DOCUMENT_ROOT/plugins/_newsedit/news/$id/$photo")) {
            print "<img src=/plugins/_newsedit/news/$id/$photo border=$theme->img_border><p>";
        }
    }
} // end for
?>
</div>