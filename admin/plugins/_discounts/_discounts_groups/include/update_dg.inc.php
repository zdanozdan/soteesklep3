<?php
/**
 * Funkcje zwiazane z aktualizacja grup rabatowych (przyporzadkowanie klientow do danej grupy) w zaleznosci od obrotow klientow
 * 
 * @author p@sote.pl
 * @version $Id: update_dg.inc.php,v 1.8 2004/12/20 17:59:44 maroslaw Exp $
* @package    discounts
* @subpackage discounts_groups
 */

if (@$global_secure_test!=true) die ("Bledne wywolanie");

require_once ("include/metabase.inc");

class UpdateDG {
    
    var $users_array=array();
    var $groups_array=array();
    var $users_groups=array();
    
    /**
     * Konstruktor klasy UpdateDG 
     * 
     */
    function UpdateDG () {
            
        $this->users();           // utworz tablice z danymi uzytkownikow postaci $array=array("id_user"=>"discounts_groups")
        $this->groups();          // utworz tablice z danymi grup postaci $array=array("group_id"=>"$group_amount;$calculate_period")
        //print "<pre>";
        //print_r($this);
        //print "</pre>";
        $this->compute();         // oblicz obroty klientow w danym okresie rozliczeniowym
        $this->update_users();    // przyporzadkuj klientow do sugerowanych grup rabatowych (aktualizuj tabele users)
    }
    
    /**
     * Funkcja wyci±gaj±ca z bazy u¿ytkownikow wraz z identyfikatorami grupy rabatowej do ktorej naleza
     * Tworzy tablice uzytkownikow wraz z grupa rabatowa do ktorej naleza
     * Bierze pod uwage tylko tych uzytkownikow, gdzie lock_user!=1 (nie ma ustawionej blokady automatycznego przenoszenia uzytkownikow 
     * do gruo rabatowych)
     * 
     */
    function users() {
        global $db;
        
        $query="SELECT id, id_discounts_groups FROM users WHERE lock_user!=1";
        
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    for ($i=0;$i<$num_rows;$i++) {
                        $id_user=$db->FetchResult($result,$i,"id");
                        $id_discounts_groups=$db->FetchResult($result,$i,"id_discounts_groups");
                        if (empty($id_discounts_groups)) {
                            $id_discounts_groups=1;
                        }
                        $this->users_array[$id_user]=$id_discounts_groups;
                    } // end for
                } // end if
            } else die ($db->Error());
        } else die ($db->Error());

    } // end users()
    
    
    /**
     * Funkcja wyci±gaj±ca z bazy identyfikatory grup rabatowych wraz z danymi: group_amount + calculate_period
     *
     */
    function groups() {
        global $db;
        
        $query="SELECT user_id, group_amount, calculate_period FROM discounts_groups WHERE calculate_period!='NULL'";
        
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    for ($i=0;$i<$num_rows;$i++) {
                        $group_id=$db->FetchResult($result,$i,"user_id");
                        $group_amount=$db->FetchResult($result,$i,"group_amount");
                        $calculate_period=$db->FetchResult($result,$i,"calculate_period");
                        $this->groups_array[$group_id]=$group_amount.";".$calculate_period;  // zapamietaj dane w tablicy groups_array
                    } // end for
                } // end if
            } else die ($db->Error());
        } else die ($db->Error());
        
    } // end groups
    
    /**
     * Funkcja sterujaca - wywolanie funkcji orders obliczajacej obroty klienta w zaleznosci od okresu obliczeniowego
     * oraz wywolujaca funkcje sprawdzajaca (check_groups) co zrobic z danym klientem w zaleznosci od jego 
     * obrotow i grupy rabatowej w ktorej obecnie sie znajduje
     *
     */
    function compute() {

        foreach($this->users_array as $key=>$value) {
            
            foreach($this->groups_array as $key1=>$value2) {
                if($value==$key1) {                                                   // jesli znajde odpowiednia grupe rabatowa
                    $id_user=$key;                                                    // przypisz identyfikator uzytkownika
                    $calculate_period=$value2;                                        // wyluskaj calculate_period dla tej grupy rabtowej
                    $calculate_period=ereg_replace("^[0-9]+;","",$calculate_period);  // wyrzuc niepotrzebne dane
                    $total_amount=$this->orders($id_user,$calculate_period);          // oblicz calkowity obrot klienta w danym czasie
                    $group_id=$key1;                                                  // przypisz identyfikator grupy
                    $check=$this->check_groups($id_user,$total_amount,$group_id);     // sprawdz co zrobic z klientem
                    $this->users_groups[$id_user]=$check;
                }
            }
        }
    }
    
    
    /**
     * Funkcja zwracajaca calkowita kwote obrotow klienta w danym okresie czasu 
     *
     * @param $id_user - identyfikator uzytkownika
     * @param $calculate_period - okres rozliczeniowy
     *
     * @return $total_amount - obroty klienta w danym okresie czasu
     */
    function orders($id_user,$calculate_period) {
        global $db;
        $actual_date=date("Y-m-d");   // pobierz aktualna date
        $total_amount=0;
        
        if ($calculate_period==1) {   // bezterminowy okres rozliczeniowy
            $query="SELECT sum(amount) FROM order_register WHERE confirm=1 AND id_user=$id_user";
        }

        if ($calculate_period==2) {   // roczny okres rozliczeniowy
            $actual_year=date("Y");
            $actual_month=date("m");
            $actual_day=date("d");
            $previous_year=$actual_year-1;
            $previous_date=$previous_year."-".$actual_month."-".$actual_day;       // oblicz date rok wczesniej

            $query="SELECT sum(amount) FROM order_register WHERE confirm=1 AND id_user=$id_user AND (date_add>='$previous_date' AND date_add<='$actual_date')";
        }
        
        if ($calculate_period==3) {   // okres rozliczeniowy od pocz±tku roku
            $actual_year=date("Y");
            $previous_date=$actual_year."-01-01";        // oblicz date poczatku roku
            
            $query="SELECT sum(amount) FROM order_register WHERE confirm=1 AND id_user=$id_user AND (date_add>='$previous_date' AND date_add<='$actual_date')";
        }

        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    for ($i=0;$i<$num_rows;$i++) {
                        $total_amount=$db->FetchResult($result,$i,"sum(amount)");
                    }   
                } 
            } else die ($db->Error());
        } else die ($db->Error());
        
        if (empty($total_amount)) {
            $total_amount=0;
        } 
        
        return $total_amount;        
        
    } // end orders
    
    
    /**
     * Funkcja zwracajaca status - co zrobic z klientem na podstawie jego obrotow i grupy rabatowej w ktorej sie znajduje 
     *
     * @param $id_user - identyfikator uzytkownika
     * @param $total_amount - calkowite obroty uzytkownika w danym okresie czasu
     * @param $group_id - identyfikator grupy do ktorej nalezy obecnie uzytkownik
     *
     * @return $check_status - zo robimy z klientem (-1) zostawiamy w aktualnej, w pozostalych przypadkach zwracamy 
     * identyfikator grupy do ktorej powinnismy przeniesc klienta 
     */
    function check_groups($id_user,$total_amount,$group_id) {
        
        $my_copy=$this->groups_array;
        $highest_group_amount=0;
        $lowest_group_amount=100000000;
        
        //print "USER=$id_user OBROTY=$total_amount GRUPA=$group_id<HR>";
        
        foreach ($this->groups_array as $key=>$value) {                // przechodzimy tablice z grupami rabatowymi
            if ($group_id==$key) {                                     // jesli znalezlismy nasza grupe 
                $group_amount=ereg_replace(";[0-9]+$","",$value);      // sprawdzamy jaki jest prog obrotu aktualnej grupy
                
                if ($total_amount>$group_amount) {                     // jest szansa ze przejde do lepszej grupy 
                    foreach ($my_copy as $my_key=>$my_value) {         // przechodzimy z nowu cala tablice z grupami
                        if ($group_id!=$my_key) {                       // interesuja nas wszystkie grupy oprocz aktualnej
                            $group_data=split(";",$my_value);          // podziel dane na osobne komorki 
                            $new_group_amount=$group_data[0];          // przypisz prog grupy
                            
                            $new_group_period=$group_data[1];          // przypisz okres rozliczeniowy
                            $my_new_group_amount=$this->orders($id_user,$new_group_period); // oblicz obroty dla tego okresu
                            
                            if (($my_new_group_amount>=$new_group_amount) && ($new_group_amount>$group_amount)
                                && ($highest_group_amount<$new_group_amount)) {
                                $highest_group_amount=$new_group_amount;
                                $suggest_group_id=$my_key;
                            }
                        }
                    }
                    
                    if(! empty($suggest_group_id)) {    // jesli istnieje sugeriowany identyfikator grupy zwroc go
                        return $suggest_group_id;
                    } else return "-1";                   // w przeciwnym razie zostaw klienta w dotychczasowej grupie
                }
                
                if ($total_amount<$group_amount) {                                          // jest szansa ze zostane zdegradowany
                    foreach ($my_copy as $my_key=>$my_value) {                              // przechodzimy z nowu cala tablice z grupami
                        if ($group_id!=$my_key) {
                            $group_data=split(";",$my_value);                               // podziel dane na osobne komorki 
                            $new_group_amount=$group_data[0];                               // przypisz prog grupy
                            $new_group_period=$group_data[1];                               // przypisz okres rozliczeniowy
                            $my_new_group_amount=$this->orders($id_user,$new_group_period); // oblicz obroty dla tego okresu
                            
                            // print "Aktualne obroty=$total_amount<BR>";
                            // print "OBROTY DLA TEJ GRUPY=$my_new_group_amount<BR>";
                            // print "WYMAGANE OBROTY DLA TEJ GRUPY=$new_group_amount<BR>";
                            
                            if (($my_new_group_amount>=$new_group_amount) && ($new_group_amount<$group_amount)) { 
                                                                
                                if ($lowest_group_amount>$new_group_amount) {
                                    $lowest_group_amount=$new_group_amount;
                                }
                                
                                if (($new_group_amount>$lowest_group_amount) && ($new_group_amount<=$my_new_group_amount)) {
                                    $lowest_group_amount=$new_group_amount;
                                    $suggest_group_id=$my_key;
                                } else $suggest_group_id=$my_key;
                                
                            }                             
                        }
                    }
                    
                    if(! empty($suggest_group_id)) {    // jesli istnieje sugeriowany identyfikator grupy zwroc go
                        return $suggest_group_id;
                    } else return "-1";                 // w przeciwnym razie zostaw klienta w dotychczasowej grupie
                }
                
                if ($total_amount==$group_amount) {               // zostaje w obecnej grupie
                    return "-1";                                 // pozostaw klienta w tej samej grupie
                }
            }
        }
        
    } // end check_groups
    
    /**
     * Funkcja aktualizaujaca tabele users korzystajac z tablicy $this->users_groups 
     *
     */
    function update_users() {
        global $db;
        global $lang;
        $i=0;
        $check=0;

        // jesli sa zdefiniowane grupy rabatowe to
        if (! empty($this->groups_array)) {
                
            foreach ($this->users_groups as $key=>$value) {
                if ($value!="-1") {
                    $query="UPDATE users SET id_discounts_groups=? WHERE id=?";
                    $prepared_query=$db->PrepareQuery($query);
                    if ($prepared_query) {
                        $db->QuerySetText($prepared_query,1,$value);
                        $db->QuerySetText($prepared_query,2,$key);
                        $result=$db->ExecuteQuery($prepared_query);
                        if ($result!=0) {
                            $check=1;
                        } else die ($db->Error());
                    } else die ($db->Error());
                } 
            }
            
            if ($check==1) {
                print "<BR>$lang->discounts_groups_update_dg<BR>";
                print "<table border=0 align=center><tr bgcolor=#d5e6ed><td>";
                print "<b>$lang->discounts_groups_user_id</b></td><td><b>$lang->discounts_groups_group_id</b></td></tr>";
                foreach($this->users_groups as $key=>$value) {
                if($value!="-1") {
                    print "<tr><td align=center>$key</td><td align=center>$value</td></tr>";
                }
                }
                print "</table>";
            } else print "<BR>$lang->discounts_groups_update_dg_no";
        } else print "<BR>$lang->discounts_no_discounts_groups";     // nie ma grup rabatowych
            
    } // end update_groups
    
} // end class UpdateDG
