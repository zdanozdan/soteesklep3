<?php


class GoogleConfig {
	var $http_user_agents=array(
                '0'=>"HTTP_Request",
                '1'=>"Google",
                '2'=>"Wget",
                '3'=>"W3C_Validator",
                '4'=>"phpSitemapNG",
                '5'=>"yahoo",
                '6'=>"Yahoo",
                '7'=>"Slurp",
                '8'=>"Inktomi",
                '9'=>"MSNBOT",
                '10'=>"MSN",
                '11'=>"msn",
                '12'=>"msnbot",
                '13'=>"Holmes",
                '14'=>"Szukacz",
                '15'=>"NetSprint",
                '16'=>"Ask",
                '17'=>"onet",
                );
	var $keywords=array(
                '0'=>"protetyka",
                '1'=>"stomatologia",
                '2'=>"ortodoncja",
                );
	var $keyword_plain="protetyka";
	var $sentences=array(
                '0'=>"materia�y protetyczne dla pracowni protetycznych i technik�w dentystycznych",
                '1'=>"materia�y dla lekarzy stomatolog�w",
                '2'=>"materia�y ortodontyczne",
                );
	var $description="Materia�y do ortodoncji, profilaktyki, wype�nie�,dezynfekcji, sterylizacji,ochrony, uzupe�nie� modelowania i obr�bki.";
	var $title="mikran.pl - sklep. Najwi�kszy wyb�r materia��w do stomatologii, protetyki, ortodoncji. Sprawd� nas !";
	var $logo="mikran_logo.jpg";

} // end class GoogleConfig
$google_config = new GoogleConfig;
?>