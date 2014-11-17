<?php
/**
* Obs³uga systemu multi-shop.
*
* @author  m@sote.pl
* @version $Id: multi_shop.inc.php,v 2.1 2005/01/27 13:51:44 maroslaw Exp $
* @package setup
* @subpackage multi_shop
*/

/**
* Dodaj obsluge MetabaseData
*/
require_once ("MetabaseData/MetabaseData.php");
$mdbd =& new MetabaseData($db);

/**
* Klasa obs³ugi systemu multi_shop
* @package setup
* @subpackage multi_shop
*/
class Setup_MultiShop {


    // {{{ Setup_MultiShop()

    /**
    * Konstruktor
    */
    function Setup_MultiShop($license='') {
    }
    
    // }}}

    // {{ setID()
    
    /**
    * Zapisz ID sklepu do bazy i oczytaj dodane ID. Sprawd¼, czy sklep nie jest ju¿ wpisany w tabeli shop.
    *
    * @param string $license numer licencji instalowanego sklepu
    * @return int id sklepu w tabeli shop
    */
    function setID($license='') {
        global $mdbd,$db;

        if (empty($license)) return (0);

        $id=$mdbd->select("id","shop",1,array(),"LIMIT 1");
        if ($id>0) {
            // jest conajmniej jeden sklep zainstalowany na danej bazie danych
            $mode="slave";
        } else {
            $mode="master";
        }


        // sprawdzamy czy dany sklep jest ju¿ w tabeli shop
        $my_id=$mdbd->select("id","shop","license=?",array($license=>"text"),"LIMIT 1");
        if ($my_id>0) {
            return $my_id;
        } else {
            $mdbd->insert("shop","license,mode,active","?,?,1",
            array(
            "1,".$license=>"text",
            "2,".$mode=>"text",
            ));

            $query="SELECT max(id) AS max_id FROM shop LIMIT 1";
            $result=$db->query($query);
            if ($result!=0) {
                $num_rows=$db->numberOfRows($result);
                if ($num_rows>0) {
                    return $db->fetchResult($result,0,"max_id");
                } else return (0);
            } else die ($db->error());

        }

        return (0);
    } // end Setup_MultiShop()

    // }}}

} // end class SetupMultiShop

?>