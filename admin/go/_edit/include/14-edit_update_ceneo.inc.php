<?php
/**
* Aktualizuj w baze wartosc pola zwi±zane z ceneoPasa¿
*
* @author  rdiak@sote.pl
* @version $Id: edit_update_ceneo.inc.php,v 2.1 2006/01/06 12:58:47 scalak Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

if ($global_secure_test!=true) {
	die ("Forbidden");
}

require_once("include/metabase.inc");
global $database;
global $mdbd;

//print_r($datat);

// pobieramy z tablicy main user_id produktu 
$user_id=$mdbd->select("user_id","main","id=?",array($id=>"int"));

// sprawdzamy czy rekord juz istnieje w bazie
$count=$mdbd->select("count(*)","main_param","user_id=?",array($user_id=>"string"));

// odczytaj dane z formularza
if (! empty($_REQUEST['item'])) {
	$item=&$_REQUEST['item'];
} else {
	die ("Forbidden: Unknown item");
}

if($count == 0) {
	$database->sql_insert("main_param",array(
							    'user_id'=>$user_id,
							    'ceneo_export'=>@$item['ceneo_export'],
							    'ceneo_attrib'=>@$item['ceneo_attrib'],
                                'ceneo_autor'=>@$item['ceneo_autor'],
                                'ceneo_isbn'=>@$item['ceneo_isbn'],
                                'ceneo_page'=>@$item['ceneo_page'],
                                'ceneo_publisher'=>@$item['ceneo_publisher'],
                                'ceneo_producer'=>@$item['ceneo_producer'],
                                'ceneo_size'=>@$item['ceneo_size'],
                                'ceneo_rozstaw'=>@$item['ceneo_rozstaw'],
                                'ceneo_odsadzenie'=>@$item['ceneo_odsadzenie'],
                                'ceneo_rezyser'=>@$item['ceneo_rezyser'],
                                'ceneo_obsada'=>@$item['ceneo_obsada'],
                                'ceneo_nosnik'=>@$item['ceneo_nosnik'],
                                'ceneo_tytul_org'=>@$item['ceneo_tytul_org'],
                                'ceneo_opony_producent'=>@$item['ceneo_opony_producent'],
                                'ceneo_opony_model'=>@$item['ceneo_opony_model'],
                                'ceneo_opony_szerokosc'=>@$item['ceneo_opony_szerokosc'],
                                'ceneo_opony_profil'=>@$item['ceneo_opony_profil'],
                                'ceneo_opony_srednica'=>@$item['ceneo_opony_srednica'],
                                'ceneo_opony_predkosc'=>@$item['ceneo_opony_predkosc'],
                                'ceneo_opony_nosnosc'=>@$item['ceneo_opony_nosnosc'],
                                'ceneo_opony_sezon'=>@$item['ceneo_opony_sezon'],
                                'ceneo_opony_typ'=>@$item['ceneo_opony_typ'],
                                'ceneo_perfumy_producent'=>@$item['ceneo_perfumy_producent'],
                                'ceneo_perfumy_model'=>@$item['ceneo_perfumy_model'],
                                'ceneo_perfumy_rodzaj'=>@$item['ceneo_perfumy_rodzaj'],
                                'ceneo_perfumy_pojemnosc'=>@$item['ceneo_perfumy_pojemnosc']
                                
							    ));

} else {
	$database->sql_update("main_param","user_id=$user_id",
								array(
							    "ceneo_export"=>@$item['ceneo_export'],
							    "ceneo_attrib"=>@$item['ceneo_attrib'],
                                "ceneo_autor"=>@$item['ceneo_autor'],
                                "ceneo_isbn"=>@$item['ceneo_isbn'],
                                "ceneo_page"=>@$item['ceneo_page'],
                                "ceneo_publisher"=>@$item['ceneo_publisher'],
                                "ceneo_producer"=>@$item['ceneo_producer'],
                                "ceneo_size"=>@$item['ceneo_size'],
                                "ceneo_rozstaw"=>@$item['ceneo_rozstaw'],
                                "ceneo_odsadzenie"=>@$item['ceneo_odsadzenie'],
                                'ceneo_rezyser'=>@$item['ceneo_rezyser'],
                                'ceneo_obsada'=>@$item['ceneo_obsada'],
                                'ceneo_nosnik'=>@$item['ceneo_nosnik'],
                                'ceneo_tytul_org'=>@$item['ceneo_tytul_org'],
                                'ceneo_opony_producent'=>@$item['ceneo_opony_producent'],
                                'ceneo_opony_model'=>@$item['ceneo_opony_model'],
                                'ceneo_opony_szerokosc'=>@$item['ceneo_opony_szerokosc'],
                                'ceneo_opony_profil'=>@$item['ceneo_opony_profil'],
                                'ceneo_opony_srednica'=>@$item['ceneo_opony_srednica'],
                                'ceneo_opony_predkosc'=>@$item['ceneo_opony_predkosc'],
                                'ceneo_opony_nosnosc'=>@$item['ceneo_opony_nosnosc'],
                                'ceneo_opony_sezon'=>@$item['ceneo_opony_sezon'],
                                'ceneo_opony_typ'=>@$item['ceneo_opony_typ'],
                                'ceneo_perfumy_producent'=>@$item['ceneo_perfumy_producent'],
                                'ceneo_perfumy_model'=>@$item['ceneo_perfumy_model'],
                                'ceneo_perfumy_rodzaj'=>@$item['ceneo_perfumy_rodzaj'],
                                'ceneo_perfumy_pojemnosc'=>@$item['ceneo_perfumy_pojemnosc']
							    ));
}
// zaakutalizuj informacje o tym czy produkt jest eksportowany w glownej tablicy produktow
$database->sql_update("main","user_id=$user_id",array("ceneo_export"=>@$item['ceneo_export']));
?>
