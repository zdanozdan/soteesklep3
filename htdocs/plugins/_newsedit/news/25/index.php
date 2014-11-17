<?php
/**
* Szablon wywolania Newsa z bazy danych
* Wyswietlany jest news o id odczytywanym z adresu URL postaci
* np. http://www.example.com/plugins/_newsedit/news/1/ , gdzie 1 to id wyswietlanego newsa
* Jesli nie ma newsa, to uzytkownik zostaje przekierowany na glowna storne sklepu
*
* @author  m@sote.pl
* @version $Id: index.php,v 2.8 2005/09/02 08:22:58 lukasz Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../../include/head.inc");

if ($shop->admin) {
    die ("Bledne wywolanie");
}

// odczytaj ID
$REQUEST_URI=$_SERVER['REQUEST_URI'];
preg_match("/news\/([0-9]+)/",$REQUEST_URI,$matches);

if (! empty($matches[1])) {
    $id=$matches[1];
    $id=addslashes($id);
} else $theme->go2main();

// odczytaj tresc newsa z bazy
$query="SELECT * FROM newsedit WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $rec->data['id']=$db->FetchResult($result,0,"id");
            $rec->data['date_add']=$db->FetchResult($result,0,"date_add");
            $rec->data['active']=$db->FetchResult($result,0,"active");
            $rec->data['ordercol']=$db->FetchResult($result,0,"ordercol");
            $rec->data['subject']=$db->FetchResult($result,0,"subject");
            $rec->data['category']=$db->FetchResult($result,0,"category");
            $rec->data['short_description']=$db->FetchResult($result,0,"short_description");
            $rec->data['description']=$db->FetchResult($result,0,"description");
            $rec->data['photo_small']=$db->FetchResult($result,0,"photo_small");
            $rec->data['photo1']=$db->FetchResult($result,0,"photo1");
            $rec->data['photo2']=$db->FetchResult($result,0,"photo2");
            $rec->data['photo3']=$db->FetchResult($result,0,"photo3");
            $rec->data['photo4']=$db->FetchResult($result,0,"photo4");
            $rec->data['photo5']=$db->FetchResult($result,0,"photo5");
            $rec->data['photo6']=$db->FetchResult($result,0,"photo6");
            $rec->data['photo7']=$db->FetchResult($result,0,"photo7");
            $rec->data['photo8']=$db->FetchResult($result,0,"photo8");
            
            // przynale¿nosæ do grup
            $rec->data['group1']=$db->FetchResult($result,0,"group1");
            $rec->data['group2']=$db->FetchResult($result,0,"group2");
            $rec->data['group3']=$db->FetchResult($result,0,"group3");
            
            $rec->data['id_newsedit_groups']=$db->FetchResult($result,0,"id_newsedit_groups");
        } else {
            $theme->go2main();
        }
    } else die ($db->Error());
} else die ($db->Error());

// odczytaj wzorzec dla danego rodzaju newsa (grupy)
$template_info=$mdbd->select("template_info","newsedit_groups","id=?",
array($rec->data['id_newsedit_groups']=>"int","LIMIT 1"));

$theme->head();

// naglowek
$theme->theme_file("page_open_1_head.html.php");

// wyswietl newsa
require_once ("plugins/_newsedit/themes/theme.inc.php");
if (! empty($template_info)) {
    NewsEditTheme::newsedit($rec,"newsedit_info_$template_info.html.php");
} else {
    NewsEditTheme::newsedit($rec,"newsedit_info.html.php");
}

$theme->theme_file("page_open_1_foot.html.php");
$theme->foot();

include_once ("include/foot.inc");
?>
