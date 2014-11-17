<?php
/**
* Zmien jezyk sklepu.
* @version    $Id: index.php,v 2.5 2005/03/14 14:13:12 lechu Exp $
* @package    lang
* \@lang
*/

$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");


if (isset($_REQUEST['lang_id'])) {
    // nazwa nowego jezyka
    $lang_id=$_REQUEST['lang_id'];
    
    if ($config->langs_active[$lang_id] == 1) {
        // wskazany jezyk istnieje, zapisz jego nazwe w sesji
        $lang_name = $config->langs_symbols[$lang_id];
        $global_lang_id=$lang_id;
        $global_lang=&$lang_name;
        $global_lang_id=$lang_id;
        $sess->register("global_lang",$global_lang);        
        $sess->register("global_lang_id",$global_lang_id);        
        $__currency=$config->currency_lang_default[$global_lang];                        
        $sess->register("__currency",$__currency);                    
    } else {
        $theme->go2main();
        exit;
    }
} else {
    $theme->go2main();
    exit;
}

$theme->go2main();

include_once ("include/foot.inc");
?>
