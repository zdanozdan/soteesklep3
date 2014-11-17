<?php
/**
 * Zmien wyglad strony na jeden z dostepnych tematow.
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.3 2005/01/20 14:59:40 maroslaw Exp $
 * @packahe soteesklep
* @package    themes
 */

$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

if (! empty($_REQUEST['theme'])) {
    // nazwa nowego tematu
    $theme_name=$_REQUEST['theme'];
    if (! empty($config->admin_themes[$theme_name])) {
        // wskazany temat istnieje, zapisz jego nazwe w sesji
        $global_theme=&$theme_name;
        $sess->register("global_theme",$global_theme);
    } else {
        $theme->go2main();
        exit;
    }
} else {
    $theme->go2main();
    exit;
}
?>

<html>
<head>
<META HTTP-EQUIV="refresh" content="0; url=<?php print $config->url_prefix;?>/index.php/?sess_id=<?php print $sess->id;?>">
</head>
<html>

<?php
include_once ("include/foot.inc");
?>
