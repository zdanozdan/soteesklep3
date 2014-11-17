<?php
/**
 * Odczytanie kategorii i producentow z tablicy main i zapisanie ich do tablicy discounts
 *
 * @author  piotrek@sote.pl
 * @version $Id: main2discounts.inc.php,v 2.5 2004/12/20 17:59:47 maroslaw Exp $
* @package    discounts
 */
class Main2discounts {
    var $axy=array(); 
     
    /**
     * Odczytaj kategorie, id_kategorii oraz producenta, id_producenta z main i zapamietaj je w tablicy $this->axy
     */
    function db2array(){
        global $db;
        
        $query="SELECT category1,id_category1,category2,id_category2,category3,id_category3,category4,id_category4,category5,id_category5,id_producer,producer
                FROM main GROUP BY 
                       category1,id_category1,category2,id_category2,category3,id_category3,category4,id_category4,category5,id_category5,id_producer,producer
                ORDER BY category1,category2,category3,category4,category5
               ";
        
        $this->axy=array();
        $result=$db->Query($query);

        $val_complete="";
        $id_val_complete="";
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows==0) return false;            
            for ($i=0;$i<$num_rows;$i++) {
                $val_complete="";
                $id_val_complete="";
                $tmp=array();
                $val_producer=$db->FetchResult($result,$i,"producer");
                $id_val_producer=$db->FetchResult($result,$i,"id_producer");
                
                for ($c=1;$c<=5;$c++) {
                    $cat="category$c";
                    $val=$db->FetchResult($result,$i,"$cat");
                    //tworzymy ciag kategorii odzielony znakiem /
                    $val_complete.=$val;
                    if ($val!="") {
                        $val_complete.=" / ";
                    }
                    
                    $id_val=$db->FetchResult($result,$i,"id_$cat");
                    //tworzymy ciag idc np. 1_2_3_8
                    if (($id_val!="") && ($id_val!=0)) {
                        $id_val_complete.=$id_val;
                        $id_val_complete.="_";
                    }
                    
                } // end for

                //wyrzucamy koncowy znak _ i /
                $id_val_complete=ereg_replace("_$","",$id_val_complete);
                $val_complete=ereg_replace("/ $","",$val_complete);
                
                if ((! empty($val_complete)) && (! empty($id_val_complete))) {
                    //zapisz kategorie w formacie kat1/kat2.. razem z id w formacie 1_2_3 gdzie kolejne liczby 
                    //to numery podkategorii, wszystko  zostanie zapisane w tablicy $this->axy
                    $tmp["category"]["name"]=$val_complete;
                    $tmp["category"]["id"]=$id_val_complete;
                } // end if
                
                
                if ((! empty($val_producer)) && (! empty($id_val_producer))) {
                    // zapisz kolejna kategorie w tablicy, ktora zostanie zapisana w $this->axy
                    $tmp["producer"]["name"]=$val_producer;
                    $tmp["producer"]["id"]=$id_val_producer;
                } // end if
                
                if (! empty($tmp)) {
                    // dodaj kolejny wiersza kategorii do $this->axy
                    array_push($this->axy,$tmp);
                }
            } // end for
        } else {
            die ($db->Error());
        }       
        return true;
    } // end db2array()
    
    function array2discounts () {
        global $db;
        global $lang;
        global $config;

        //tablica w ktorej znajduja sie kategorie i producenci 
        $my_array=$this->axy;
              
        $query="INSERT INTO discounts (idc,idc_name,id_producer,producer_name,checksum) VALUES (?,?,?,?,?)";
        $prepared_query=$db->PrepareQuery($query);
        
        if ($prepared_query) {
            foreach ($my_array as $value) {
                if (! empty($value['category']['name'])) {                 
                    $this->data['idc']=@$value["category"]["id"];
                    $this->data['idc_name']=@$value["category"]["name"];
                    $this->data['id_producer']=@$value["producer"]["id"];
                    $this->data['producer_name']=@$value["producer"]["name"];
                    
                    $idc_name=$this->data['idc_name'];
                    $producer_name=$this->data['producer_name'];
                    
                    // suma kontrolna potrzebna w celu uniemozliwienia dodania dwoch identycznych rekordow
                    $checksum=md5($idc_name.$producer_name);
                    
                    // config
                    $db->QuerySetText($prepared_query,1,$this->data['idc']);
                    $db->QuerySetText($prepared_query,2,$this->data['idc_name']);
                    $db->QuerySetText($prepared_query,3,$this->data['id_producer']);
                    $db->QuerySetText($prepared_query,4,$this->data['producer_name']);
                    $db->QuerySetText($prepared_query,5,$checksum);
                    // end
                    
                    $result=$db->ExecuteQuery($prepared_query);
                    if ($result!=0) {        
                        // rekord zostal dodany prawidlowo
                    } else  {
                        // takie ID juz istnieje, rekord nie zostal dodany
                    }
                } //end if
            } // end foreach
        } else die ($db->Error());
        
        
    } // end array2discounts()
    
} // end class Main2discounts

?>
