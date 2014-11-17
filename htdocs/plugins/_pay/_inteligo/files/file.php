<?php
/**
 * Przejscie na strone aytoryzacji Inteligo
 *
 * @author m@sote.pl
 * @version $Id: file.php,v 1.5 2005/01/20 15:00:30 maroslaw Exp $
* @package    pay
* @subpackage inteligo
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
include("./include/files.inc.php");
@include_once ("config/auto_config/config_inteligo.inc.php");

$theme->head();

if (in_array("inteligo",$config->plugins)) {
    $inteligo=new InteligoFile;
    $inteligo->InteligoUploadAction();
}

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
