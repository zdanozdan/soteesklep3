<?php
/**
* Stopka strony dla google
* 
* @author  m@sote.pl
* @version $Id: foot.html.php,v 1.1 2005/08/08 14:16:04 maroslaw Exp $
* @package    themes
* @subpackage google
*/
global $__class,$google_config;

?>
<hr />

<div align="left">
<img src="/themes/base/google/_img/prev_g.png" alt="previous" border="0">
<a href="/html/index.html"><img src="/themes/base/google/_img/next.png" alt="next" border="0"></a>
<a href="/"><img src="/themes/base/google/_img/contents.png" alt="contents" border="0"></a>
</div>

<a href="http://www.googi.pl">pozycjonowanie</a> GooGi.pl, oprogramowanie SOTE: <a href="http://www.sote.pl">sklepy internetowe</a>
<hr />

<p><img border="0" 
src="/themes/base/google/_img/valid-html40.png"
alt="Valid HTML 4.01!" height="31" width="88"></p>

<?php
if (! empty($__class)) {
    if (! empty($google_config->sentences[2])) $sentence=$google_config->sentences[2]; 
    elseif (! empty($google_config->sentences[1])) $sentence=$google_config->sentences[1]; 
    elseif (! empty($google_config->sentences[0])) $sentence=$google_config->sentences[0]; 
    else $sentence=$google_config->keyword_plain;
    
    print "<h1><span class=\"$__class\">$sentence</span></h1>\n";
}
?>

</body>
</html>