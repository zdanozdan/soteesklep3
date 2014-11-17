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
                '0'=>"materia³y protetyczne dla pracowni protetycznych i techników dentystycznych",
                '1'=>"materia³y dla lekarzy stomatologów",
                '2'=>"materia³y ortodontyczne",
                );
	var $description="Materia³y do ortodoncji, profilaktyki, wype³nieñ,dezynfekcji, sterylizacji,ochrony, uzupe³nieñ modelowania i obróbki.";
	var $title="mikran.pl - sklep. Najwiêkszy wybór materia³ów do stomatologii, protetyki, ortodoncji. Sprawd¼ nas !";
	var $logo="mikran_logo.jpg";

} // end class GoogleConfig
$google_config = new GoogleConfig;
?>