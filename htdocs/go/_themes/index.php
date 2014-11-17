<?php
/**
 * Zmien wyglad strony na jeden z dostepnych tematow.
* @version    $Id: index.php,v 2.4 2005/01/20 15:00:20 maroslaw Exp $
* @package    themes
 */

$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

if (! empty($_REQUEST['theme'])) {
    // nazwa nowego tematu
    $theme_name=$_REQUEST['theme'];
    if (! empty($config->themes[$theme_name])) {
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

$theme->go2main();

include_once ("include/foot.inc");
?>
