<?php
/** 
 * Klasa analizujaca dane wprowadzone przez klienta przez WWW 
 * Funkcje tej klasy sluza do zabezpieczenia kodu HTML przed uzywaniem niedozwolonych kodow PHP
 *
 * @author  m@sote.pl
 * @version $Id: parse_php.inc.php,v 2.3 2004/12/20 17:59:08 maroslaw Exp $
* @package    text
 */ 

if  (@$__secure_test!=true) die ("Forbidden parse_php.inc.php");

class SecureParsePHP {

    /**
     * Usun znaczniki PHP 
     *
     * @param  string $data dane, ktore moga zawierac kod PHP
     * @return string $data bez PHP
     *
     * @public
     */
    function clean($data) {
        $data=eregi_replace("\<\?php","",$data);
        //$data=eregi_replace("php","",$data);
        $data=ereg_replace("\<\?","",$data);
        $data=ereg_replace("\?\>","",$data);
        return $data;
    } // end clean()


} // end SecureParsePHP

?>
