<?php
/**
 * Funckje zwi±zane z za³±czaniem zdjêæ do zamówienia.
 *
 * @author m@sote.pl
 * @version $Id: basket_photo.inc.php,v 2.6 2006/02/09 10:28:50 maroslaw Exp $
 * @package    basket
 * @subpackage photo
 */

if (@$global_secure_test!=true) {
    die ("Bledne wywolanie");
}

/**
* Klasa zawieraj±ca funkcje zwi±zane z za³±czaniem zdjêæ do zamówienia. Lista zdjêæ, dodanie, usuniêcie itp.
*
* @package basket
* @subpackage photo
*/
class BasketPhoto {
    // dostepne typy zalacznych plikow
    var $ext_allow=array("image/jpeg","image/gif","image/tiff","image/png","image/bmp");
    // katalog gdzie beda wrzucane zalaczone zdjecia
    var $tmp_photos="go/_basket/_photo/tmp_photos";
    var $local_tmp_photos="tmp_photos";
    var $form_order_description='';        // opis zamowienia, generoewany z poszczego;lnych pol przy produktach

    function form_list() {
        global $my_basket;
        global $lang;

        $this->info_calc();

        print "<form action=\"index.php\" method=\"post\" name=\"photoForm\" enctype=\"multipart/form-data\">\n";
        print "<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";

        reset($my_basket->items);
        foreach ($my_basket->items as $this->item) {
            $this->_row();
        }

        print "</table>\n";
        print "</form>\n";

        return;
    } // end formlist()

    /**
     * Wy¶wietl wiersz dotycz±cy za³±czania zdjêcia do danego produktu.
     * 
     * global string $form_order_description opis zamowienia (zbiorczy)
     * 
     * @access private
     */
    function _row() {
        global $my_basket;
        global $lang;
        global $global_basket_photo_description;

        $user_id=$this->item['user_id'];

        print "  <tr>\n";
        print "    <td align=\"left\">";
        print $this->item['name']." ";
        print $this->info($user_id);
        print "</td>";
        print "    <td>&nbsp;</td>\n";
        print "    <td>";
        print "      <input type=\"file\" name=\"photo[$user_id]\" size=\"10\">";
        print "</td>";
        print "    <td>&nbsp;</td>\n";
        print "    <td>";
        print "      <input type=\"submit\" value=\"".$lang->basket_upload."\" align=\"top\">";
        print "</td>";
        print "    <td>&nbsp;</td>\n";
        print "    <td>";
        $this->select_photos($user_id);
        print "</td>";

        print "  </tr>";
        print "  <tr>";
        print "    <td valign=\"top\" align=\"left\">";
        print $lang->basket_photo_description;
        print "</td>\n";
        print "    <td>&nbsp;</td>\n";

        if (! empty($global_basket_photo_description[$user_id])) {
            $desc=$global_basket_photo_description[$user_id];
            $this->form_order_description.="$user_id ".$this->item['name'].": ".$desc."\n";
        } else $desc="";

        print "    <td colspan=\"5\">";
        print "    <textarea rows=\"3\" cols=\"40\" name=\"basket_photo_description[$user_id]\">".$desc."</textarea>\n";
        print "</td>\n";
        print "  </tr>";

        return;
    } // end _row()

    /**
     * Sprawdz czy zostalo zalaczone jakies zdjecie
     * @return bool true - zdjecie zostalo zalaczone; false - nie zalaczono zdjecia
     */
    function test_upload() {
        global $_FILES;

        if (empty($_FILES['photo'])) return false;
        $tab=$_FILES['photo'];
        reset($tab);$empty=true;
        while (list($key,$val) = each($tab)) {
            if ($key=="name") {
                while (list($id,$idval) = each($val)) {
                    if (! empty($idval)) return true;
                }
            }
        }
        return false;
    } // end test_upload()

    /**
     * Zmien format danych wejsciowych
     * 
     * format wyjsciowy np:
     * [A100] => Array
     *         (
     *           [name] => zrzut.jpg
     *           [type] => image/jpeg
     *           [tmp_name] => /tmp/php9JijGc
     *           [size] => 75388
     *          )
     * [A234] => ...
     * gdzie A100, A234 to user_id produktow z tabeli main
     *
     * \@global $this->files
     * @return array $this->files
     */
    function change_data_format() {
        global $_FILES;

        $this->files=array();
        if (empty($_FILES['photo'])) return false;
        $tab=$_FILES['photo'];
        reset($tab);$empty=true;
        while (list($key,$val) = each($tab)) {
            while (list($user_id,$name) = each($val)) {
                $this->files[$user_id][$key]=$name;
            }
        }
        return $this->files;
    } // end change_data_format()

    /**
     * Analizuj liste zalaczonych zdjec.
     * Zapisz zdjecia w tmp_photos oraz uaktualnij dnae w bazie [dodaj|aktualizuj]
     */ 
    function insert_update() {
        $files=&$this->change_data_format();
        reset($files);
        while (list($user_id,$val) = each($files)) {
            if (! empty($val['name'])) {
                // skopiuj zdjecie do tmp_photos
                $this->photo_row($user_id,$val);
            }
        }
        return;
    } // end insert_update()

    /**
     * Zalaczono zdjecie, skopiuj i wpisz je do bazy.
     */
    function photo_row($user_id,$tab) {
        global $DOCUMENT_ROOT;
        global $lang;

        $this->name=$tab['name'];
        $this->tmp_name=$tab['tmp_name'];
        $this->user_id=$user_id;

        // dodaj dane do bazy
        if ($this->db()) {
            if (copy($this->tmp_name,"$DOCUMENT_ROOT/$this->tmp_photos/$this->name")) {
                // zdjecie poprawnie skopiowane
            } else die ("Nie udalo sie zalaczyc zdjecia $this->name");
        }

        return;
    } // end photo_row()

    /**
     * Wstaw dane zdejcia do bazy.
     * @param $this->name
     * @param $this->user_id
     */
    function db($user_id="") {
        global $db;
        global $sess;
        global $lang;

        // odczytaj sesje, poworwnaj pozniej z sesja zapisana przy zalacznym zdjeciu.
        // jesli sesja bedzie ta sama, to zezwalaja na nadpisywanie zdjec, jesli nie to nie zezwlaj na taka operacje
        // gdyz w takim przypadku uzytkoniwcy mogliby nawzajem nadpisywac sobie zdjecia, co byloby efektem
        // dalece niepozadanym
        $session_id=$sess->id;

        $copy=true; // czy mozna skopiowac plik?
        // sprawdz, czy takiego zdjecia nie ma juz w bazie
        $query="SELECT session_id FROM basket_photo WHERE name=?";
        if (! empty($user_id)) {
            // nastapilo wprowadzenie danych z listy select
            $query="SELECT session_id FROM basket_photo WHERE name=? AND user_id=?";
        }
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$this->name);
            if (! empty($user_id)) {
                $db->QuerySetText($prepared_query,2,$this->user_id);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                $db_session_id=$db->FetchResult($result,0,"session_id");
                if ($num_rows>0) {
                    if ($session_id==$db_session_id) {
                        // uzytkownik nadpisuje to samo zdjecie w bazie
                        // nic nie zmieniaj
                    } else {
                        print $lang->basket_upload_file_exists."(<b>$this->name</b>)<BR>";
                        $copy=false;
                    }
                } else {
                    $this->insert();
                }
            } else die ($db->Error());
        } else die ($db->Error());

        if ($copy==true) return true;
        else return false;
    } // end db()

    function insert() {
        global $db;
        global $sess;

        $query="INSERT INTO basket_photo (session_id,user_id,name) VALUES (?,?,?)";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$sess->id);
            $db->QuerySetText($prepared_query,2,$this->user_id);
            $db->QuerySetText($prepared_query,3,$this->name);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // zdjecie zostalo dodane do bazy
            } else die ($db->Error());
        } else die ($db->Error());
        return;
    }

    /**
     * Usun wybrane zdjecie
     * 
     * @param string $user_id numer produktu z main
     * @param string $name nazwa zdjecia
     */
    function delete($user_id,$name) {
        global $db;

        if (empty($user_id)) return;
        if (empty($name)) return;

        $query="DELETE FROM basket_photo WHERE user_id=? AND name=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$user_id);
            $db->QuerySetText($prepared_query,2,$name);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // zdjecia zostaly poprawnie skasowane
            } else die ($db->Error());
        } else die ($db->Error());

        return;
    } // end delete()

    /**
     * Informacja o juz zalaczonych zdjciach. Wyswietl zalaczone pliki z biezaca sesji.
     */
    function info_calc() {
        global $db;
        global $sess;

        $this->photos=array();
        $query="SELECT * FROM basket_photo WHERE session_id=? ORDER BY user_id";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$sess->id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                for ($i=0;$i<$num_rows;$i++) {
                    $name=$db->FetchResult($result,$i,"name");
                    $user_id=$db->Fetchresult($result,$i,"user_id");
                    $element=array("name"=>$name,"user_id"=>$user_id);
                    array_push($this->photos,$element);
                }
            } else die ($db->Error());
        } else die ($db->Error());

        return;
    } // end info_calc()

    /**
     * Wyswietl zdjecia dla danego produktu
     */ 
    function info($user_id) {
        reset($this->photos);
        foreach ($this->photos as $element) {
            $name=$element['name'];
            $tab_user_id=$element['user_id'];
            if ($tab_user_id==$user_id) {
                print "<b><a href=$this->local_tmp_photos/$name target=photo><u>$name</u></b></a>";
                $urlname=urlencode($name);
                $urluser_id=urlencode($user_id);
                print " &nbsp;&nbsp; <a href=index.php?com=delete&user_id=$urluser_id&name=$urlname>usuñ</a><br>";
            }
        }
        return;
    } // end info()

    /**
     * Lista dostepnych zdjec
     */ 
    function select_photos($user_id) {
        $names=array(); // zapamietanie juz wyswietlonych nazw
        print "<select name=select[$user_id]>\n";
        print "<option value=''>---\n";
        reset($this->photos);
        foreach ($this->photos as $element) {
            $name=$element['name'];
            if (! in_array($name,$names)) {
                print "<option value='$name'>$name\n";
            }
            array_push($names,$name);
        }
        print "</select>\n";
        return;
    } // end select_photos()

    /**
     * Wskazanie nazwy pliku z listy "select"
     */
    function select_name() {
        global $_REQUEST;

        if (! empty($_REQUEST['select'])) {
            $select=$_REQUEST['select'];
        } else return;

        while (list($user_id,$name) = each($select)) {
            if (! empty($name)) {
                $this->name=$name;
                $this->user_id=$user_id;
                // uaktualnij dane w bazie
                $this->db($user_id);
            }
        }

        return;
    } // end select_name()

} // end class BasketPhoto

$basket_photo = new BasketPhoto;

?>
