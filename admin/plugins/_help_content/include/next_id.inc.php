<?php
/**
 * Wygenetuj kolejne ID tabeli help_content
 *
 * @author  lech@sote.pl
 * \@template_version Id: next_id.inc.php,v 2.2 2003/07/15 08:42:57 maroslaw Exp
 * @version $Id: next_id.inc.php,v 1.2 2004/12/20 17:59:51 maroslaw Exp $
* @package    help_content
 */

class NextID {

    /**
     * Generuj kolejny numer id tabeli $table
     * 
     * @return int kolejny numer ID
     */
    function next($table) {
        global $config;
        global $db;
        
        $maxid=$config->dbtype."_maxid";
        $maxid=$config->$maxid;
        $query="SELECT $maxid FROM $table limit 1";
        $result=$db->Query($query);
        if ($result!=0) {
            if ($db->NumberOfRows($result)>0) {
                if ($db->FetchResult($result,0,$maxid)>0) {
                    return $db->FetchResult($result,0,$maxid)+1;
                } else return 1;
            } else return 1;
        } else die ($db->Error());
    } // end next()
    
    
} // end class NextID

?>
