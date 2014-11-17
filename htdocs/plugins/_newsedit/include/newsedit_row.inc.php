<?php
/**
* Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
* Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
*
* \@global  string $global_record_row rodzaj prezentacji rekordu [short|long]
* \@session string $global_record_row_type jw.
*
* @author m@sote.pl
* @version $Id: newsedit_row.inc.php,v 2.10 2005/09/02 08:24:09 lukasz Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
*/

global $DOCUMENT_ROOT;
include_once ("$DOCUMENT_ROOT/plugins/_newsedit/themes/theme.inc.php");

/**
* Zbiór metod zwi±zanych z prezentacj± newsów na li¶cie newsów.
*
* @todo przenie¶æ funkcje zwi±zane z wygl±dem do lokalnych themes'ów
*/
class NewsEditRow {
    
    /* Row separator */
    var $row_separator=1;
    
    /**
    * Odczytaj dane newsa i wy¶wietl wiersz na li¶cie
    *
    * @param  mixed $result            wynik zapytania z bazy danych
    * @param  int   $i                 ID newsa
    * \@global array $__newsedit_groups tablica z ID i nazw± aktualnej grupy newsów np. array("id"=>12,"name"=>"Pomoc")
    *
    * @return none
    */
    function record($result,$i) {
        global $db;
        global $theme;
        global $rec;
        global $__group;
        
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        $rec->data['subject']=$db->FetchResult($result,$i,"subject");
        $rec->data['category']=$db->FetchResult($result,$i,"category");
        $rec->data['short_description']=$db->FetchResult($result,$i,"short_description");
        $rec->data['photo_small']=$db->FetchResult($result,$i,"photo_small");
        $rec->data['url']=$db->FetchResult($result,$i,"url");
        
        // pelna prezentacja reordu
        // NewseditTheme::newsedit(&$rec,"newsedit_row_".$__group.".html.php");
        NewseditTheme::newsedit($rec,"newsedit_row.html.php");
        
        return;
    } // end record_row()
    
    /**
    * Element wyswietlany przed gorna lista linkow do podstron
    */
    function open_page_links_top() {
        return;
    } // end  open_page_links_top()
    
    /**
    * Element wyswietlany po gornej lista liscie do podstron
    */
    function close_page_links_top() {
        return;
    } // end  close_page_links_top()
    
    /**
    * Element wyswietlany przed dolna lista linkow do podstron
    */
    function open_page_links_bottom() {
        return;
    } // end  open_page_links_bottom()
    
    /**
    * Element wyswietlany po dolnej lista liscie do podstron
    */
    function close_page_links_bottom() {
        return;
    } // end  close_page_links_bottom()
    
    /**
    * Wy¶wietl zdjêie newsa o ile zostalo zalaczone
    *
    * @author rp@sote.pl
    * \@global array $rec dane zwrocone z zapytania o news
    * @return void
    */
    function newsPhoto(){
        global $rec, $DOCUMENT_ROOT;
        
        if (!empty($rec->data["photo_small"])) {
            $_photo=$rec->data["photo_small"];
            if(!empty($rec->data['id'])){
                $_id=$rec->data['id'];
                                                
                if (file_exists("$DOCUMENT_ROOT/plugins/_newsedit/news/".$_id."/".$_photo."")) {
                    if (empty($rec->data['url'])) {                       
                        print "<a href=\"/plugins/_newsedit/news/".$_id."/index.php\">";
                    } else {
                        print "<a href=\"".$rec->data['url']."\">";   
                    }
                    print "<img src=\"/plugins/_newsedit/news/".$_id."/".$_photo."\" border=\"0\">";
                    print "</a>\n";
                } else {
                    print "<img src=\"/plugins/_newsedit/news/".$_id."/".$_photo."\" border=\"0\">";
                }
            }
        }
        
        return;
    } // end newsPhoto()
    
    /**
    * Wyswietl temat newsa
    *
    * @author rp@sote.pl
    * \@global array $rec dane zwrocone z zapytania o news
    *
    * @return void
    */
    function newsSubject(){
        global $rec;
        
        if(!empty($rec->data['subject'])){
            $_subject=$rec->data['subject'];
            if(!empty($rec->data['id'])){
                $_id=$rec->data['id'];
                if (empty($rec->data['url'])) {
                    print "<a href=\"/plugins/_newsedit/news/".$_id."/index.php\"><b>".$_subject."</b></a>";
                } else {
                    print "<a href=\"".$rec->data['url']."\"><b>".$_subject."</b></a>";
                }
            } else {
                print "<b>".$_subject."</b>";
            }
        }
        
        return;
    } // end newsSubject()
    
    /**
    * Wy¶wietl link do pelnego opisu newsa
    *
    * @author rp@sote.pl
    * \@global array $rec dane zwrocone z zapytania o news
    *
    * @return void
    */
    function newsInfoButton(){
        global $rec, $theme;
        
        if(!empty($rec->data['url'])){
            $_id=$rec->data['url'];
            $theme->infoOnPageURI($_id);
        }
        else if(!empty($rec->data['id'])){
            $_id=$rec->data['id'];
            $_id="/plugins/_newsedit/news/".$_id."/index.php";
            
            $theme->infoOnPageURI($_id);
        } else return;
        
        return;
    } // end newsInfoButton()
    
    /**
    * Wy¶wietl krotki opis newsa
    *
    * @author rp@sote.pl
    * \@global array $rec dane zwrocone z zapytania o news
    *
    * @return void
    */
    function newsShortDescription(){
        global $rec;
        
        if(!empty($rec->data['short_description'])){
            $_desc=$rec->data['short_description'];
            print $_desc;
        }
        
        return;
    } // end newsShortDescription()
    
    /**
    * Wyswietl date dodania newsa
    *
    * @author rp@sote.pl
    * \@global array $rec dane zwrocone z zapytania o news
    *
    * @return void
    */
    function newsAddDate(){
        global $rec;
        
        /**
        * style CSS dla daty
        * @var array
        */
        $_date_style=array(
        "font-size: 10px;",
        );
        
        if(!empty($rec->data['date_add'])){
            $_date=$rec->data['date_add'];
            print "<font style=\"";
            while(list(,$value)=each($_date_style)){
                print $value;
                print " ";
            }
            print "\">";
            print "(".$_date.")";
            print "</font>";
        }
        
        return;
    } // end newsAddDate()
    
    /**
    * Wyswietl ozdobne zako zakoñczenie tabeli
    *
    * @param int $rows ilosc rekordow w wierszu    
    * \@global int $this->row_separator wskaznik uzycia funkcji separujacej rekordy
    * @access public
    *
    * @return void
    */
    function recordEndDots($rows){
        global $theme;
        
        /**
        * jesli zostal uzyty standardowy separator rekordow konieczne jest
        * dodanie dodatkowych kolumn do spanowania
        */
        if (! empty($this->row_separator) && $this->row_separator==1) $span=($rows*2)-1;
        
        print "  <tr>\n";
        print "    <td colspan=\"".$span."\" align=\"center\" background=\"";
        $theme->img("_img/layout/dots.gif");
        print "\"><img src=\"";
        $theme->img("_img/mask.gif");
        print "\" width=\"1\" height=\"3\"></td>\n";
        print "  </tr>\n";
        print "  <tr>\n";
        print "    <td colspan=\"".$span."\"><img src=\"";
        $theme->img("_img/mask.gif");
        print "\" width=\"1\" height=\"8\"></td>\n";
        print "  </tr>\n";
        
        return;
    } // end recordEndDots()
    
    /**
    * Wyswietl ozdobny separator wierszy
    *
    * @return void
    */
    function recordSeparator(){
        global $theme;
        
        print "<td width=\"1\" background=\"";
        $theme->img("_img/layout/dots.gif");
        print "\"><img src=\"";
        $theme->img("_img/mask.gif");
        print "\" width=\"1\" height=\"1\"></td>";
        
        $this->row_separator=1;
        
        return;
    } // end recordSeparator()
    
} // end NewsEditRow
?>
