<?php
/**
 * Odczytaj PIN i udostepnij go globalnie. Zapamietaj PIN w sesji, jesli zostal wprowadzony z formularza (1 wywolanie).
 *
 * \@global string $__pin 
 *
 * @author  m@sote.pl
 * @version $Id: pin.inc.php,v 2.2 2004/12/20 17:59:24 maroslaw Exp $
* @package    admin_include
 */

if (! empty($_SESSION['__pin'])) {
    $__pin=$_SESSION['__pin'];
}


?>
