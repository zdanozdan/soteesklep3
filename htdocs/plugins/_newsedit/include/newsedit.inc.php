<?php
/**
* Wyswietlenie listy newsow itp.
*
* @author  m@sote.pl
* @version $Id: newsedit.inc.php,v 2.12 2005/12/12 15:24:38 lechu Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
*/

/**
* Lista newsów
*/
class NewsEdit {
    
    /**
    * Wy¶wietl liste newsów wg grupy
    *
    * @param int $group ID grupy newsow (id z tabeli newsedit_groups)
    * \@global $_REQUEST['group'] int ID grupy newsów (z tabeli newsedit_groups)
    *
    * @return none
    */
    function show_list($group=1) {
        global $config,$_REQUEST;
                
        $and_group="id_newsedit_groups=1";
        if (! empty($group)) {
            $group=intval($group);
            $and_group="id_newsedit_groups=$group";
        } elseif (! empty($_REQUEST['group'])) {
            if (ereg("^[0-9]+$",$_REQUEST['group'])) {
                $group=intval($_REQUEST['group']);
                $and_group="id_newsedit_groups=$group";
            } else return false;
        }
        
        $group=addslashes($group);
        
        // lista newsow
        $sql="SELECT * FROM newsedit WHERE lang='".$config->lang."' AND active=1 AND 
                        ($and_group OR group1=$group OR group2=$group OR group3=$group)
                ORDER BY ordercol DESC";                
                
        
        $dbedit =& new DBEdit;
        $dbedit->dbtype=$config->dbtype;
        $dbedit->top_links="false";
        $dbedit->record_class="NewsEditRow";
        $dbedit->empty_list_message="";
        
        if (ereg("^[0-9]+$",$group)) {
            global $__group;
            $__group=$group;            
            require_once ("plugins/_newsedit/include/newsedit_row.inc.php");
        }
        
        // print $sql;
        
        $dbedit->record_list($sql);
        
        return;
    } // end show_list()

    
    /**
    * Ile jest newsów
    *
    * @param int $group ID grupy newsow (id z tabeli newsedit_groups)
    * \@global $_REQUEST['group'] int ID grupy newsów (z tabeli newsedit_groups)
    * @author lech@sote.pl
    *
    * @return int liczba newsów
    */
    function get_news_count($group = 1) {
        global $config,$_REQUEST, $mdbd;
                
        $and_group="id_newsedit_groups=1";
        if (! empty($group)) {
            $group=intval($group);
            $and_group="id_newsedit_groups=$group";
        } elseif (! empty($_REQUEST['group'])) {
            if (ereg("^[0-9]+$",$_REQUEST['group'])) {
                $group=intval($_REQUEST['group']);
                $and_group="id_newsedit_groups=$group";
            } else return false;
        }
        
        $group=addslashes($group);
        
        $where="lang='".$config->lang."' AND active=1 AND 
                        ($and_group OR group1=$group OR group2=$group OR group3=$group) ";
        
        $mdbd->select('id', 'newsedit', $where, array());
        return $mdbd->num_rows;
    } // end get_news_count()
    
} // end class NewsEdit

$newsedit =& new NewsEdit;


?>
