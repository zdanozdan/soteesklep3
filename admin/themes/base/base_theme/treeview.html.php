<?php 
/**
 * Obsluga dynamicznego Menu treeview
 *
 * \@session int    $__producer_filter      id producenta - filtr kategorii
 *
 * @author  m@sote.pl (PHP code)
 * @version $Id: treeview.html.php,v 1.3 2005/04/28 13:05:05 lechu Exp $
* @package    themes
* @subpackage base_theme
 */
?>

<!-- SECTION Treeview -->
<!--
     (Please keep all copyright notices.)
     This frameset document includes the Treeview script.
     Script found at: http://www.treeview.net
     Author: Marcelino Alves Martins

     Instructions:
     - Follow the steps labeled SECTION1, SECTION2, etc. in this file
-->



<!-- SECTION 2: Replace everything (HTML, JavaScript, etc.) from here until the beginning 
of SECTION 3 with the pieces of the head section that are needed for your site  -->

		<script>
		//This script is not related with the tree itself, just used for my example
		function getQueryString(index)
		{
			var paramExpressions;
			var param
			var val
			paramExpressions = window.location.search.substr(1).split("&");
			if (index < paramExpressions.length)
			{
				param = paramExpressions[index]; 
				if (param.length > 0) {
					return eval(unescape(param));
				}
			}
			return ""
		}
		</script>

<!-- SECTION 3: These four scripts define the tree, do not remove-->
<script src="<?php print $config->url_prefix;?>/lib/Treeview/ua.js"></script>
<script src="<?php print $config->url_prefix;?>/lib/Treeview/ftiens4.js"></script>
<script language=JavaScript>
<?php
// zaladuj dane kategorii do menu wg. akrualnego jezyka
// jesli nie ma danych o kategoriach w aktualnym jezyku, szukaj danych dla glownego jezyka
require_once ("include/treeview.inc");
$ctreeview = new CategoryTreeview;

global $DOCUMENT_ROOT;
global $_REQUEST;
global $_SESSION;
global $__producer_filter,$producer_filter_name;
global $sess;      

// odczytaj kategorie dla danego producenta
if (ereg("^[0-9]+$",@$_REQUEST['producer_filter'])) {
    $__producer_filter=$_REQUEST['producer_filter'];
    $sess->unregister("__producer_filter");
} elseif (ereg("^[0-9]+$",@$_SESSION['__producer_filter'])) {
    $__producer_filter=$_SESSION['__producer_filter'];
} else {
    $__producer_filter='';
}

if (! empty($__producer_filter)) {
    $file="$DOCUMENT_ROOT/lib/Treeview/data/producers/$config->lang"."_".$__producer_filter."_treeview.js";
    // jesli nie ma kategorii dla producenta to odzytaj glowne kategorie
    if (! file_exists($file)) {
        $file="$DOCUMENT_ROOT/lib/Treeview/data/$config->lang"."_treeview.js";
    } else {
        $sess->register("__producer_filter",$__producer_filter);
    }
} else {
    $file="$DOCUMENT_ROOT/lib/Treeview/data/$config->lang"."_treeview.js"; 
    $sess->register("__producer_filter",$__producer_filter);  
}


if (file_exists($file)) {
    $ctreeview->js_show_data_with_session($file);
} else {
    $file="$DOCUMENT_ROOT/lib/Treeview/data/$config->base_lang"."_treeview.js";
    $ctreeview->js_show_data_with_session($file);
}
?>
</script>

</head>


<!-- SECTION 4: Change the body tag to fit your site -->
<body bgcolor=white leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" onResize="if (navigator.family == 'nn4') window.location.reload()">


<!-- SECTION 6: Build the tree. -->

<!-- By making any changes to this code you are violating your user agreement.
     Corporate users or any others that want to remove the link should check 
	 the online FAQ for instructions on how to obtain a version without the link -->
<!-- Removing this link will make the script stop from working -->
<!-- Removed - library purchased. -->

<script>initializeDocument()</script>
<noscript>
<?php
     include_once ("include/category.inc");
?>
</noscript>


<!-- SECTION 7: Continuation of the body of the page, after the tree. Replace whole section with 
your site's HTML. -->



<!-- END SECTION Treeview -->
