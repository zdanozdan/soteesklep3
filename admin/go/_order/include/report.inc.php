<?php 
/**
* Generuj raporty dotycz±ce aktualnego zapytania SQL (transakcji)
*
* @author  m@sote.pl
* @version $Id: report.inc.php,v 2.8 2005/12/06 13:44:05 lechu Exp $
* @package    order
*/

/**
* Raport dot. transakcji
* @package order
*/
class OrderReport {

    /**
    * @var string zapytanie o transakcje
    * @access private
    */
    var $_sql;

    /**
    * @var string warunke zapytania sql (po WHERE)
    * @access private
    */
    var $_sql_where=1;

    /**
    * @var array dane do raportu obliczone na podstawie aktualnego zapytania SQL
    * @access private
    */ 
    var $_data=array();
    
    /**
    * @var mixed adres obiektu $dbedit odnoszacego sie do g³ównego zapyatania SQL dot. listy transaklcji
    */
    var $dbedit;
    
    /**
    * Konstruktor
    *
    * @param  string $sql zapytanie SQL dot. transakcji
    * @return none
    */
    function OrderReport($sql="SELECT * FROM order_register") {
        global $dbedit;
       
        if (! empty($dbedit)) {            
            $this->dbedit=&$dbedit;                  
        } else die ("Unknown dbedit object");
        
        $this->_sql=$sql;
        $tab=preg_split("/where/i",$sql,2);
        if (! empty($tab[1])) {
            $this->_sql_where=$tab[1];
        }
        // sprawd¼, czy w zapytanie jest GROUP lub ORDER, je¶li tak to wytnij je wraz z argumentami
        if (eregi("group by",$this->_sql_where)) {
            $tab=preg_split("/group by/i",$this->_sql_where,2);
            $this->_sql_where=$tab[0];   
        }
        if (eregi("order by",$this->_sql_where)) {
            $tab=preg_split("/order by/i",$this->_sql_where,2);
            $this->_sql_where=$tab[0];   
        }
        $this->_sql_where .= " AND cancel=0 ";
        return;
    } // end OrderRegister()

    /**
    * Oblicz dane potrzebne do raportu i zapamiêtaj je w zmiennej $this->_data
    * 
    * @return none
    */
    function _calcReport() {
        global $db,$theme;
        
        $query="SELECT SUM(total_amount) as total_amount, COUNT(id) AS record_count FROM order_register WHERE ".$this->_sql_where;
        $result=$db->query($query);
        if ($result!=0) {
            $num_rows=$db->numberOfRows($result);
            if ($result>0) {
                $this->_data['total_amount']=$theme->price($db->fetchResult($result,0,"total_amount"));
                $this->_data['records']=(int)($theme->price($db->fetchResult($result,0,"record_count")));
            }
        } else die ($db->error());
        
        // ilo¶c rekordów
//        $this->_data['records']=$this->dbedit->records;
        
        // ¶rednia warto¶c transakcji
        if ($this->_data['records']>0) {
            $this->_data['average_amount_brutto']=$theme->price($this->_data['total_amount']/$this->_data['records']);
        } else {
            $this->_data['average_amount_brutto']='0.00';
        }

    } // end _calcReport();
    
    /**
    * Wy¶wietl raport HTML
    */
    function showHTMLReport() {        
        global $lang,$theme, $__no_head, $_print_mode;
        
        $this->_calcReport();
        if(!$_print_mode) {
	        print "<div align=\"right\">\n";
	        $theme->desktop_open("50%"); 
	        print "<table border=0>\n";
        }
        else {
           print "<center><table border=1  cellspacing=0 cellpadding=2>\n";
        }
        print "<tr><td>".$lang->order_report['total_amount']."</td><td>".$this->_data['total_amount']."</td</tr>\n";
        print "<tr><td>".$lang->order_report['records']."</td><td>".$this->_data['records']."</td></tr>\n";
        print "<tr><td>".$lang->order_report['average_amount_brutto']."</td><td>".$this->_data['average_amount_brutto']."</td></tr>\n";
        print "</table>\n";
        if(!$_print_mode) {
	        $theme->desktop_close();
	        print "</div>\n";
        }
        
        return; 
    } // end showHTMLReport()

} // end class OrderReport
?>
