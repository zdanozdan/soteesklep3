<?php
/**
 * Exportowanie tablicy main do pliku
 *
 * @author  rdiak@sote.pl
 * @version $Id: export.inc.php,v 1.4 2005/09/08 13:23:14 lukasz Exp $
 * @package export
 * @subpackage admin
 */

/**
 * Includowanie potrzebnych klas 
 */
include_once ("include/metabase.inc");
require_once ("themes/stream.inc.php");
require_once ("include/ftp.inc.php");
include("lib/ConvertCharset/ConvertCharset.class.php");

/**
 * Klasa OfflineExport
 *
 * @package export
 * @subpackage admin
 */
class OfflineExport {

    var $export_column=array();             //kolumny ktore eksportujemy
    var $export_type='';			 		// typ ekportu (CSV, SQL ,XML )
	var $export_encoding='';				// typ kodowania polskich znaków
    var $export_comm='';
	var $data=array();						// dane z bazy danych
	var $struct=array();   				    //struktura pliku do eksportu
    var $path='';                            // sciezka do pliku exportu
	var $path_file='';                      // sciezka do katalogu w ktorym beda pliki z opisem lub
	

    // konstruktor obiektu
    function OfflineExport() {
        global $DOCUMENT_ROOT;
		global $config;
		global $ftp;
		global $shop;

		$this->path="$DOCUMENT_ROOT/tmp/lang_soteesklep.csv";
        $this->path1=$shop->home_relink("/tmp/lang_soteesklep.csv");
        $this->path_file="$DOCUMENT_ROOT/tmp/lang_tmp";
		$this->struct=$config->offline_file_struct;
		$this->struct_pl=$config->offline_names_column;
		$this->_newEncoding = new ConvertCharset;
        @unlink($this->path);
        if(!file_exists($this->path_file)) {
        	
        }
		//print "<pre>";
		//print_r($this->struct);
		//print "</pre>";
		return true;
    }

    function prepare_file() {
		global $lang;
		global $config;
    	   	
	    $stream = new StreamTheme;
		//$stream->legend();
		$stream->title_500();
        flush();
        if(!file_exists($this->path_file)) {
        	$this->print_error("dir_no_exists");
        	return false; 	
        }
      
        if(! ($fp=fopen($this->path,"w"))) {
       		$this->print_error("not_create_file");
			return false;
        } 
    	
    	$str="\t";
				
		foreach($lang->export_names_column as $key1=>$value1){
			$str.=$value1."\t";	
		}
		$str=ereg_replace("\t$","",$str);
		$str.="\n";
        fputs($fp,$str);
		$k=1;
        foreach($this->data as $key=>$value) {
            $str='';
			foreach($this->struct as $key1=>$value1){
				if($key1 == 'command') {
                    $str.=$this->export_comm."\t";
				} elseif(!empty($value[$key1])) {
					if(ereg("([1-9]{1})$",$key1,$regs)) {
						$code=$config->langs_encoding[$regs[0]];
					} else {
						$code='';
					}	
					if(!empty($code)) {
						$value1 = $this->_newEncoding->Convert($value1, $code, "utf-8", 0);
					}	
					if(eregi("[\n\t]",$value[$key1])) {
						$tmp=$value[$key1];
                        $str.="auto\t";
                        $this->save_into_file($key1,$tmp,$value['user_id']);
				    } else {
                       	$str.=$value[$key1]."\t";
					}
				} else {
					$str.="\t";
				}	
			}				
			$stream->line_green();
            $k++;
		    if ($k==500) {
    			$k=0;
      			print "<br>";     
    		}
	 		$str=ereg_replace("\t$","",$str);
    		$str.="\n";
            fputs($fp,$str);
		}
        fclose($fp);
        return true;
    }

	/**
	* Zapisz dane do plików opisów
	*
	* @param  string $field nazwa pola [xml_description | xml_options],
	* @param  string $value dane do zapisania do pliku
	* @param  string $user_id identyfikator rekordu potrzebne to nazwu pliku
	*
	* @return boolean true/false
	*
	* @author rdiak@sote.pl
	*/
    function save_into_file($field,$value,$user_id){
        global $lang;
		global $config;
		global $ftp;
		
		$file=$this->path_file."/".$user_id."_".$field.".txt";
		$filename=$user_id."_".$field.".txt";
	   	if($fp=fopen($file,"w")) {
       		fputs($fp,$value);
			fclose($fp);
       	} else {
  			$this->print_error("not_create_file".$file);
			return false;
       	}
       	$ftp->connect();
        $ftp->put($file,"$config->ftp_dir/admin/tmp/product",$filename);
    	$ftp->close();
        return true;
	}

	/**
	* G³owna funkcja eksportu
	*
	* @return boolean true/false
	*
	* @author rdiak@sote.pl
	*/
	function action() {
        // pobierz z formularza kolumny ktore bedziemy eksportowac
        if(	$this->get_column() == 'true') {
			if($this->select_data() == 'true') {
                if($this->prepare_file() == 'true') {
                   	$this->print_link();
                } else {
                }	                    
			} else {
			}
    	} else {
    	}
    	return true;
    }

	/**
	* Funkcja pokazuje w okienku link do sci±gniêcia pliku z eksportem
	*
	* @return boolean true/false
	*
	* @author rdiak@sote.pl
	*/
    function print_link() {
		global $lang;
    	
		if(file_exists($this->path)) {
    		print "<center><br><br>".$lang->download_file_ok."<br>";
    		print "<u><a href=".$this->path1.">".$lang->download_file."</a></u>";
    	} else {
     		print "<br><br>".$lang->download_file_error."<br>";
    	}	
		print "</center>";
    	return true;    
    }    
    
    function select_data() {
		global $database;
		$columns=$this->export_column;
		$this->data=$database->sql_select_multi_array3($this->export_column,"main");
        //print "<pre>";
		//print_r($this->data);
		//print "</pre>";
		return true;
    }

	function get_column() {
		global $_REQUEST;

		$this->export_column=@$_REQUEST['column_select'];
		$this->export_type=@$_REQUEST['item']['type_export'];
		$this->export_encoding=@$_REQUEST['item']['encoding'];
		$this->export_comm=@$_REQUEST['item']['command'];
		if(empty($this->export_column)) {
			$this->print_error("no_select");
			return false;	
		} elseif (! in_array("user_id",$this->export_column)) {
			$this->print_error("id");
			return false;
		}	
			return true;
	}	
	
	function print_error($error) {
		global $lang;
		global $buttons;
		
		print "<center><br>";
		print "<font color=red><b>B³±d: </b></font>";
		print $lang->export_error[$error]."<br><br>";
		$buttons->button($lang->export_close,"javascript:window.close();");
		print "</center>";
		return true;
	}
			
} // end class OfflineExport

?>
