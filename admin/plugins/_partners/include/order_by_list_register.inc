<?php
/**
 * Dodaj sortowanie list produktow
 *
 * \@global bool $__order_main_score true - informacja ze w liscie wynikow jest kolumna z dospasowaniem "SCORE", false wpw.
 * 
 * @author m@sote.pl
 * @version $Id: order_by_list_register.inc,v 1.2 2004/12/20 18:00:25 maroslaw Exp $
* @package    partners
 */

class OrderByListRegister {
    /**
     * Wyswietl linki sortowania 
     * Parametry GET: 1 - sortowanei wg ceny, 3 - sortowanie wg nazwy, 3 - sortowanie wg. producenta, 4 - wedlug dopasowania
     * wartosc ujemna oznacza odwrotne sortowanie
     *
     * \@global  bool  $__order_main_score true - informacja ze w liscie wynikow jest kolumna z dospasowaniem "SCORE", false wpw.
     * \@session array $__order_main_tab ustawienia sortowania
     * \@session int   $__order_main     rodzaj sortowania tabeli main
     */
    function show() {
        global $_SERVER;
        global $lang;
        global $theme;
        global $_SESSION;
        global $__order_register;
        global $__order_register_tab;
        global $_REQUEST;
        global $sess;
        
        // odczytaj jakie sa ustawienia sortowania obecnie
        if (! empty($_SESSION["__order_register_set"])){
            $tab=$_SESSION["__order_register_set"];
        } else {
            $tab['partner']=0;
            $tab['amount']=0;
            $tab['rake_off']=0;
        }

        if (! empty($_REQUEST['order'])) {
            $order=$_REQUEST['order']; $set=false;   
            $order=intval($order);
            
            switch ($order) {
            case "1":$tab['partner']=-1;     $set=true;   // zmien "strzalke" (kierunek sortowania)
                break;
            case "2":$tab['amount']=-1;    $set=true;
                break;
            case "3":$tab['rake_off']=-1; $set=true;
                break;
            case "-1":$tab['partner']=1;     $set=true;
                break;
            case "-2":$tab['amount']=1;    $set=true;
                break;
            case "-3":$tab['rake_off']=1; $set=true;
                break;
            default:$tab['partner']=-1;  $set=true;
                break;
            } // end switch
            
        } // end if

        // start: sprawdz czy wybrano jakiekolwiek sortowanie, jesli nie to wstaw sortowanie wg ceny od najmniejszej
        // chyba ze jest to wyszukiwanie wedlug slowa, wtedy wstaw sortowanie wedlug dopasowania
        if (@$set!=true) {
            $tab['partner']=-1;
        } 
        // end:

        // zapamietaj tablice sortowania w sesji
        $__order_main_tab_register=&$tab;
        $sess->register("__order_register_tab",$order_register_tab);
        $__order_main_register=&$order;
        $sess->register("__order_register",$__order_register);

        $url=$_SERVER['REQUEST_URI'];
        
        // pomin sesje, uniknij duplikacji zmiennej sesji
        $url=preg_replace("/&session_id=[a-z0-9]+$/","",$url);
        $url=ereg_replace("\?order=[0-9-]+$","",$url);
        
        // sortowanie wg nazwy
        if ($tab['partner']==1) {
            print "<a href=$url?order=1><u>".$lang->order_by['partner']."</u></a> ";
            print "<img src=";$theme->img("_img/up.png"); print "> ";
        } elseif ($tab['partner']==-1) {
            print "<a href=$url?order=-1><u>".$lang->order_by['partner']."</u></a> ";
            print "<img src=";$theme->img("_img/down.png"); print "> ";
        } else {
            print "<a href=$url?order=1><u>".$lang->order_by['partner']."</u></a> &nbsp;";
        }

        // sortowanie wg ceny
        if ($tab['amount']==1) {
            print "<a href=$url?order=2><u>".$lang->order_by['amount']."</u></a> ";
            print "<img src=";$theme->img("_img/up.png"); print "> ";          
        } elseif ($tab['amount']==-1) {
            print "<a href=$url?order=-2><u>".$lang->order_by['amount']."</u></a> ";
            print "<img src=";$theme->img("_img/down.png"); print "> ";          
        } else {
            print "<a href=$url?order=2><u>".$lang->order_by['amount']."</u></a> &nbsp; ";
        }          

        // sortowanie wg producenta
        if ($tab['rake_off']==1) {
            print "<a href=$url?order=3><u>".$lang->order_by['rake_off']."</u></a> ";
            print "<img src=";$theme->img("_img/up.png"); print "> ";
        } elseif ($tab['rake_off']==-1) {
            print "<a href=$url?order=-3><u>".$lang->order_by['rake_off']."</u></a> ";
            print "<img src=";$theme->img("_img/down.png"); print "> ";
        } else {
            print "<a href=$url?order=3><u>".$lang->order_by['rake_off']."</u></a> &nbsp;";
        }

        return;
    } // end show()
} // end class OrderByListRegister

$order_by_list_register = new OrderByListRegister;

?>
