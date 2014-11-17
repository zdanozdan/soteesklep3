<?php
/**
 * Dodaj nowa pozycje do wskazanej tabeli 
 * 
 * @author  m@sote.pl
 * @version $Id: mod_table.inc.php,v 2.2 2004/12/20 17:59:23 maroslaw Exp $
* @package    admin_include
 */

require_once ("include/form_check.inc");
@include_once ("./include/form_check_functions.inc.php");  // odczytaj lokalne definicje funkcji sprawdzajacych poprawnosc pol 


class ModTable {
    var $data=array();                    // tablica parametrow przekazanych z formularza HTML
    var $action_add="add.php";            // action w formularzu - dodanie rekordu
    var $item="item";                     // nazwa talicy formularza HTML w ktorej sa gromadzone dane z formularza
    var $update_item="update";            // nazwa pola okreslajacego czy dany formularz zostal wyywolany przez "swoj" sumit
    var $action_edit="edit.php";          // action w formularzu - aktualizacja rekordu; po dodaniu rekordu system automatycznie
                                          // wywoluje formularz aktualizacji rekordu
    var $secure_test=true;                // zabezpieczenie przed nieporzadanym wywolaniem insert.inc.php
    
    /* Konstruktor */
    function ModTable(){}

    /**
     * Odczytaj parametry z formularza
     */
    function get_params() {
        global $_POST;

        if (! empty($_POST[$this->item])) {
            $this->data=$_POST[$this->item];
        }
        return;
    } // end get_params()

    /**
     * Odczytaj id rekordu
     *
     * \@global int $this->id id edytowanego rekordu
     */
    function get_id () {
        global $_REQUEST,$_POST,$_GET;

        // odczytaj id rekordu
        if (! empty($_REQUEST['id'])) {
            $id=$_REQUEST['id'];
        } elseif (! empty($_POST['id'])) {
            $id=$_POST['id'];
        } elseif (! empty($_GET['id'])) {
            $id=$_GET['id'];
        }
        
        if (! empty($id)) {
            $this->id=$id;
            return;
        }
    } // end get_id()
    
    /**
     * Odczytaj dane rekordu i zapamietaj je w $this->data
     * 
     * @param string $table
     * \@global array $this->data
     */ 
    function get_record_attr($table) {
        require ("./include/select.inc.php");
        return;
    } // end get_record_attr

    /**
     * Sprawdz czy zostala wywolana akcja submi w formularzu
     */
    function check_submit() {
        global $_POST;

        if (! empty($_POST[$this->update_item])) {
            $this->update=true;
            return;
        } else {
            $this->update=false;
            return;
        }
    } // end check_sumit()

    /**
     * Dodaj rekord 
     *
     * @public
     */
    function add($table,$name="data",$form_check_funs=array(),$form_errors=array()) {
        $this->set_record("add",$table,$name,$form_check_funs,$form_errors);
        return;
    }

    /**
     * Aktualizuj rekord
     * 
     * @public
     */
    function update($table,$name="data",$form_check_funs=array(),$form_errors=array()) {
        $this->set_record("update",$table,$name,$form_check_funs,$form_errors);
        return;
    }

    /**
     * Sprawdz formularz i dodaj rekord do bazy
     *
     * @param string $table nazwa tabeli 
     * @param string $name nazwa modulu, wg tej nawzy odczytywane sa np. pliki html np $nazwa_edit.html.php itp.
     * @param array  $form_check_funs pola formularza=>funkcje sprawdzajace poprawnosc pola np.
     *                                array("name"=>string,"price"=>"int") itp.
     * @param array $form_errors tablica z bledami przyporzdkowanymi poszczegolnym polom formularza, bledy pokazuje sie
     *                           jesli dane pole jest zle wypelnione
     */
    function set_record($method="add",$table,$name="data",$form_check_funs=array(),$form_errors=array()) {
        global $config;
        global $lang;
        global $theme;


        $this->get_params();                   // odczytaj dane z formularza
        $this->check_submit();                 // sprawdz czy wywolano submit sprawdzanego formularza
        if ($method=="update") {         
            $this->get_id();                   // odczytaj ID
        }
        
        // ustaw odpowiednia action dla formularza
        switch ($method) {
        case "add":
            $action=$this->action_add;
        break;
        case "update":
            $action=$this->action_edit;            
        break;
        } 

        if ($this->update==false) {
            // odczytaj atrybuty recordu z bazy
            if ($method=="update") {   
                $this->get_record_attr($table);    // odczytaj atrybuty z bazy
            }
            $rec->data=$this->data;
            if (! empty($name)) {
                include_once("./html/".$name."_edit.html.php");
            } else {
                include_once("./html/edit.html.php");
            }
        } else {
            // dodaj nowy rekord            
            if (class_exists("FormCheckFunctions")) {
                // utworz oiekt z nadklasy uwzgledniajacej lokalne definicje funkcji klasy FormCheck
                $form_check = new FormCheckFunctions;
            } else {
                $form_check = new FormCheck;
            }

            $theme->form_check=&$form_check;

            // przyporzadkuj odpowiednim polom odpowiednie komunikaty o bledach
            while (list($field,$fun_name) = each($form_check_funs)) {                
                $form_check->fun[$field]=$fun_name;
            }

            $form_check->form=$this->data;
            $form_check->errors=$form_errors;
            $form_check->check=true;
            
            $rec->data=$this->data;
            
            if ($form_check->form_test()) {
                // poprawnie wypelniony formularz

                // przekaz parametry z formularza do tablicy $rec->data
                $rec->data=$this->data;

                switch ($method) {
                case "add":
                    include_once("./include/insert.inc.php");                       
                    if (method_exists($theme,"status_bar")) {                        
                        if (! empty($insert_info)) $__insert_info=&$insert_info;
                        if (! empty($__insert_info)) {
                            $theme->status_bar($__insert_info);    
                        }
                    }
                    break;
                case "update":
                    include_once("./include/update.inc.php");            
                    if (method_exists($theme,"status_bar")) {  
                        if (! empty($update_info)) $__update_info=&$update_info;
                        if (! empty($__update_info)) {
                            $theme->status_bar($__update_info);
                        }
                    }                    
                    break;
                }

                $action=$this->action_edit;
                // wyswietl formularz z poprawnymi danymi  
                $rec->data=$this->data;
                if (! empty($name)) {
                    include_once("./html/".$name."_edit.html.php");
                } else {
                    include_once("./html/edit.html.php");
                }
                // exit;
            } else {                  
                // wyswietl formularz z poprawnymi danymi
                //$action=$this->action_edit;
                $rec->data=$this->data;
                if (! empty($name)) {                    
                    include_once("./html/".$name."_edit.html.php");
                } else {                    
                    include_once("./html/edit.html.php");
                }                
            } // end if      
        } // end if (update==false)
    } // end add_record()

} // end class ModifyTable

/*
// Przyklady 

// -------------------------------------
// przyklad 1  dodanie rekordu do tabeli test_table
require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

$funs=array("id"=>"string",
            "name"=>"string");

$errors=$lang->test_errors; // Odpowiednik np. $errors=array("id"=>"Brak ID","name"=>"Brak nazwy");
$mod_table->add("test_table","test",$funs,$errors);


// -------------------------------------
// przyklad 2 dodanie rekordu do tabeli currency (z pluginu currency soteesklep2/admin/plugins/_currency/add.php)
require_once("include/mod_table.inc.php");
$mod_table = new ModTable;
$mod_table->add("currency","currency",array("currency_name"=>"string",
                                            "currency_val"=>"string"),
                $lang->currency_form_errors
                );


// -------------------------------------
// przyklad 3 aktualizacja rekordu z tabeli test_table
require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

$funs=array("id"=>"string",
            "name"=>"string");

$errors=$lang->test_errors; // Odpowiednik np. $errors=array("id"=>"Brak ID","name"=>"Brak nazwy");
$mod_table->update("test_table","test",$funs,$errors);



// -------------------------------------
// przyklad 4 aktualizacja rekordu tabeli currency
require_once("include/mod_table.inc.php");
$mod_table = new ModTable;
$mod_table->update("currency","currency",array("currency_name"=>"string",
                                               "currency_val"=>"string"),
                    $lang->currency_form_errors
                   );


// UWAGI
// Pola w formularzu musza byc wstawiane w tablicy item np. <input type=text nameitem[id]>
// W formularzu nalezy umiescic pole <input type=hidden name=update value=true> oraz
// pole                              <input type=hidden name=id value=12> gdzie 12 to ID dodanego rekordu
// Plik dodania rekordu powinin nazywac sie add.php
// Plik edycji rekordu jw. edit.php
// Dane sa przesylane jako POST
// Skrypt zawierajacy instrukcje dodania rekodu znajduje sie w ./include/insert.inc.php

*/

?>
