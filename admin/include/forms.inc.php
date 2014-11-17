<?php
/**
* Klasa generujaca elementy formularza wykozrystywane przy edycji rekordow z bazy, z obsluga form_check
* Formulrze generowane przez ta klase sa wykorzystywane m.in. przez automatycznie generowane skrypty przez php_admin_table,
* ktore bazuja "mod_table".
*
* Przygotowujac nowa funkcje nalezy pamietac o zachowaniu identycznej jak inne funkcje struktury oraz
* odpowiednia kolejnosc parametrow. Nie nalezy powtarzac funkcji dotyczacych juz istniejacych elementow formularza.
* Indywidualne funkcje nalezy przygotowywac w loklanych klasach bedacych rozszezeniem niniejszej globalnej klasy.
*
* @author  m@sote.pl lech@sote.pl
* @version $Id: forms.inc.php,v 2.26 2005/11/03 11:33:26 lukasz Exp $
* @package    admin_include
*/

include_once ("WYSIWYG/wysiwyg.inc.php");

class Forms {
    var $onclick="onclick=\"window.open('','window1','width=_WIDTH_,height=_HEIGHT_,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
    var $table;
    var $item=1;                      // czy do nazw zmiennych dodac domylsnie "item" ; 1 - tak, 0 - nie
    var $auto_update=true;            // automatycznie dolaczaj zmienna update=true przy formularzu
    var $wysiwyg=true;                // automatycznie aktywuj linki do WYSIWYG w polu textarea
    
    /**
    * Generuj nazwe pola (opcjonalnie dodaj do nazwy item np. item[nazwa] itp.
    *
    * @param  string $name nazwa pola
    * @return string nazwa pola formularza np. nazwa lub item[nazwa]
    */
    function item($name) {
        if ($this->item==1) {
            // zamien nazwe "item[nazwa]" na "nazwa", jesli item wystepuje w nazwie pola
            $my_name=ereg_replace("item\[","",$name);
            $this->my_name=ereg_replace("\]","",$my_name);
            
            return "item[$name]";
        } else return $name;
    } // end item()
    
    /** 
    * Otworz formularz i tabele HTML
    *
    * @param string $action    action formularza
    * @param int    $id        id edytowanego rekordu przekazywane do kolejnego wywoalnia formularza, wymagane przy update
    * @param string $form_name nazwa formularza, wymagana dfo prawidlowego wywolania javascript submit
    */
    function open($action="",$id="",$form_name="MyForm",$enctype="") {
        $this->form_name=$form_name;
        print "<form action=$action method=POST name=$this->form_name";
        if (! empty($enctype)) {
            print " enctype='$enctype' ";
        }
        print ">\n";
        if ($this->auto_update==true) {
            print "<input type=hidden name=update value=true>\n";  // element pozwalajacy na rozpoznanie, czy jest to 1 wywolanie formularza
        }
        // czy wywolanie z zadaniem  sprawdzenia poprawnosci fromularza
        print "<input type=hidden name=id value='$id'>\n";     // id rekordu, jesli dodajemy rekord, to id jest puste
        print "<table border=0 align=center>";
        return(0);
    } // end open
    
    /**
    * Otworz formularz i tabele
    *
    * @param string $action    action formularza
    * @param int    $id        id edytowanego rekordu przekazywane do kolejnego wywoalnia formularza, wymagane przy update
    * @param string $form_name nazwa formularza, wymagana dfo prawidlowego wywolania javascript submit
    */
    function multipart($action="",$id="",$form_name="MyForm") {
        $this->form_name=$form_name;
        print "<form action=$action method=POST name=$this->form_name enctype='multipart/form-data'>\n";
        print "<input type=hidden name=update value=true>\n";  // element pozwalajacy na rozpoznanie, czy jest to 1 wywolanie formularza
        // czy wywolanie z zadaniem  sprawdzenia poprawnosci fromularza
        print "<input type=hidden name=id value='$id'>\n";     // id rekordu, jesli dodajemy rekord, to id jest puste
        print "<table border=0 align=center>";
        return(0);
    } // end open
    
    /**
    * Zamknij tabele i formularz
    */
    function close() {
        print "</table>\n";
        print "</form>\n";
        return(0);
    } // end close()
    
    /**
    * Funckja pusta, wykorzystywana wtedy, kiedy chemy eygenerowac same kody formularza bez tabeli
    * np. wywolujemy $forms->text("test",$test,"testowe pole",20,"f_empty","f_empty");
    */
    function f_empty() {
        return(0);
    }
    
    /**
    * Otworz wiersz pola formularza
    *
    * @param strong $info tekst okreslajacy nazwe pola formularza
    */
    function open_row($info) {
        print "<tr>\n";
        print "\t<td align=right valign=top>$info</td><td>\n";
        return(0);
    } // end open_row()
    
    /**
    * Zamknij wiersz pola formularza
    */
    function close_row() {
        print "\t</td>\n";
        print "</tr>\n";
        return(0);
    } // end close_row
    
    /**
    * Wstaw element formularza typu TEXT
    *
    * \@modified_by  piotrek@sote.pl
    *
    * @param string $name     nazwa pola
    * @param string $value    domyslna wartosc pola
    * @param string $info     tekst okreslajacy nazwe pola formularza
    * @param int    $size     szerokosc pola w znakach
    * @param int    $disabled wylaczenie (1) formularza
    * @param string $fn_open  nazwa funkcji otwierajacej wiersz pola formularza (otwarcie komorki itp.)
    * @param string $fn_close nazwa funkcji zamykajacej wiersz pola formularza (zamkniecie komorki itp.)
    */
    function text($name,$value,$info,$size=20,$disabled=0,$open_fn="open_row",$close_fn="close_row") {
        global $theme;
        
        if (@$this->text_maxsize>0) $maxsize="maxlength=$this->text_maxsize";
        else $maxsize='';
        
        $name=$this->item($name);
        $this->$open_fn($info);
        if ($disabled==0) {
            $value=ereg_replace('"','\"',$value);
            print "\t<input type=text name=$name value=\"$value\" size=$size $maxsize>\n<BR>";
        } elseif($disabled==1)  print "\t<input type=text name=$name value='$value' size=$size disabled>\n<BR>";
        
        $theme->form_error(@$this->my_name);
        $this->$close_fn();
        return(0);
    } // end text()
    
    /**
    * Wstaw element formularza typu TEXT_AREA
    *
    * @param string $name     nazwa pola
    * @param string $value    domyslna wartosc pola
    * @param string $info     tekst okreslajacy nazwe pola formularza
    * @param int    $rows     ilsoc wierszy
    * @param int    $cols     ilsoc kolumn
    * @param string $wrap     czy tekst ma sie lamac czy nie
    * @param string $fn_open  nazwa funkcji otwierajacej wiersz pola formularza (otwarcie komorki itp.)
    * @param string $fn_close nazwa funkcji zamykajacej wiersz pola formularza (zamkniecie komorki itp.)
    */
    function text_area($name,$value,$info,$rows,$cols,$wrap="hard",$open_fn="open_row",$close_fn="close_row", $wysiwyg_enabled = WYSIWYG_ENABLED) {
        global $theme, $lang;
        
        $name=$this->item($name);
        
        $this->$open_fn($info);
        global $HTTP_SERVER_VARS;
        echo "
        <script>
        function getTextAreaContent()
        {
            content = new String(document.getElementById(\"$name\").value);
        /*
            rExp = /@/g;
            content = content.replace(rExp, '@at;');
            rExp = /&/g;
            content = content.replace(rExp, '@amp;');
            rExp = /#/g;
            content = content.replace(rExp, '@hash;');
            alert(content);
        */
            return content;
        }
        
        </script>";
        print "\t<textarea name=$name id=$name rows=$rows cols=$cols wrap=$wrap>$value</textarea>\n<BR>";
        if ($this->wysiwyg) $theme->wysiwygTextarea($name, $wysiwyg_enabled);
        $theme->form_error($this->my_name);
        $this->$close_fn();
        return(0);
    } // end text()
    
    /**
    * Wstaw element formularza typu HIDDEN
    *
    * @param string $name  nazwa pola
    * @param string $value domyslna wartosc pola
    */
    function hidden($name,$value) {
        $name=$this->item($name);
        print "<input type=hidden name=$name value='$value'>\n";
        return(0);
    } // end hidden()
    
    /**
    * Wyswietl element formularza typu PASSWORD
    *
    * @param string $name     nazwa pola
    * @param string $value    domyslna wartosc pola
    * @param string $info     tekst okreslajacy nazwe pola formularza
    * @param int    $size     szerokosc pola w znakach
    * @param string $fn_open  nazwa funkcji otwierajacej wiersz pola formularza (otwarcie komorki itp.)
    * @param string $fn_close nazwa funkcji zamykajacej wiersz pola formularza (zamkniecie komorki itp.)
    */
    function password($name,$value,$info,$size=20,$open_fn="open_row",$close_fn="close_row") {
        global $theme;
        
        $name=$this->item($name);
        
        $this->$open_fn($info);
        print "\t<input type=password name=$name value='$value' size=$size>\n<BR>";
        $theme->form_error($this->my_name);
        $this->$close_fn($info);
        
        return(0);
    } // end password()
    
    /**
    * Wyswietl element formularza typu SELECT z opcjami
    *
    * \@modified_by piotrek@sote.pl
    * @param string $name     nazwa pola
    * @param string $value    domyslna wartosc pola
    * @param string $info     tekst okreslajacy nazwe pola formularza
    * @param array  $data     tablica z opcjami array("wartosc"=>"opis",...)
    * @param bool   $action   okreslenie czy ma byc wywolana fukcja JS onChange()
    * @param string $fn_open  nazwa funkcji otwierajacej wiersz pola formularza (otwarcie komorki itp.)
    * @param string $fn_close nazwa funkcji zamykajacej wiersz pola formularza (zamkniecie komorki itp.)
    */
    function select($name,$value,$info="",$data,$action="",$default='',$open_fn="open_row",$close_fn="close_row") {
        $this->$open_fn($info);
        $name=$this->item($name);
        if (empty($action)) {
            print "\n\t<select name=$name onChange=\"javascript:document.".$this->form_name.".submit();\">\n";
        } else {
            print "\t<select name=$name>\n";
        }
        
        reset($data);
        
        if(!empty($default)) {
            print "\t<option value='' >$default</option>\n";
        }
        
        while (list($key,$val) = each($data)) {
            if ($value==$key) {
                print "\t<option value='$key' selected>$val</option>\n";
            } else {
                print "\t<option value='$key'>$val</option>\n";
            }
        }
        print "\t</select>\n";
        
        $this->$close_fn();
        return(0);
    } // end select
    
    /**
    * Wyswietl element formularza typu CHECKBOX
    *
    * @param string $name     nazwa pola
    * @param string $value    domyslna wartosc pola
    * @param string $info     tekst okreslajacy nazwe pola formularza
    * @param string $fn_open  nazwa funkcji otwierajacej wiersz pola formularza (otwarcie komorki itp.)
    * @param string $fn_close nazwa funkcji zamykajacej wiersz pola formularza (zamkniecie komorki itp.)
    */
    function checkbox($name,$value,$info,$open_fn="open_row",$close_fn="close_row") {
        global $theme;
        $this->$open_fn($info);
        $name=$this->item($name);
        if ($value==1) $checked="checked"; else $checked="";
        print "<input type=checkbox name=$name value=1 $checked>\n";
        $theme->form_error(@$this->my_name);
        $this->$close_fn();
        return(0);
    } // end checkbox()
    
    /**
    * Wyswietl element formularza typu FILE
    *
    * @param string $name     nazwa pola
    * @param string $info     tekst okreslajacy nazwe pola formularza
    * @param string $fn_open  nazwa funkcji otwierajacej wiersz pola formularza (otwarcie komorki itp.)
    * @param string $fn_close nazwa funkcji zamykajacej wiersz pola formularza (zamkniecie komorki itp.)
    */
    function file($name,$info="",$open_fn="open_row",$close_fn="close_row") {
        $this->$open_fn($info);
        $name=$this->item($name);
        print "<input type=file name=$name>\n";
        $this->$close_fn();
        return(0);
    } // end file()
    
    /**
    * Wyswietl element formularza typu SUBMIT
    *
    * @param string $name     nazwa pola
    * @param string $value    domyslna wartosc pola
    * @param string $fn_open  nazwa funkcji otwierajacej wiersz pola formularza (otwarcie komorki itp.)
    * @param string $fn_close nazwa funkcji zamykajacej wiersz pola formularza (zamkniecie komorki itp.)
    */
    function submit($name="submit",$value="Submit",$open_fn="open_row",$close_fn="close_row") {
        $this->$open_fn("");
        $name=$this->item($name);
        print "\t<input type=submit name=$name value='$value'>\n";
        $this->$close_fn();
        return(0);
    } // end submit()
    
    /**
    * Wyswietl przycisk z klasy Buttons generujacy metode submit() formularza
    *
    * @param string $name      nazwa pola
    * @param string $value     domyslna wartosc pola
    * @param string $form_name nazwa formularza, wymagana dfo prawidlowego wywolania javascript submit
    * @param string $fn_open   nazwa funkcji otwierajacej wiersz pola formularza (otwarcie komorki itp.)
    * @param string $fn_close  nazwa funkcji zamykajacej wiersz pola formularza (zamkniecie komorki itp.)
    */
    function button_submit($name="submit",$value="Submit",$form_name="MyForm",$open_fn="open_row",$close_fn="close_row") {
        global $buttons;
        global $error;
        
        $name=$this->item($name);
        
        if (! empty($form_name)) {
            $this->from_name=$form_name;
        }
        
        if (empty($this->form_name)) {
            print $error->show("buttons_form_name");
        }
        $this->$open_fn('');
        $buttons->button($value,"\"javascript:document.$this->form_name.submit();\"");
        $this->$close_fn('');
        return(0);
    } // end button_submit()
    
} // end class Forms

$forms = new Forms;

?>
