<?php
/*----------------------------------------------------------------------------------
| Class SDConvertText image uploading
| Example:
| Powered by www.SexDev.com
| <?
| 	$ct = new SDConvertText();
| 	$text = '<a href="http://www.yahoo.com">http://www.yahoo.com/</a>'
| 			.'<br><b>Yahoo Server</b><br><i>Search Engine</i>';
| 	$allowed_tags = array('<br>','<a>');
| 	echo $ct->dropHTML($text,$allowed_tags);
| 	echo $ct->shortText($text,10);																|
| ?>
-----------------------------------------------------------------------------------*/
class SDConvertText {
	
	/**************************************************
	* this function will activate all functions 
	* in this class except of shortText function
	**************************************************/
	function convertAll($str,$allowed_tags){
		$str = $this->dropHTML($str,$allowed_tags);
		$str = $this->activateLinks($str);
		return $str;
	}

	/****************************************************
	* Takes a string, and does the reverse of the PHP 
	* standard function htmlspecialchars().
	****************************************************/
	function undo_htmlspecialchars($string) {
		$string = preg_replace("/&gt;/i", ">", $string);
		$string = preg_replace("/&lt;/i", "<", $string);
		$string = preg_replace("/&quot;/i", "\"", $string);
		$string = preg_replace("/&amp;/i", "&", $string);
		return $string;
	}

	/**************************************************
	* this function will activate all links and 
	* email addresses with <a> tag
	**************************************************/
	function activateLinks($str) {
		$str = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\\1" target="_blank">\\1</a>', $str); 
		$str = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a href="http://\\2" target="_blank">\\2</a>', $str); 
		$str = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})','<a href="mailto:\\1">\\1</a>', $str); 
		return $str;
	}
	
	/************************************************** 
	* this function will drop HTML tags except of
	* of tag in $allowed_tags varible
	* can be also array of tags
	**************************************************/
	function dropHTML($str,$allowed_tags = ''){
        $tags="";
		if(is_array($allowed_tags)){
			foreach($allowed_tags as $key => $value)
				$tags .= $value;
			return $str = strip_tags($str,$tags);
		}else{
			return strip_tags($str,$allowed_tags);
		}
	}
	
	/**************************************************
	* This function shortens text into $length at most. 
	* If the text is longer, puts an ellipsis at the end.
	**************************************************/
	function shortText($str,$length){
		return strlen($str) > $length ? preg_replace('/\s\S*$/','...',substr($str,0,$length - 3)) : $str;
	}
}
?>