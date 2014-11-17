<?php
/**
 * Lista akcesoriów do danego produktu wg. pola accessories z tabeli "main"
 *
 * \@global  string $__accessories lista akcesoriow do produktu w formacie: A01;A02;B23;...
 * \@global  int    $__id          id edytowanego produktu
 *
 * @author  m@sote.pl
 * @version $Id: accessories.inc.php,v 2.5 2005/01/20 14:59:21 maroslaw Exp $
 *
 * \@verified 2004-03-15 m@sote.pl
* @package    edit
 */

if (@$__secure_test!=true) die ("Forbidden");

if (! empty($__accessories)) {

    if (! ereg("^[0-9]+$",$id)) die ("Forbidden: ID");

    $query="SELECT * FROM main WHERE (id!=$__id) AND (1=2 OR";
    $acc_id=split(";",$__accessories,500);
    if (! empty($acc_id)) {
        foreach ($acc_id as $user_id) {
            $user_id=addslashes($user_id);
            $query.=" user_id='$user_id' OR";
        } // end foreach
        $query=substr($query,0,strlen($query)-3); // obetnij " OR" na koncu zapytania
    }
    $query.=") ";
    
    // funkcja prezentujaca wynik zapytania w glownym oknie strony 
    include_once ("include/dbedit_list.inc");
    global $__disable_trash;
    $__disable_trash=true;

    $sql=$query;
    $dbedit = new DBEditList;
    $dbedit->title=$lang->edit_accessories_title;
    $dbedit->list_trash=false;
    $dbedit->start_list_element=$theme->list_th();   

    $dbedit->show();
}

?>
