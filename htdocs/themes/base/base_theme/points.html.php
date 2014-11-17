<?php
/**
* @version    $Id: points.html.php,v 1.1 2006/09/27 21:53:22 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
$points=$vars['points'];
global $theme;
// Rabaty
global $config,$discounts_config;
global $_SESSION;
?>

<?php

print "<table align=center cellspacing=4 cellpadding=4>\n";
print "<tr>\n";
print "<td valign=top>\n";

$this->file("points.html","");
?>

<table align=center>
<tr>
<td bgcolor=<?php print $theme->bg_bar_color_light;?>><?php print $lang->users_your_points;?></td>
<td align=center><b><?php print $points;?></b></td>
</tr>


<?php

if (in_array("discounts",$config->plugins)) {
    global $DOCUMENT_ROOT;                        
    $filed="$DOCUMENT_ROOT/../config/auto_config/discounts/".@$_SESSION['__id_discounts_groups']."_discounts_config.inc.php";
    if ((! empty($_SESSION['__id_discounts_groups'])) && (file_exists($filed))) {
        @include_once ($filed);   
    }

    if (! empty($_SESSION['__id_discounts_groups'])) {          

        // start pokaz grupe klienta:, jesli grupa ma public=1 w tabeli discounts_groups
        if ($discounts_config->discounts_groups_public[$_SESSION['__id_discounts_groups']]==1) {
            print "<tr>\n";
            print "<td>$lang->users_group:</td><td><b>".$discounts_config->discounts_groups[$_SESSION['__id_discounts_groups']]."</b></td>\n";
            print "</tr>\n";
        
        // end pokaz grupe klienta:

        if ($discounts_config->default_discounts[$_SESSION['__id_discounts_groups']]>0) {
            print "<tr>\n";
            print "<td>$lang->users_discount:</td><td><b>".$discounts_config->default_discounts[$_SESSION['__id_discounts_groups']]." %</b></td>\n";
            print "</tr>";
        }
        }
    }
}

// end
?>

</table>

</td>
<td valign=top>

<?php
// pokaz grafike zwiazana z grupa rabatowa
// start pokaz grupe klienta:, jesli grupa ma public=1 w tabeli discounts_groups
if (@$discounts_config->discounts_groups_public[@$_SESSION['__id_discounts_groups']]==1) {
    require_once ("include/metabase.inc");
    $photo=$database->sql_select("photo","discounts_groups","user_id=".$_SESSION['__id_discounts_groups']);
    if (! empty($photo)) {
        $file="$DOCUMENT_ROOT/photo/_discounts_groups/$photo";
        if (file_exists($file)) {
            print "<center><img src=/photo/_discounts_groups/$photo></center>\n";
        }
    }
}
?>

</td>
</tr>
</table>
