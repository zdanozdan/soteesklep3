<?php
/**
 * Dodaj nowy rekord do tabeli help_content wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author  lech@sote.pl m@sote.pl
 * \@global  string $table nazwa tabeli do ktorej dodajemy rekord
 * \@template_version Id: insert.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: insert.inc.php,v 1.6 2005/02/16 09:46:11 maroslaw Exp $
 * @return  int $this->id
* @package    help_content
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;

require_once ("HTML/Parser/parserHTML.php");
$htmlParser = & new ParserHTML;

// dodaj rekord
// config
$query="INSERT INTO help_content (title,html,author,date_add,date_update,title_en,html_en) VALUES (?,?,?,?,?,?,?)";
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
    $db->QuerySetText($prepared_query,5,date("Y-m-d"));
    $db->QuerySetText($prepared_query,6,$this->data['title_en']);
    $db->QuerySetText($prepared_query,7,$this->data['html_en']);
   
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->help_content_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());
?>
