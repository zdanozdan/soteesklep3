<?php
/**
 * Prezentacja listy wynikow zapytania SQL w gloenym oknie strony
 *
 * \@global  string $sql zapytanie SQL generujace elementy prezentowanych rekordow
 * \@global  string $__order_main  kolumna(y) wedlug ktorej ma byc sortowany wynik zapyatnia z tabeli main
 * \@session string $__order_main  jw.
 *
 * @author  m@sote.pl
 * @version $Id: dbedit_list.inc,v 2.26 2005/12/08 11:32:14 lechu Exp $
* @package    include
 */

// dodaj klase DBEdit
require_once ("lib/DBEdit-Metabase/DBEdit.inc");
require_once ("include/record_row.inc");
require_once ("include/image.inc");

// dostepnosc towaru (funkcja wyswietlajaca nformacje o dostepnosci)
require_once ("include/available.inc");

// wybor sortowania, funkcje
@include_once ("include/order_by_list.inc");

class DBEditList extends DBEdit {

    var $title="";              // naglowek listy wyswietlany jako "$theme->bar($title);" nad lista

    /**
     * Przedstaw liste rekordow w postaci listy DBEdit
     *
     * \@global string $sql zapytanie SQL przejkazywane do DBEdit
     * \@global object $config
     * \@global object $dbedit
     * \@global string $__order_main  kolumna(y) wedlug ktorej ma byc sortowany wynik
     *                zapyatnia z tabeli main
     * \@global bool   $__order_main_score true - wynik generowany z dopasowaniem, kolumna SCORE
     * \@global array  $_REQUEST 
     * 
     * @return none
     */
    function show() {
        global $sql;
        global $_REQUEST,$_SERVER;
        global $config;
        global $theme;
        global $dbedit;
        //global $__order_main;
        //global $__order_register;
        //global $__order_main_score;
        global $DOCUMENT_ROOT;
        global $shop;

        // obsluga sortowania dla tabeli order_register (rozwiazanie tymczasowe)
        // TODO - nalezy zaprojektowac funkcje, ktora bedzie sortowala dowolna tabele po dowolnym polu
        // parametry wejsciowe do takiej funkcji to: $table,$field
        if (eregi("from main ",$sql)) {
            // grupuj produkty wedlug user_id, nie wyswwietlaj wielokrotnie produktow jest
            // sa w roznych kategoriach (1 produkt w kilku kategoriach)
            
            
            if (! $shop->admin) {
                $q_unavailable = '';
                if ($config->depository['show_unavailable'] != 1) {
                    $q_unavailable = " AND id_available <> " . $config->depository['available_type_to_hide'];
                }
                $sql=eregi_replace("WHERE ","WHERE (",$sql);
                $sql.=") AND active=1 $q_unavailable GROUP BY user_id";
            }
        }       
        
        // ustaw tablice przypisujaca odpowiednim liczbom kolumny sortowania dla odp. tabeli
        // @dep admin/config/config.inc.php
        $dbedit->order_cols=@$config->dbedit_order_names[$dbedit->get_table_from_sql($sql)];

        if (! empty($this->title)) {
            $theme->bar($this->title,$theme->dbedit_bar_size);
        }

        // dodatkowe elementy w naglowku listy
        if ($dbedit->top_dbedit_show!=false) {
            $theme->top_dbedit();
        }

        if (! empty($_REQUEST['sql'])) {
            die ("Forbidden. Empty SQL.");
        }

        if (! is_object($dbedit)) {
            $dbedit = new DBEdit;
        }

        // ustal liczbe wynikow na stronie w zaleznosci od rodzaju prezentacji record_row
        if (empty($this->set_page_records)) {
            if ($config->record_row_type=="short") {
                $dbedit->page_records=$config->products_on_page["short"];
            } else {
                $dbedit->page_records=$config->products_on_page["long"];
            }
        } else $this->page_records=$this->set_page_records;

        if (! empty($theme->before_main_obj)) {
            $obj=$theme->before_main_obj;
            $func=$theme->before_main_func;
            $obj->$func();
        }

        $dbedit->dbtype=$config->dbtype;
        // info -> brak wynikow wyszukiwania/zapytania
        $dbedit->empty_list_file="$DOCUMENT_ROOT/themes/base/base_notheme/search_empty_query.html.php";                
        
        if (! ereg("google.php",$_SERVER['REQUEST_URI'])) {
            $dbedit->record_list($sql);
        }

        if (! empty($theme->after_main_obj)) {
            $obj=$theme->after_main_obj;
            $func=$theme->after_main_func;
            $obj->$func();
        }

        return;
    } // end show()

} // end class DBEditList
?>
