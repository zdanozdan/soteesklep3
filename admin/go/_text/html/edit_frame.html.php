<?php
/**
* @version    $Id: edit_frame.html.php,v 2.6 2004/12/20 17:59:06 maroslaw Exp $
* @package    text
*/
global $config;
// sprawdzaj tylko dla edycji textow, a nie dla edycji plikow devel
if (($config->devel!=1) && (! empty($filedev))) {
?>
<FRAMESET cols="50%,50%">
  <FRAME src="<?php print $config->url_prefix;?>/go/_text/edit_text.php?file=<?php print @$file;?>&file_name=<?php print @$file_name;?>&lang_name=<?php print $lang_name;?>" name=edit>
  <FRAME src="<?php print $config->url_prefix;?>/go/_text/edit_preview.php?file=<?php print @$file;?>&lang_name=<?php print @$lang_name;?>" name=preview>

    
<?php
      } else {
?>    
<FRAMESET cols="99%,1%">
  <FRAME src="<?php print $config->url_prefix;?>/go/_text/edit_text.php?filedev=<?php print @$filedev;?>" name=edit>
  <FRAME src="<?php print $config->url_prefix;?>/go/_text/edit_preview.php?fileddev=<?php print @$filedev;?>" name=preview>

<?php
      }
?>

</FRAMESET>
