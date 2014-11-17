<?php
/**
* Nag³ówek strony dla Google.
* 
* @author  m@sote.pl
* @version    $Id: head.html.php,v 1.1 2005/08/08 14:16:04 maroslaw Exp $
* @package    themes
* @subpackage google
*/

/**
* Konfiguracja google.
*/
global $google_config,$google;
require_once ("config/auto_config/google_config.inc.php");

global $__class;
$__class=trim(ereg_replace(" ","_",$google_config->keyword_plain));        

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php print $google->title();?></title>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?php print $config->encoding;?>">
<meta NAME="keywords" CONTENT="<?php print $google->keywords();?>">
<meta NAME="resource-type" CONTENT="document">
<meta NAME="distribution" CONTENT="global">
<meta NAME="generator" CONTENT="SOTEeSKLEP v3.1">
<meta NAME="description"  CONTENT="<?php print $google->description();?>">
<?php
$css_file="/themes/base/google/_style/".$google_config->keyword_plain.".css";
if (file_exists($DOCUMENT_ROOT.$css_file)) {
    print "<link rel=\"stylesheet\" href=\"$css_file\">\n";
}
?>
</head>

<body>

<?php print $google_config->sentences[0]."\n";?><br />

<table>
<tr>
<td width="50%">  
  <img src="/themes/base/google/_img/prev_g.png" alt="previous" border="0">
  <a href="/html/index.html"><img src="/themes/base/google/_img/next.png" alt="next" border="0"></a>
  <a href="/"><img src="/themes/base/google/_img/contents.png" alt="contents" border="0"></a>
</td>
<td width="50%">
  <?php
  if (! empty($google_config->logo)) {
      print "<a href=\"http://$config->www\"><img src=\"/themes/base/google/_img/$google_config->logo\" title=\"".$google_config->keywords[0]."\" alt=\"".$google_config->keywords[0]."\" border=\"0\"></a>\n";      
  }
  ?>
</td>
</tr>
</table>
