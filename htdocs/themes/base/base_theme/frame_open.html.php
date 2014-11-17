<?php
/**
* @version    $Id: frame_open.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<table border="0" cellspacing="0" cellpadding="0" <?php if(!empty($width)) print "width=\"$width\"";?> <?php if(!empty($align)) print "align=\"$align\"";?>>
  <tr>
    <td nowrap valign="top">
      <fieldset>
      <legend><b><?php print $title; ?></b></legend>
