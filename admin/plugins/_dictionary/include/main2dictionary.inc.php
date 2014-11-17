<?php
/**
 * Odczytanie kategorii  z tablicy main i zapisanie ich do tablicy dictionary (slownika dla kategorii)
 * zapisujemy tylko te kategorie i podkategorie, ktore sa rozne !
 *
 * $author: piotrek@sote.pl
 * $Id: main2dictionary.inc.php,v 2.5 2004/12/20 17:59:37 maroslaw Exp $
* @version    $Id: main2dictionary.inc.php,v 2.5 2004/12/20 17:59:37 maroslaw Exp $
* @package    dictionary
 */

class Main2dictionary {
  
    var $axy=array(); 
      
    /**
     * Odczytaj kategorie z main i zapamietaj je w tablicy $this->axy
     *
     * \@global array $this->my lista kategorii
     */
    function db2array(){
        global $db;
        
        $query="SELECT category1,id_category1,category2,id_category2,category3,id_category3,category4,id_category4,category5,id_category5
                  FROM main GROUP BY 
                       category1,id_category1,category2,id_category2,category3,id_category3,category4,id_category4,category5,id_category5
                  ORDER BY category1,category2,category3,category4,category5
               ";
        
        $this->my=array();
        $my_tmp=array();
        $result=$db->Query($query);

        $val_complete="";
        $id_val_complete="";
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows==0) return false;            
            for ($i=0;$i<$num_rows;$i++) {
                $val_complete="";
                $id_val_complete="";
                for ($c=1;$c<=5;$c++) {
                    $cat="category$c";
                    $val=$db->FetchResult($result,$i,"$cat");
                    
                    if (! empty ($val)) {
                        $my_tmp[$c]=$val;
                    }
                                                          
                } // end for
                                
                if (! empty($my_tmp)) {
                    array_push($this->my,$my_tmp);
                }
                              
            } // end for
        } else {
            die ($db->Error());
        }

        return true;
    } // end db2array()
    
    
    /**
     * przygotowanie talicy $my_array do dodania rekordow do tabeli dictionary w odpowiednim formacie
     * format wejsciowy - tablica $this->axy: [category][name]=kat1 / kat2 /kat3 ; [category][id]=23_1_23 itd.
     * 
     * format wyjsciowy - tablica $my_array: [name]=kat1 ; [id]=23 itd.  
     *
     **/ 
    
    function array2dictionary () {
        global $db;
        global $lang;
        global $config;
        
        $temp=array();
        $index=0;
        
        foreach($this->my as $value) {
            for($i=0;$i<5;$i++) {
                if(! empty($value[$i])) {                    
                    if(empty($temp[0])) {
                        $temp[$value[$i]]=1;  // kluczem tablicy jest nazwa, dzieki czemu nazwy sie nie powtarzaja, 1 nie ma znaczenia
                        $index++;
                    } // end if                    
                } // end if(! empty($value[$i]))              
            } // end for
        } // end foreach

        $new_temp=array();
        while (list($key,$val) = each($temp)) {  //odwracanie tablicy
            array_push($new_temp,$key);
        } //end while

        $query="INSERT INTO dictionary (wordbase,key_md5) VALUES (?,?)";
        $prepared_query=$db->PrepareQuery($query);
        
        if ($prepared_query) {
            foreach ($new_temp as $value) {
                
                $this->data['wordbase']=$value;
                $this->data['key_md5']=md5($value);
                // config
                $db->QuerySetText($prepared_query,1,$this->data['wordbase']);
                $db->QuerySetText($prepared_query,2,$this->data['key_md5']);
                //end
                $result=$db->ExecuteQuery($prepared_query);
                if ($result!=0) {        
                    // rekord zostal dodany prawidlowo
                    //print "OK ";
                } else  {
                    //print "- ";
                    // taki rekord juz istnieje, rekord nie zostal dodany
                } //end if ($result!=0)
            } //end foreach
        }  else die ($db->Error()); //end if ($prepared_query)
    }//end array2dictionary
    
} // end class Main2dictionary

?>
