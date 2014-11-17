<?php 
/**
* Enkodowanie URLa
*
* @author  tomasz@mikran.pl
* @version $Id: encodeurl.inc,v 1.2 2007/05/14 12:04:42 tomasz Exp $
*
* @package    include
*/

class EncodeUrl {
      var $to_replace = array(" ", "/",";",",","+",":",".","(",")","%","*","\\",";","-");
      
	/**
	 * Zwróæ warto¶æ zakodowanego URLa
	 *
	 * @param url do encodowania $name
	 * @return zakodowany url
	 */
      function encode_url_category($name) 
      {
         $retval = str_replace($this->to_replace," ",$name);
         $retval = trim($retval);
         $retval = ereg_replace("[ ]+","-",$retval);
         
	$retval = urlencode(strtr($retval,"¡ÆÊ£ÑÓ¦¯¬±æê³ñó¶¿¼","ACELNOSZZacelnoszz"));

	 //$retval = mb_convert_encoding($retval, "UTF-8","ISO-8859-2");
         
         return $retval;
      }	
}
?>
