<?php
/**
* @version    $Id: go2main.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
global $sess;
?>
<html>
<head>
<meta HTTP-EQUIV="refresh" content="<?php print $this->refresh_time;?>; url=<?php print $config->url_prefix;?>/index.php?<?php print $sess->param;?>=<?php print $sess->id;?>">
</head>
<html>
