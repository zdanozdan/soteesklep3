<?php
/**
* Wybierz katalog FTP, w ktorym zainstalowany jest sklep
*
* @author  m@sote.pl
* @version $Id: simple_3.php,v 2.23 2005/11/03 11:33:17 lukasz Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/

$global_database=false;
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
    $DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}
require_once ("../../include/head.inc");
// polacz sie z baza z danymi dostepu z formularza
require_once ("./include/database.inc.php");

if (! empty($_POST['ftp_dir'])) {
    $ftp_dir=$_POST['ftp_dir'];
    // zapisz w sesji dane z formularza
    $sess->register("ftp_dir",$ftp_dir);
} else die ("Forbidden: unknown ftp_dir");

if (! empty($_SESSION['config_setup'])) {
    $config_setup=$_SESSION['config_setup'];
} elseif (! empty($_POST['config_setup'])) {
    $config_setup=$_POST['config_setup'];
} else die ("Forbidden: Unknown config_setup");

if (! empty($_SESSION['form'])) {
    $form=$_SESSION['form'];
} elseif (! empty($_POST['form'])) {
    $form=$_POST['form'];
} else die ("Forbidden: Unknown form");

// naglowek
include_once ("themes/base/base_theme/head_setup.html.php");

include_once ("./html/simple_3.html.php");

print "
<table align=center><tr>
  <td valign=top>
    <img src=./html/_img/".$config_setup['os'].".gif"."
  </td>
  <td valign=top>\n";

// zaladuj baze sklepu
if (($config_setup['type']!="rebuild") && ($config_setup['type']!="upgrade")) {
    $__file=true;
    // sprawd¼ czy wywo³ano tryb multi_shop i czy jest jaki¶ sklep w tabeli shop
    $nodb=0;
    if ($config_setup['type']=="multi") {
        $db->soteSetModSQLOff();
        $query="SELECT id FROM shop WHERE mode='master'";
        $result=$db->query($query);
        if ($result!=0) {
            $num_rows=$db->numberOfRows($result);
            if ($num_rows>0) {
                $nodb=1;  
            }
        }
        $db->soteSetModSQLOn();
    }
    if (! $nodb) {     
        include_once ("./include/build_database.inc.php");
    }
} elseif ($config_setup['type']=="upgrade") {
    /* r@sote.pl */
    include_once ("./include/upgrade_database.inc.php");
    $__file=false;
    include ("./include/build_database.inc.php");
    $__file=true;
    include ("./include/build_database.inc.php");
    // end
}
print "</td><td valign=top>";

// zapisz paramery $config
require_once ("./include/save_params.inc.php");
// genruj pliki dostepu zwiazane z .htaccess itp. koncowe ustawienia konfiguracji
require_once ("./include/setup.inc.php");
// generuj klucze publiczny i prywatny jezeli jest lib do matmy
if (function_exists('bcadd')) {
	require_once("./include/gen_keys.inc.php");
}

print "<hr>";
print "<center>".$lang->setup_install_complete."</center>\n";

print "</td></tr></table>";

include_once ("themes/base/base_theme/foot_setup.html.php");

print "</form>";
// stopka
include_once ("include/foot.inc");
?>
