<?php
/**
* Zmien jezyk sklepu.
* @version    $Id: index.php,v 2.5 2005/03/14 14:13:12 lechu Exp $
* @package    lang
* \@lang
*/

$global_database=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

if (isset($_REQUEST['lang_id'])) {
    // nazwa nowego jezyka
    $lang_id=$_REQUEST['lang_id'];
    //if ($config->langs_active[$lang_id] == 1) {
        // wskazany jezyk istnieje, zapisz jego nazwe w sesji
        $lang_name = $config->langs_symbols[$lang_id];
        $global_lang_id=$lang_id;
        $global_lang=&$lang_name;
        $global_lang_id=$lang_id;
        $sess->register("global_lang",$global_lang);        
        $sess->register("global_lang_id",$global_lang_id);  
	$_SESSION["global_lang"] = $global_lang;
	$_SESSION["global_lang_id"] = $global_lang_id;
        $__currency=$config->currency_lang_default[$global_lang];                        
        $sess->register("__currency",$__currency);    
	$_SESSION["__currency"] = $__currency;
	//} else {
        //$theme->go2main();
        //exit;
	//}
} else {
  header('Location:'.$_SERVER['HTTP_REFERER']);
  $theme->go2main();
  exit;
}

//tutaj sprawdz gdzie przekierwoac
//1) strona produktu
//2) strona kategorii
//3) reszta 

//print_r($_SERVER);
//exit();

$regex = "/([a-z]{1,2})/id[0-9]+/";
if (ereg($regex,$_SERVER['HTTP_REFERER'],$regs))
  {
    $url_lang = $regs[1];
    if ($config->lang_active[$url_lang])
      {
	$new_url = str_replace('/'.$url_lang.'/','/'.$global_lang.'/',$_SERVER['HTTP_REFERER']);
	Header( "HTTP/1.1 301 Moved Permanently" );
	Header( "Location: $new_url" );
	exit();
      }
  }

//kategorie tez musimy przekierowac na nowy jezyk
$regex = "/([a-z]{1,2})/idc/";
if (ereg($regex,$_SERVER['HTTP_REFERER'],$regs))
  {
    $url_lang = $regs[1];
    if ($config->lang_active[$url_lang])
      {
	$new_url = str_replace('/'.$url_lang.'/','/'.$global_lang.'/',$_SERVER['HTTP_REFERER']);
	Header( "HTTP/1.1 301 Moved Permanently" );
	Header( "Location: $new_url" );
	exit();
      }
  }

Header( "HTTP/1.1 301 Moved Permanently" );
Header('Location:'.$_SERVER['HTTP_REFERER']);
$theme->go2main();

include_once ("include/foot.inc");
?>
