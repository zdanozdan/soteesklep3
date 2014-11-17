<?php
/**
* Zapisz liczbe puktow wprowadzonych przez uzykownika (za kazde 100 PLN)
* Dane zapisz w pliku konfiguracyjnym uzytwkonika config/auto_config/user_config.inc.php
*
* @author  m@sote.pl
* @version $Id: update_points.inc.php,v 2.4 2005/06/14 07:13:27 lechu Exp $
* @package    order
*/

/**
* Obsluga generowania pliku konfiguracyjnego uzytkwonika
*/
require_once("include/gen_user_config.inc.php");

if (isset($_POST['form']['points'])) {
    $order_points=$_POST['form']['points'];
    $config->order_points=$order_points;
} else {
    exit;
}

// generuj plik konfiguracyjny
$gen_config->gen(array("order_points"=>$order_points));

?>
