<?php
/**
 * Happy hour - klasa odpowiedzialna za sprawdzenie czy dana grupa rabatowa ma byc aktywna w systemie w okreslonym czasie
 *
 * @author  p@sote.pl
 * @version $Id: happy_hour.inc,v 2.13 2006/06/29 10:15:35 lukasz Exp $
* @package    include
 */

class HappyHour {

    /*
    * Konstruktor obiektu
    *
    */
    function HappyHour () {
        global $_SESSION;
        global $sess;
        global $my_group;
        global $__id_discounts_groups;
        global $__user_discount;

        // sprawdzaj czy jest happy hour pod warunkiem ze 
        // uzytkownik nie ma juz przypisanej grupy rabatowej
        // I
        // uzytkownik nie zalogowal/wylogowal sie przed chwila
        // LUB
        // uzytkownik ma przypisane happy hour, i trzeba sprawdzic czy juz sie nie skonczylo
        if (((empty($_SESSION['my_group']['id'])) && (! ereg("users",$_SERVER['SCRIPT_NAME']))) || (!empty($_SESSION['my_group']['start_time']))) {
            // sprawdz czy istnieje grupa spelniajaca ramy czasowe
            $my_group=$this->check_discounts_group();
            // zarejestruj w sesji zwrocona informacje
            $sess->register("my_group",$my_group);
        }

        // spelnia ramy czasowe
        if (! empty($_SESSION['my_group'])) {
        	$start_time=@$_SESSION['my_group']['start_time'];
            $end_time=@$_SESSION['my_group']['end_time'];
            if ((@$_SESSION['my_group']!=-1) && (@$_SESSION['my_group']!=-2)) {
                $__id_discounts_groups=$_SESSION['my_group']['id'];

                // jesli nie ma identyfikatora w sesji to zarejestruj w sesji identyfikator grupy
                if (empty($_SESSION['__id_discounts_groups'])) {
                    $sess->register("__id_discounts_groups",$__id_discounts_groups);
                }

                // zarejestruj domyslny rabat w sesji (emulacja zmiennej $__user_discount)
                if (empty($_SESSION['__user_discount'])) {
                    global $discounts_config;

                    $__user_discount=$discounts_config->default_discounts[$__id_discounts_groups];
                    $sess->register("__user_discount",$__user_discount);
                    // prze³adowujemy zawarto¶æ koszyka
                    global $shop;
					$shop->basket();
					$shop->basket->reload();
                }

                // sprawdz czy promocja ma jeszcze trwac
                $check=$this->check_time($start_time,$end_time);

            } elseif (@$_SESSION['my_group']==-2) {
                // wyrejestruj zmienne z sesji jesli czas promocji dobiegl konca
                if (! $this->check_time($start_time,$end_time)) {
                    $sess->unregister("my_group");
                    $sess->unregister("__id_discounts_groups");
                    $sess->unregister("__user_discount");
                    // prze³adowujemy zawartosæ koszyka
					global $shop;
					$shop->basket();
					$shop->basket->reload();
                }
            }
            // prze³adowujemy zawarto¶æ koszyka ¿eby zaktualizowaæ ceny je¿eli w³a¶nie zacze³a lub skoñczy³a siê happy hour
        }

    } //end konstruktor

    /**
     * Sprawdz czy jakas grupa rabatowa ma zdefiniowana date poczatkowa i koncowa promocji
     * 
     * \@modified_by m@sote.pl 2003-10-18: 19:46 dodanie sprawdzania istnienia definicji czasu promocji dla grupy rabatowej 
     * @return -1 - brak plikow konfiguracyjnych lub brak definicji czasu promocji dla grupy rabatowej
     * @return -2 - jest definicja nie spelnia ram czasowych
     *
     */
    function check_discounts_group() {
        global $discounts_config;
        global $DOCUMENT_ROOT;
        global $config;
        $my_date_time=date("Y-m-d;H:i");  // pobranie daty i godziny w odpowiednim formacie

        // sprawdzam czy istnieje w pliku konfiguracyjnym uzytkownika zmienna happy_hour
        if (! empty($config->happy_hour)) {
            $happy_hour_file_id=$config->happy_hour;
        } else return -1;

        // sprawdzam czy istnieje plik konfiguracyjny o takim id
        if (!$shop->home) {
	        $file="$DOCUMENT_ROOT/../config/auto_config/discounts/".$happy_hour_file_id."_discounts_config.inc.php";
        } else {
        	$file="/base/config/auto_config/discounts/".$happy_hour_file_id."_discounts_config.inc.php";
        }
        if (file_exists($file)) {
            include_once($file);
        } else return -1;

        // brak definicji czasu promocji dla grupy rabatowej (nie ma takich tablic w pliku)
        if (empty($discounts_config->discounts_start_date) || empty($discounts_config->discounts_end_date)) {
            return -1;
        }

        // odczytaj date poczatku promocji
        foreach ($discounts_config->discounts_start_date as $key=>$value) {
            if ($value!=0) {
                $start_time=$value;         // poczatek happy hour
                $check_start_date=0;        // czy data poczatkowa miesci sie w ramach czasowych

                // sprawdzam czy data poczatku promocji jest wieksza od aktualnej
                if ($my_date_time>=$start_time) {
                    $check_start_date=1;
                    $my_start_time=$value;            // poczatek promocji
                    $id_discounts_group_start=$key;   // identyfikator grupy rabatowej
                }
            }
        }

        if (empty($id_discounts_group_start)) return -1;
        
        // odczytaj date konca promocji
        foreach ($discounts_config->discounts_end_date as $key=>$value) {
            if ($value!=0) {
                $end_time=$value;           // koniec happy hour
                $check_end_date=0;          // czy data koncowa miesci sie w ramach czasowych

                // sprawdzam czy data konca promocji jest mniejsza od aktualnej
                if ($my_date_time<=$end_time) {
                    $check_end_date=1;
                    $my_end_time=$value;            // koniec promocji
                    $id_discounts_group_end=$key;   // identyfikator grupy rabatowej
                }
            }
        }

        // jesli zdefiniowana grupa rabatowa miesci sie w ramach czasowych zwroc strukture (id grupy, poczatek i koniec promocji)
        if ((@$id_discounts_group_start==@$id_discounts_group_end)) {

            // tworze strukture danych
            $discounts_group_data=array("id"=>$id_discounts_group_start,
            "start_time"=>$my_start_time,
            "end_time"=>$my_end_time);
            return $discounts_group_data ;   // definicja istnieje, spelnia ramy czasowe

        } else return -2;

        return -1;

    } // end check_discounts_group()

    /*
    * Sprawdz czy grupa miesci sie w przedziale czasowym
    *
    * @param $start_time - poczatkowa promocji wraz z godzina w formacie (np. 2003-10-07;11:55)
    * @param $end_time - koncowa data promocji wraz z godzina w formacie (np. 2003-10-07;15:55)
    * @return boolean true  - grupa miesci sie w przedziale czasowym
    * @return boolean false - grupa nie miesci sie w przedziale czasowym
    */
    function check_time($start_time, $end_time) {
        $my_date_time=date("Y-m-d;H:i");         // pobranie daty i godziny w odpowiednim formacie

        if (($my_date_time>=$start_time) && ($my_date_time<=$end_time)) {
            return true;
        }

        return false;

    } // end check_time

} // end class HappyHour

?>
