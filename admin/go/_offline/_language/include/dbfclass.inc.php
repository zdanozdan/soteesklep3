<?php
/************************************************************
DBF reader Class v0.04  by Faro K Rasyid (Orca)
orca75_at_dotgeek_dot_org

Input		: name of the DBF( dBase III plus) file
Output	:	- dbf_rec_size, the number of records
			- dbf_field_size, the number of fields
			- dbf_record, array of records
			- dbf_field, array of fields

Usage	example:
$file= "your_file.dbf";//WARNING !!! CASE SENSITIVE APPLIED !!!!!
$dbf = new dbf_class($file);
$num_rec=$dbf->dbf_rec_size;
$field_num=$dbf->dbf_field_size;
$arrRec =  $dbf->dbf_record;
$arrField = $dbf->dbf_field;

for($i=0; $i<$num_rec; $i++){
	for($j=0; $j<$field_num; $j++){
		echo($arrRec[$i][ $arrField[$j] ].' ');
	}
	echo('<br>');
}

Thanks to :
- Willy
- Miryadi

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
See the GNU  Lesser General Public License for more details.
  
**************************************************************/ 
	class dbf_class {
		
		var $dbf_record=array();
		var $dbf_field=array();

		function dbf_class($filename) {
			if ( file_exists($filename)  && ereg('DBF',strtoupper($filename)) ) {
				
				//Read the File
				 $handle = fopen($filename, "r");
				 if (!$handle) { echo "Cannot read DBF file"; exit; }
				$filesize = filesize($filename);
				$handle = fopen ($filename, "r");
				$doc = fread ($handle, $filesize);
				fclose ($handle);
				if(ord($doc{0}) != 3 && ord($doc{$filesize}) != 26){echo "Not a valid DBF file !!!"; exit;}
				$arrHeaderHex = array();
				for($i=0; $i<32; $i++){
					$arrHeaderHex[$i] = str_pad(dechex(ord($doc{$i}) ), 2, "0", STR_PAD_LEFT);
				}
				
				//Initial value
				$line = 32;//Header Size
				$recnum=  hexdec($arrHeaderHex[7].$arrHeaderHex[6].$arrHeaderHex[5].$arrHeaderHex[4]);//Record Size
				$hdrsize= hexdec($arrHeaderHex[9].$arrHeaderHex[8]);//Header Size+Field Descriptor
				$recsize = hexdec($arrHeaderHex[11].$arrHeaderHex[10]);//Field Size
				$numfield = floor(($hdrsize - $line ) / $line ) ;//Number of Fields
				$this->dbf_field_size = $numfield;
				$this->dbf_rec_size = $recnum;
				
				//Field properties retrieval looping
				for($j=0; $j<$numfield; $j++){
					$name = '';
					for($k=(($j+1)*$line); $k<=(($j+1)*$line)+10; $k++){
						if(ord($doc{$k})){
							$name .= $doc{$k};
						}
					}
					$arrField[$j]['name']= $name;//Name of the Field
					$arrField[$j]['len']= ord($doc{((($j+1)*32)+16)});//Length of the field
					$this->dbf_field[$j] =$name;
				}
				
				//Record retrieval looping
				for($n=0; $n<$recnum; $n++){
					$name = '';
					$pred = 1;
					$name=substr($doc,($n*$recsize)+$hdrsize,$recsize);
					for($m=0; $m<$numfield; $m++){
						$arrRecords[$n][$arrField[$m]['name']]=trim(substr($name,$pred,$arrField[$m]['len']));
						$pred += $arrField[$m]['len'];
					}
				}
				$this->dbf_record = $arrRecords;
				unset($doc);
				
			  } else {
				 echo "Not a DBF file or file doesn't exist !!"; 
				 return;
			  }
		   }
		
	}//End of Class
?>