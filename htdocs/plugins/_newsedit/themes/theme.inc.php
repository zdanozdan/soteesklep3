<?php
/**
* Prezentacja newsa.
*
* @author  m@sote.pl
* @version $Id: theme.inc.php,v 2.5 2004/12/20 18:02:01 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
*/

/**
* Prezentacja newsa.
*/
class NewsEditTheme  {
    
    /**
    * Pe³na prezentacja Newsa
    *
    * @param array  &$rec  dane z bazy ($rec->data)
    * @param string  $file nazwa pliku szablonu prezentacji newsa
    *
    * @return none
    */
    function newsedit(&$rec,$file) {
        global $config;
        global $lang;
        
        global $DOCUMENT_ROOT;
        $file="_newsedit/$file";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        
        return;
    } // end newsedit()
} // end class NewsEditTheme

?>
