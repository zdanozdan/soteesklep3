<?php
/**
* Zmieñ grupê newsow
*
* \@session array $__newsedit_group  informacja o domyslnej grupie newsow
* \@session array $__newsedit_groups array("id"=>"nazwa grupy",...)
*
* @author  m@sote.pl
* @version $Id: change_group.inc.php,v 2.3 2004/12/20 18:00:09 maroslaw Exp $
* @package    newsedit
*/

if (@$__secure_test!=true) die ("Forbidden");

// zapamietaj w tablicy id=>nazwa grup newsow
$__newsedit_groups=$mdbd->select("id,name","newsedit_groups","1",array(),"ORDER BY id","ARRAY");
global $__newsedit_groups;
$_tmp=array();
reset ($__newsedit_groups); 
foreach ($__newsedit_groups as $key=>$tab) {
    $_tmp[$tab['id']]=$tab['name'];
}
$__newsedit_groups=$_tmp;
// end
    
if (! empty($_REQUEST['group'])) {
    // sprawdz, czy przekazany numer grupy istnieje
    $id_group=$_REQUEST['group'];
    $dat=$mdbd->select("id,name","newsedit_groups","id=?",array($id_group=>"int"));
    
    if ($dat['id']>0) {
        global $__newsedit_group;
        $__newsedit_group=array("id"=>$dat['id'],"name"=>$dat['name']);
        $sess->register("__newsedit_group",$__newsedit_group);
    } 
} elseif (@$_REQUEST['group']=='0') {
    $sess->unregister("__newsedit_group");
    unset($__newsedit_group);  
} elseif (! empty($_SESSION['__newsedit_group'])) {
    $__newsedit_group=$_SESSION['__newsedit_group'];   
}

?>
