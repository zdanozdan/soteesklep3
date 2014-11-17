<?php
/**
 * Menu
 * 
 * @author  m@sote.pl
 * \@template_version Id: menu.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: menu.inc.php,v 1.3 2004/12/20 17:59:57 maroslaw Exp $
* @package    main_keys
* @subpackage main_keys_ftp
 */

include_once ("../lang/_$config->lang/lang.inc.php");
include_once ("../include/menu_top.inc.php");
 
print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"..",
                             $lang->main_keys_ftp_menu["add"]=>"add.php onclick=\"open_window(450,200)\" target=window",
                             $lang->main_keys_ftp_menu["list"]=>"index.php",                            
                             // $lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );
print "</div>";
?>
