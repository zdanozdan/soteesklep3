<?php
/**
 * PHP Template:
 * Eksportowanie danych z tabeli discounts do pliku config/tmp/discounts.inc.php
 *
 * @author pm@sote.pl
 * \@template_version Id: index.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: options.php,v 2.3 2005/01/20 14:59:50 maroslaw Exp $
* @package    discounts
 */

$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

if (! empty($_POST['item'])) {
    $item=$_POST['item'];
} else $item=array();

// naglowek
$theme->head();
$theme->page_open_head();

include("include/menu.inc.php");
$theme->bar($lang->discounts_options_bar);

require_once ("include/form_check.inc");
$form_check = new FormCheck;
$theme->form_check=&$form_check;   

$form_check->form=$item;
$form_check->errors=$lang->discounts_options_form_errors;
$form_check->fun=array("default_discount"=>"string");
                      
print "$lang->discounts_options_info<P>\n";

if (! empty($_POST['update'])) {
    $form_check->check=true;
    if ($form_check->form_test()) {
        $new_default_discount=$item['default_discount'];         
        // generuj plik konfiguracyjny
        require_once ("./include/gen_config.inc.php");
        $comm=$gen_config->gen(array("default_discount"=>$new_default_discount));
        if ($comm==0) {
            print "<p><center>$lang->discounts_default_discount_ok</center>";
        }
    } else {
        include_once ("./html/options.html.php");    
    }
} else {
    include_once ("./html/options.html.php");  
}

$theme->page_open_foot();
// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
