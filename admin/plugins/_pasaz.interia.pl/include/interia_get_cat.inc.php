<?php
/**
 * Obsluga pobierania kategorii i innych informacji z pasazu interia
 *
 * @author  rdiak@sote.pl
 * @version $Id: interia_get_cat.inc.php,v 1.7 2006/05/24 07:22:27 scalak Exp $
* @package    pasaz.interia.pl
 */


/**
 * Includowanie potrzebnych klas 
 */
require_once("include/interia/interia.inc.php");
require_once ("config/auto_config/interia_config.inc.php");
require_once ("include/ftp.inc.php");
require_once ("include/metabase.inc");
require_once ("include/xml_reader.inc");


/**
 * Klasa interiaGetCat
 *
 * @package interia
 * @subpackage admin
 */
class InteriaGetCat extends Interia {

    var $target='';			// gdzie ftpujemy plik
    var $status=0;

    /**
	 * Konstruktor obiektu interiaGetCat
	 *
	 * @return boolean true/false
	 */
    function InteriaGetCat($from='') {
        global $config;
        $this->target=$config->ftp_dir."/admin/plugins/_pasaz.interia.pl/file";
        $this->interia();
        return true;
    } // end interiaGetCat

    /**
     * Funkcja tworzy komunikat SOAP pobrania danych ze pasa¿u interia 
	 * dopuszczalne warto¶æ to: GetTree, GetProducers, GetAdvantages,
	 * GetFieldsMeaning, GetLocalFilters, GetAllProducts
	 *
     * @return string komunkat SOAP pobrania kategorii
     */
    function _interia_get_data() {
        $str="<namesp1:GetCategories xmlns:namesp1=\"Categories\">";
        $str.="<c-gensym3 xsi:type=\"xsd:string\"/>";
        $str.="</namesp1:GetCategories>";
        return $str;
    } // end _interia_get_data

    /**
     * Funkcja czy¶ci tablice
	 *
     * @param  string $table nazwa tabeli ktor± trzeba wyczy¶ciæ
	 *
     * @return bool 
     */
    function _interia_clear_table_db($table) {
        global $mdbd;
        if($mdbd->delete($table)) {
            return true;
        } else return false;
    } // end _interia_clear_table_db

    /**
     * Funkcja pobiera drzewo kategorii z pasazu interia i zapisuje je w tablicy interia_prod
     * 
     * @param  string $soap_request   komunikat SOAP pobrania korzysci z pasazu interia
     *
     * @return bool   true     dane pobrane, false w p.w.
     */
    function interia_get_tree() {
        global $mdbd;
        global $lang;
        global $DOCUMENT_ROOT;
        global $database;
        //print "cos";
        $soap_request=$this->_interia_get_head();
        $soap_request.=$this->_interia_get_data();
        $soap_request.=$this->_interia_get_foot();
        if(!empty($soap_request)) {
            if($this->status) {
                //print "file";
                $filename="$DOCUMENT_ROOT/tmp/interia";
                $fp = fopen($filename,'r');
                $content = fread($fp, filesize($filename));
                fclose($fp);
            } else {
                $content=$this->soap->send_soap_category($soap_request);
                $fd=@fopen("$DOCUMENT_ROOT/tmp/interia","w+");
                fwrite($fd,$content,strlen($content));
                fclose($fd);
            }
            if($this->_interia_send_request($content,"trans")) {

                $tree=$this->XMLtoArray($this->_values);
                $this->tree=@$tree['SOAP-ENV:ENVELOPE']['SOAP-ENV:BODY']['NAMESP1:GETCATEGORIESRESPONSE']['CATEGORIES']['CATEGORY'];

                if(isset($this->tree)) {
                    $this->_interia_clear_table_db('interia_main_category');
                    foreach($this->tree as $key=>$value) {
                        if($value['PARENT']['content'] == 0 ) {
                            $main_category=$value['NAME']['content'];
                            $user_id=$value['ID']['content'];
                            $main_category=$this->_interia_utf8_to_8859_2($main_category);
                            $database->sql_insert("interia_main_category",array("name"=>$main_category,"user_id"=>$user_id));
                        } else {
                            $main_category=$value['NAME']['content'];
                            $main_category=$this->_interia_utf8_to_8859_2($main_category);
                            $database->sql_insert("interia_main_tree",array("name"=>$main_category,"id_cat"=>$value['ID']['content'],"id_parent"=>$value['PARENT']['content']));
                        }
                    }
                } else {
                    return false;
                }
                if(!empty($this->tree)) {
                    $this->_interia_select_category();
                    print "<center>".$lang->interia_get_cat['tree_load_ok']."<center>";
                } else {
                    print "<center>".$lang->interia_get_cat['tree_load_error']."<center>";
                }
            }
            return false;
        }
        return false;
    } // end _interia_get_tree()

    /**
	 * Funkcja  tworzy liste rozwijana z kategorii pasa¿u interia.
	 *
	 * @return boolean true/false
	 */
    function _interia_select_category() {
        global $database;
        global $DOCUMENT_ROOT;
        global $interia_config;

        $str='<select class=form name="item[interia_category]" size="1"><option value="default">----wybierz----</option>'."\n";
        $where=' WHERE ';
        foreach($interia_config->interia_category as $key=>$value) {
            $where.="name='".$value."' OR ";
        }
        $where=preg_replace("/OR $/","",$where);
        $id_main_cat=$database->sql_select_data_array("user_id","name","interia_main_category","",$where);
        // mamy id kategorii glownych
        // teraz przechodzimy kazda z tych kategorii i tworzymy sciezki
        foreach($id_main_cat as $key=>$value) {
            $data=$database->sql_select_data_array("id_cat","name","interia_main_tree","id_parent=".$key);

            foreach($data as $key1=>$value1) {
                $count=$database->sql_select("count(*)","interia_main_tree","id_parent=".$key1);
                if($count) {
                    $data1=$database->sql_select_data_array("id_cat","name","interia_main_tree","id_parent=".$key1);
                    foreach($data1 as $key2=>$value2) {
                        $count1=$database->sql_select("count(*)","interia_main_tree","id_parent=".$key2);
                        if($count1) {
                            $data2=$database->sql_select_data_array("id_cat","name","interia_main_tree","id_parent=".$key2);
                            foreach($data2 as $key3=>$value3) {
                                $count2=$database->sql_select("count(*)","interia_main_tree","id_parent=".$key3);
                                if($count2) {
                                    $data3=$database->sql_select_data_array("id_cat","name","interia_main_tree","id_parent=".$key3);
                                    foreach($data3 as $key4=>$value4) {
                                        $count3=$database->sql_select("count(*)","interia_main_tree","id_parent=".$key4);
                                        if($count3) {
                                        } else {
                                            $str.="<option  value=\"".$key4."\">".$value."/".$value1."/".$value2."/".$value3."/".$value4."</option>\n";
                                        }
                                    }
                                } else {
                                    $str.="<option  value=\"".$key3."\">".$value."/".$value1."/".$value2."/".$value3."</option>\n";
                                }
                            }
                        } else {
                            $str.="<option  value=\"".$key2."\">".$value."/".$value1."/".$value2."</option>\n";
                        }
                    }
                } else {
                    $str.="<option  value=\"".$key1."\">".$value."/".$value1."</option>\n";
                }
            }
        }
        $str.="</select>\n";
        $file_name_cut="interia_category.php";
        $fd=@fopen("$DOCUMENT_ROOT/tmp/$file_name_cut","w+");
        fwrite($fd,$str,strlen($str));
        fclose($fd);
        //$this->load_ftp($file_name_cut);
        return true;
    } // end _interia_select_category

    function interia_select_cut()
    {
        global $DOCUMENT_ROOT;
        global $interia_config;
        global $ftp;
        global $config;
                
        $file_name="interia_category.php";
        $file_name_cut="interia_category_cut.php";

        if(!file_exists("$DOCUMENT_ROOT/tmp2/$file_name")) {
        	$this->_interia_select_category();
        }

        $data=file("$DOCUMENT_ROOT/tmp/$file_name","r");
        $str='';

        foreach($data as $line) {
            if( strstr($line,'select') ||  strstr($line,'Wybierz')) {
                $str.=$line;
            }
            foreach (@$interia_config->interia_category as $interia_cat) {
                if (preg_match("/$interia_cat/",$line)) {
                    $str.= $line;
                }
            }
        }
        
        $fd=@fopen("$DOCUMENT_ROOT/tmp/$file_name_cut","w+");
        fwrite($fd,$str,strlen($str));
        fclose($fd);
        $ftp->connect();
        $ftp->put("$DOCUMENT_ROOT/tmp/$file_name_cut",$config->ftp_dir."/admin/plugins/_pasaz.interia.pl/file","$file_name_cut");
        $ftp->close();
        return;
    } // end func interia_select_cut

    /**
	 * Funkcja ftpuje plik do okrelsonej lokalizacji.
	 *
	 * @param  string $file nazwa pliku
	 *
	 * @return boolean true/false
	 */
    function load_ftp($file) {
        global $ftp;
        global $DOCUMENT_ROOT;
        $ftp->connect();
        $ftp->put("$DOCUMENT_ROOT/tmp/$file","$this->target","$file");
        $ftp->close();
        return true;
    } // end load_ftp()


    function XMLtoArray($vals)
    {
        // wyznaczamy tablice z powtarzajacymi sie tagami na tym samym poziomie
        $_tmp='';
        foreach ($vals as $xml_elem)
        {
            $x_tag=$xml_elem['tag'];
            $x_level=$xml_elem['level'];
            $x_type=$xml_elem['type'];
            if ($x_level!=1 && $x_type == 'close')
            {
                if (isset($multi_key[$x_tag][$x_level]))
                $multi_key[$x_tag][$x_level]=1;
                else
                $multi_key[$x_tag][$x_level]=0;
            }
            if ($x_level!=1 && $x_type == 'complete')
            {
                if ($_tmp==$x_tag)
                $multi_key[$x_tag][$x_level]=1;
                $_tmp=$x_tag;
            }
        }
        // jedziemy po tablicy
        foreach ($vals as $xml_elem)
        {
            $x_tag=$xml_elem['tag'];
            $x_level=$xml_elem['level'];
            $x_type=$xml_elem['type'];
            if ($x_type == 'open')
            $level[$x_level] = $x_tag;
            $start_level = 1;
            $php_stmt = '$xml_array';
            if ($x_type=='close' && $x_level!=1)
            $multi_key[$x_tag][$x_level]++;
            while($start_level < $x_level)
            {
                $php_stmt .= '[$level['.$start_level.']]';
                if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level])
                $php_stmt .= '['.($multi_key[$level[$start_level]][$start_level]-1).']';
                $start_level++;
            }
            $add='';
            if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ($x_type=='open' || $x_type=='complete'))
            {
                if (!isset($multi_key2[$x_tag][$x_level]))
                $multi_key2[$x_tag][$x_level]=0;
                else
                $multi_key2[$x_tag][$x_level]++;
                $add='['.$multi_key2[$x_tag][$x_level].']';
            }
            if (isset($xml_elem['value']) && trim($xml_elem['value'])!='' && !array_key_exists('attributes',$xml_elem))
            {
                if ($x_type == 'open')
                $php_stmt_main=$php_stmt.'[$x_type]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
                else
                $php_stmt_main=$php_stmt.'[$x_tag]'.$add.' = $xml_elem[\'value\'];';
                eval($php_stmt_main);
            }
            if (array_key_exists('attributes',$xml_elem))
            {
                if (isset($xml_elem['value']))
                {
                    $php_stmt_main=$php_stmt.'[$x_tag]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
                    eval($php_stmt_main);
                }
                foreach ($xml_elem['attributes'] as $key=>$value)
                {
                    $php_stmt_att=$php_stmt.'[$x_tag]'.$add.'[$key] = $value;';
                    eval($php_stmt_att);
                }
            }
        }
        //		print "<pre>";
        //		print_r($xml_array);
        //		print "</pre>";
        return $xml_array;
    }    // END XMLtoArray
} // end class interiaGetCat
