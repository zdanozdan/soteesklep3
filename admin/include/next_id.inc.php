<?php
/**
 * Wygenetuj kolejne ID tabeli main_keys
 *
 * @author  m@sote.pl
 * \@template_version Id: next_id.inc.php,v 2.2 2003/07/15 08:42:57 maroslaw Exp
 * @version $Id: next_id.inc.php,v 2.2 2004/12/20 17:59:24 maroslaw Exp $
* @package    admin_include
 */

class NextID {

    /**
     * Generuj kolejny numer id tabeli $table
     * 
     * @param string $table  nazwa tabeli
     * @param string $column nazwa pola tabeli wg ktorego generujemy koljeny numer ID 
     *                       (pole musi byc typu INT)
     * @return int kolejny numer ID
     */
    function next($table,$column="id") {
        global $config;
        global $db;
        
        $maxid="MAX($column) AS maxid";
        $query="SELECT $maxid FROM $table limit 1";
        $result=$db->Query($query);
        if ($result!=0) {
            if ($db->NumberOfRows($result)>0) {
                if ($db->FetchResult($result,0,"maxid")>0) {
                    return $db->FetchResult($result,0,"maxid")+1;
                } else return 1;
            } else return 1;
        } else die ($db->Error());
    } // end next()
        
} // end class NextID

?>
