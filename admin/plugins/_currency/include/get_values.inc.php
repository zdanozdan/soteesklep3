<?php
/**
* Klasa i funkcje obslujace dane XML udostepniane przez NBP.
* 
* @author Artiun
* @version $Id: get_values.inc.php,v 2.5 2004/12/20 17:59:31 maroslaw Exp $
* @package    currency
*/

/** Klasy i funkcje do parsowania XMLa 
*	@package currency
*/
class KursyWalut
{
    function KursyWalut ($aa)
    {
        foreach ($aa as $k=>$v) $this->$k = $aa[$k];
    }
}

function readKursyWalut($data)
{
    $parser = xml_parser_create();
    xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
    xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
    xml_parse_into_struct($parser,$data,$values,$tags);
    xml_parser_free($parser);
    
    foreach ($tags as $key=>$val)
    {
        if ($key == "pozycja")
        {
            $pozranges = $val;
            for ($i=0; $i<count($pozranges); $i+=2)
            {
                $offset = $pozranges[$i] + 1;
                $len = $pozranges[$i + 1] - $offset;
                $tdb[] = parseKurs(array_slice($values, $offset, $len));
            }
        }
        else
        {
            continue;
        }
    } return $tdb;
}

function parseKurs($aVal)
{
    for ($i=0; $i<count($aVal); $i++)
    $poz[$aVal[$i]["tag"]] = $aVal[$i]["value"];
    return new KursyWalut($poz);
}

// Odczyt nazwy pliku XML
$link_kurs = "http://www.nbp.pl/Kursy/KursyA.html";
$link_plik = fopen($link_kurs, "r");
while (!feof($link_plik))
@$string_tmp .=  fgets($link_plik, 4096);
fclose($link_plik);

// Wyciagniecie linku do pliku XML
$ereg = "/<a href=\"xml\/(.*)\">powy¿sza tabela w formacie .xml<\/a>/i";
preg_match($ereg,$string_tmp,$URL);
$link_xml = $URL[1];

// Odczyt pliku XML
$plik_xml = fopen("http://www.nbp.pl/Kursy/xml/".$link_xml, "r");
while (!feof($plik_xml))
@$string_tmp_xml .=  fgets($plik_xml, 4096);
fclose($plik_xml);

$Kursy = readKursyWalut($string_tmp_xml);
$walut = count($Kursy);

/* Szablon wyswietlania kursow */
include_once("./html/nbp.html.php");

unset($aWaluty);
unset($Kursy);
?>
