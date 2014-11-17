<?php
/**
 * Dodaj sortowanie list produktow
 *
 * \@global bool $__order_main_score true - informacja ze w liscie wynikow jest kolumna z dospasowaniem "SCORE", false wpw.
 * 
 * @author m@sote.pl
 * @version $Id: order_by_list.inc,v 1.2 2007/05/14 12:04:42 tomasz Exp $
* @package    include
 */

class OrderByList {
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
        global $__order_main;
        global $__order_main_tab;
        global $_REQUEST;
        global $sess;
        global $__order_main_score;
        global $shop,$config;
                
        // odczytaj jakie sa ustawienia sortowania obecnie
        if (! empty($_SESSION["__order_main_set"])){
            $tab=$_SESSION["__order_main_set"];
        } else {
            $tab['name']=0;
            $tab['price']=0;
            $tab['producer']=0;
            $tab['SCORE']=0;
        }        

        if (! empty($_REQUEST['order'])) {
            $order=$_REQUEST['order']; $set=false;   
            $order=intval($order);
            
            switch ($order) {
            case "1":$tab['name']=-1;     $set=true;   // zmien "strzalke" (kierunek sortowania)
                break;
            case "2":$tab['price']=-1;    $set=true;
                break;
            case "3":$tab['producer']=-1; $set=true;
                break;
            case "-1":$tab['name']=1;     $set=true;
                break;
            case "-2":$tab['price']=1;    $set=true;
                break;
            case "-3":$tab['producer']=1; $set=true;
                break;
            case "4":$tab['SCORE']=1;     $set=true;
                break;
            default:$tab[$config->main_order_default]=-1;  $set=true;
                break;
            } // end switch

            // jesli w wynikach nie ma kolumny SCORE a w wywolaniu jest zadanie sortowania wedlug tej kolumny
            // to domyslnie sortuj wedlug ceny
            if ((empty($__order_main_score))  && ($tab['SCORE']==1)) {
                $tab['SCORE']=0;
                $tab[$config->main_order_default]=-1;
            } 

        } // end if

        // start: sprawdz czy wybrano jakiekolwiek sortowanie, jesli nie to wstaw sortowanie wg ceny od najmniejszej
        // chyba ze jest to wyszukiwanie wedlug slowa, wtedy wstaw sortowanie wedlug dopasowania
        if (@$set!=true) {
            if (! empty($__order_main_score)) {
                // sortuj wedlug dopasowania
                $tab['SCORE']=1;
            } else {
                // sortuj wg ceny
                $tab[$config->main_order_default]=-1;
            }
        } 
        // end:

        // zapamietaj tablice sortowania w bazie
        $__order_main_tab=&$tab;
        $sess->register("__order_main_tab",$order_main_tab);
        $__order_main=&$order;
        $sess->register("__order_main",$__order_main);

        //$url=$_SERVER['HTTP_REFERER'];        

        $url="/go/_category/?".$_SERVER['QUERY_STRING'];
        
        // pomin sesje, uniknij duplikacji zmiennej sesji
        $url=preg_replace("/&".$sess->param."=[a-z0-9]+$/","",$url);
        $url=preg_replace("/&order=[0-9-]+/","",$url);

        
        if (strpos($url, '?') === false) { // dopilnowanie, by pierwszym oddzielaczem by³ "?", a nie "&"
            $first_amp_index = strpos('&', $url);
            if ($first_amp_index === false) { // nie ma znaku "&"
                $url .= "?1=1";
            }
            else { // zamiast pierwszego '&' wstaw '?'
                $url = substr($url, 0, $first_amp_index) . '?' . substr($url, $first_amp_index + 1);
            }
        }
        
        
        // sortowanie wg nazwy
        if ($tab['name']==1) {
            print "<a rel=\"nofollow\" href=$url&order=1><u>".$lang->order_by['name']."</u></a> ";
            print "<img src=";$theme->img("_img/up.png"); print "> ";
        } elseif ($tab['name']==-1) {
            print "<a rel=\"nofollow\" href=$url&order=-1><u>".$lang->order_by['name']."</u></a> ";
            print "<img src=";$theme->img("_img/down.png"); print "> ";
        } else {
            print "<a rel=\"nofollow\" href=$url&order=1><u>".$lang->order_by['name']."</u></a> &nbsp;";
        }

        // sortowanie wg ceny
        if ($tab['price']==1) {
            print "<a rel=\"nofollow\" href=$url&order=2><u>".$lang->order_by['price']."</u></a> ";
            print "<img src=";$theme->img("_img/up.png"); print "> ";          
        } elseif ($tab['price']==-1) {
            print "<a rel=\"nofollow\" href=$url&order=-2><u>".$lang->order_by['price']."</u></a> ";
            print "<img src=";$theme->img("_img/down.png"); print "> ";          
        } else {
            print "<a rel=\"nofollow\" href=$url&order=2><u>".$lang->order_by['price']."</u></a> &nbsp; ";
        }          

        // sortowanie wg producenta
        if ($tab['producer']==1) {
            print "<a rel=\"nofollow\" href=$url&order=3><u>".$lang->order_by['producer']."</u></a> ";
            print "<img src=";$theme->img("_img/up.png"); print "> ";
        } elseif ($tab['producer']==-1) {
            print "<a rel=\"nofollow\" href=$url&order=-3><u>".$lang->order_by['producer']."</u></a> ";
            print "<img src=";$theme->img("_img/down.png"); print "> ";
        } else {
            print "<a rel=\"nofollow\" href=$url&order=3><u>".$lang->order_by['producer']."</u></a> &nbsp;";
        }

        // sortowanie wg najlepszego dopasowania ciagu znakow, FULLTEXT SEARCH 
        if (! empty($__order_main_score)) {
            if (@$tab['SCORE']==1) {
                print "<a href=$url&order=4><u>".$lang->order_by['SCORE']."</u></a> ";
                print "<img src=";$theme->img("_img/down.png"); print "> ";
            } else {
                print "<a href=$url&order=4><u>".$lang->order_by['SCORE']."</u></a> &nbsp;";
            }
        }
        return;
    } // end show()
} // end class OrderByList

$order_by_list = new OrderByList;
?>
