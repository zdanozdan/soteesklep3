<?php
/**
* @version    $Id: head.html.php,v 1.2 2005/08/10 09:52:36 krzys Exp $
* @package    themes
* @subpackage print
* \@lang
* \@encoding
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php print @$config->google['title'];?></title>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?php print $config->encoding;?>">
<meta NAME="Keywords" CONTENT="<?php print @$config->google['keywords'];?>">
<meta NAME="Description"  CONTENT="<?php print @$config->google['description'];?>">
<link rel="stylesheet" href="/themes/base/base_theme/_style/style.css" type="text/css">
<style type="text/css">
<?php $this->theme_file("_common/style/style.css");?>
</style>
<script>
<?php $this->theme_file("_common/javascript/script.js");?>
</script>
</head>
<body onload="window.print()">
