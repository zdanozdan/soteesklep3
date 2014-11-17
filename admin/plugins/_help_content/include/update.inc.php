<?php
/**
 * Aktualizuj dane w tabeli help_content
 * 
 * @author  lech@sote.pl
 * \@template_version Id: update.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: update.inc.php,v 1.5 2004/12/20 17:59:52 maroslaw Exp $
* @package    help_content
 */

global $db;

require_once ("HTML/Parser/parserHTML.php");
$htmlParser = & new ParserHTML;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE help_content SET title=?, html=?, author=?, date_update=?, title_en=?, html_en=? WHERE id=?";
// end


if(@$this->data['parse'] == 1)
    $this->data['html'] = $htmlParser->parse($this->data['html']);



$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['title']);
    $db->QuerySetText($prepared_query,2,$this->data['html']);  
    $db->QuerySetText($prepared_query,3,$this->data['author']);  
    $db->QuerySetText($prepared_query,4,date("Y-m-d"));
    $db->QuerySetText($prepared_query,5,$this->data['title_en']);
    $db->QuerySetText($prepared_query,6,$this->data['html_en']);
    $db->QuerySetText($prepared_query,7,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->help_content_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>
