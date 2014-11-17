<?php
/**
 * Edycja danych grupy newsletter.
 *
* @author  rdiak@sote.pl
* @version $Id: add.php,v 2.8 2005/01/20 14:59:58 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu.
*/
require_once ("../../../../include/head.inc");
require_once ("include/metabase.inc");

$max_id=$database->sql_select("max(user_id)","newsletter_groups");

$theme->head_window();
$theme->bar($lang->newsletter_groups_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;
$mod_table->add("newsletter_groups","newsletter",array(
                                            "user_id"=>"int",
                                            "name"=>"string"
                                            ),
                   $lang->newsletter_form_errors
                   );

$theme->foot_window();

include_once ("include/foot.inc");
?>
