<?php
/**
* Konfiguracja systemu newsletter. Formularz + obs³uga.
* 
* Konfiguracja systemu newsletter jest generowana w pliku config/newsletter_config.inc.php
*
* @author  rdiak@sote.pl
* @version $Id: config.php,v 2.9 2006/07/17 12:20:27 lukasz Exp $
*
* verified 2004-03-09 m@sote.pl
* @package    newsletter
* @subpackage users
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu.
*/
require_once ("../../../../include/head.inc");
$choose_lang=@$_REQUEST['item']['choose_lang'];
if (empty($choose_lang) && $_REQUEST['item']['choose_lang']!=='0') {
	if ($config->admin_lang=='pl') $choose_lang=0;
		else $choose_lang=1;
}
	if ($choose_lang==0){
		require_once("./include/gen_newsletter_config_L0.inc.php");
	}elseif ($choose_lang==1){
		require_once("./include/gen_newsletter_config_L1.inc.php");
	}elseif ($choose_lang==2){
		require_once("./include/gen_newsletter_config_L2.inc.php");
	}elseif ($choose_lang==3){
		require_once("./include/gen_newsletter_config_L3.inc.php");
	}if ($choose_lang==4){
		require_once("./include/gen_newsletter_config_L4.inc.php");
	}



// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("../include/menu.inc.php");
$theme->bar($lang->newsletter_config_bar);

if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();

if ($choose_lang==0){
	require_once("config/auto_config/newsletter/newsletter_config_L0.inc.php");
	if (! empty($item['save'])) {
		    $ftp->connect();    
		    $gen_config->gen(array(
		                           "newsletter_group"=>$item['group'],
		                           "newsletter_sender"=>$item['sender'],
		                           "newsletter_head"=>$item['head'],
		                           "newsletter_info_add"=>$item['info_add'],
		                           "newsletter_info_del"=>$item['info_del'],
		                           "newsletter_foot_add"=>$item['foot_add'],
		                           "newsletter_foot_del"=>$item['foot_del'],
		                           "newsletter_foot"=>$item['foot'],
		                           )
		                     );
		    $ftp->close();
		    $config_newsletter->newsletter_group=$item['group'];
		    $config_newsletter->newsletter_sender=$item['sender'];
		    $config_newsletter->newsletter_head=$item['head'];
		    $config_newsletter->newsletter_info_add=$item['info_add'];
		    $config_newsletter->newsletter_info_del=$item['info_del'];
		    $config_newsletter->newsletter_foot_add=$item['foot_add'];
		    $config_newsletter->newsletter_foot_del=$item['foot_del'];
		    $config_newsletter->newsletter_foot=$item['foot'];
		}
}
if ($choose_lang==1){
	require_once("config/auto_config/newsletter/newsletter_config_L1.inc.php");
	if (! empty($item['save'])) {
		    $ftp->connect();    
		    $gen_config->gen(array(
		                           "newsletter_group"=>$item['group'],
		                           "newsletter_sender"=>$item['sender'],
		                           "newsletter_head"=>$item['head'],
		                           "newsletter_info_add"=>$item['info_add'],
		                           "newsletter_info_del"=>$item['info_del'],
		                           "newsletter_foot_add"=>$item['foot_add'],
		                           "newsletter_foot_del"=>$item['foot_del'],
		                           "newsletter_foot"=>$item['foot'],
		                           )
		                     );
		    $ftp->close();
		    $config_newsletter->newsletter_group=$item['group'];
		    $config_newsletter->newsletter_sender=$item['sender'];
		    $config_newsletter->newsletter_head=$item['head'];
		    $config_newsletter->newsletter_info_add=$item['info_add'];
		    $config_newsletter->newsletter_info_del=$item['info_del'];
		    $config_newsletter->newsletter_foot_add=$item['foot_add'];
		    $config_newsletter->newsletter_foot_del=$item['foot_del'];
		    $config_newsletter->newsletter_foot=$item['foot'];
		}
}
if ($choose_lang==2){
	require_once("config/auto_config/newsletter/newsletter_config_L2.inc.php");
	if (! empty($item['save'])) {
		    $ftp->connect();    
		    $gen_config->gen(array(
		                           "newsletter_group"=>$item['group'],
		                           "newsletter_sender"=>$item['sender'],
		                           "newsletter_head"=>$item['head'],
		                           "newsletter_info_add"=>$item['info_add'],
		                           "newsletter_info_del"=>$item['info_del'],
		                           "newsletter_foot_add"=>$item['foot_add'],
		                           "newsletter_foot_del"=>$item['foot_del'],
		                           "newsletter_foot"=>$item['foot'],
		                           )
		                     );
		    $ftp->close();
		    $config_newsletter->newsletter_group=$item['group'];
		    $config_newsletter->newsletter_sender=$item['sender'];
		    $config_newsletter->newsletter_head=$item['head'];
		    $config_newsletter->newsletter_info_add=$item['info_add'];
		    $config_newsletter->newsletter_info_del=$item['info_del'];
		    $config_newsletter->newsletter_foot_add=$item['foot_add'];
		    $config_newsletter->newsletter_foot_del=$item['foot_del'];
		    $config_newsletter->newsletter_foot=$item['foot'];
		}
}
if ($choose_lang==3){
	require_once("config/auto_config/newsletter/newsletter_config_L3.inc.php");
	if (! empty($item['save'])) {
		    $ftp->connect();    
		    $gen_config->gen(array(
		                           "newsletter_group"=>$item['group'],
		                           "newsletter_sender"=>$item['sender'],
		                           "newsletter_head"=>$item['head'],
		                           "newsletter_info_add"=>$item['info_add'],
		                           "newsletter_info_del"=>$item['info_del'],
		                           "newsletter_foot_add"=>$item['foot_add'],
		                           "newsletter_foot_del"=>$item['foot_del'],
		                           "newsletter_foot"=>$item['foot'],
		                           )
		                     );
		    $ftp->close();
		    $config_newsletter->newsletter_group=$item['group'];
		    $config_newsletter->newsletter_sender=$item['sender'];
		    $config_newsletter->newsletter_head=$item['head'];
		    $config_newsletter->newsletter_info_add=$item['info_add'];
		    $config_newsletter->newsletter_info_del=$item['info_del'];
		    $config_newsletter->newsletter_foot_add=$item['foot_add'];
		    $config_newsletter->newsletter_foot_del=$item['foot_del'];
		    $config_newsletter->newsletter_foot=$item['foot'];
		}
}
if ($choose_lang==4){
	require_once("config/auto_config/newsletter/newsletter_config_L4.inc.php");
	if (! empty($item['save'])) {
		    $ftp->connect();    
		    $gen_config->gen(array(
		                           "newsletter_group"=>$item['group'],
		                           "newsletter_sender"=>$item['sender'],
		                           "newsletter_head"=>$item['head'],
		                           "newsletter_info_add"=>$item['info_add'],
		                           "newsletter_info_del"=>$item['info_del'],
		                           "newsletter_foot_add"=>$item['foot_add'],
		                           "newsletter_foot_del"=>$item['foot_del'],
		                           "newsletter_foot"=>$item['foot'],
		                           )
		                     );
		    $ftp->close();
		    $config_newsletter->newsletter_group=$item['group'];
		    $config_newsletter->newsletter_sender=$item['sender'];
		    $config_newsletter->newsletter_head=$item['head'];
		    $config_newsletter->newsletter_info_add=$item['info_add'];
		    $config_newsletter->newsletter_info_del=$item['info_del'];
		    $config_newsletter->newsletter_foot_add=$item['foot_add'];
		    $config_newsletter->newsletter_foot_del=$item['foot_del'];
		    $config_newsletter->newsletter_foot=$item['foot'];
		}
}


if ($choose_lang==0){
require_once ("./html/newsletter_config_L0.html.php");
} elseif ($choose_lang==1){
require_once ("./html/newsletter_config_L1.html.php");
} elseif ($choose_lang==2){
require_once ("./html/newsletter_config_L2.html.php");
} elseif ($choose_lang==3){
require_once ("./html/newsletter_config_L3.html.php");
} if ($choose_lang==4){
require_once ("./html/newsletter_config_L4.html.php");
}


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
