<?php

require_once("go/_offline/_main/include/category.inc.php");
class ParseXML 
{
	var $_value=''; 				// dane xml
	
	
	function _getFile() 
	{
		global $DOCUMENT_ROOT;
		$filename="$DOCUMENT_ROOT/tmp/sote.xml";
		$fd=fopen($filename,"r");
		$this->_value=fread($fd,filesize($filename));
	}

    function _parse() {

    	//$xml=$this->soap->xml_to_chars($xml);
        $parser = xml_parser_create();
        if(xml_parse_into_struct($parser,$this->_value,$values,$tags)) {
            //print "<br><br>jestem<br><br><br>";
            if(xml_parser_free($parser)) {
                $this->_values= & $values;
                $this->_tags=& $tags;
                /*print "<pre>";
                print_r($this->_values);
                print "<pre>";
                print "<pre>";
                print_r($this->_tags);
                print "<pre>";*/
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } // end _interia_send_request
	
	function _toDb() {
		global $database;
		$category=new OfflineCategory;
		foreach($this->_tags['IDENTIFIER'] as $key=>$value) {
			$photo=preg_split("/\\//",$this->_values[$this->_tags['IMAGE'][$key]]['value']);
			$rt_selltru_date=preg_split("/\s+/",$this->_values[$this->_tags['PREMIEREDATEST'][$key]]['value']);
			if(!empty($this->_values[$this->_tags['CATEGORY'][$key]]['value'])) {
				$id_cat1=$category->check_category("category1",$this->_values[$this->_tags['CATEGORY'][$key]]['value']);
			}	
			if(!empty($this->_values[$this->_tags['DISTRIBUTOR'][$key]]['value'])) {
				$id_prod=$category->check_category("producer",$this->_values[$this->_tags['DISTRIBUTOR'][$key]]['value']);
			}	
			$database->sql_insert("main", array(
												"user_id"=>$this->_values[$value]['value'],
												"name"=>$this->_values[$this->_tags['TITLE'][$key]]['value'],
												"rt_name_orig"=>$this->_values[$this->_tags['ORIGINALTITLE'][$key]]['value'],
												"photo"=>$photo[1],
												"xml_description"=>$this->_values[$this->_tags['DESCRIPTION'][$key]]['value'],
												"rt_direction"=>$this->_values[$this->_tags['DIRECTOR'][$key]]['value'],
												"rt_cast"=>@$this->_values[@$this->_tags['ACTRESS'][$key]]['value'],
												"rt_year"=>$this->_values[$this->_tags['YEAR'][$key]]['value'],
												"producer"=>@$this->_values[@$this->_tags['DISTRIBUTOR'][$key]]['value'],
												"id_producer"=>@$id_prod,
												"rt_time"=>$this->_values[$this->_tags['RUNTIME'][$key]]['value'],
												"rt_text"=>@$this->_values[$this->_tags['SUBTITLE'][$key]]['value'],
												"rt_extra"=>@$this->_values[$this->_tags['EXTRAS'][$key]]['value'],
												"rt_audio"=>@$this->_values[$this->_tags['AUDIO'][$key]]['value'],
												"rt_format"=>@$this->_values[$this->_tags['FORMAT'][$key]]['value'],
												"rt_selltru_date"=>@$rt_selltru_date[0],
												"category1"=>@$this->_values[$this->_tags['CATEGORY'][$key]]['value'],
												"id_category1"=>@$id_cat1,
												)
								);				
		}
	$category->load_category();
	}
	
    
    
    function action() 
	{
		$this->_getFile();
		$this->_parse();
		$this->_toDB();
		//print $this->_value;
		
	}
}
?>	