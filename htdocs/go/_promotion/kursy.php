<?php
/**
*
* @author  m@sote.pl
* @version $Id: index.php,v 2.4 2005/01/20 15:00:18 maroslaw Exp $
* @package    promotion
*/
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

$theme->head();

?>

<center>
<table width="770" cellspacing="0" cellpadding="0" border="0" align="center">
<tr>
    <td width="770" valign="top" align="left"><h1>
    Tutaj znajdziecie Pañstwo kursy i szkolenia organizowane przez firmê Mikran oraz partnerów.</h1><h2>Je¶li jeste¶cie Pañstwo zainteresowani którym¶ ze szkoleñ z listy prosimy o kontakt telefoniczny +48 61 847 58 58 lub mailowo na sklep@mikran.pl
<br/>
</td>  
</tr>
<tr>
    <td width="770" valign="top" align="left">
<hr/>
<ul style="list-style-type:none;">

<li><h1>Kursy organizowane przez Ivoclar-Vivadent Polska 2014</h1>
<a href="/photo/_pdf/ivoclar/kursy2014.pdf">Pobierz szczegó³owe informacje w PDF : <img width="100px" src="/photo/_pdf/pdf.jpg"></a>
</li>
<li><hr/></li>

<!---
<li id="dreve2012"><h1>Szkolenie Mikran + Dreve 2012</h1>
<h3>
<a href="http://www.facebook.com/media/set/?set=a.10150966849091911.397824.81284091910&type=1">http://www.facebook.com/media/set/?set=a.10150966849091911.397824.81284091910&type=1</a></h3>
<?php

$contents = json_decode(file_get_contents("https://graph.facebook.com/10150966849091911/photos?limit=150"),true);

foreach ($contents['data'] as $key => $value) {
$gif = $contents['data'][$key]['images'][6]['source'];
echo '<a href="http://www.facebook.com/media/set/?set=a.10150966849091911.397824.81284091910&type=1"><img src="'.$gif.'" alt="Dreve Training 2012 at mikran.pl"/ style="padding:3px"></a>';

}

?>
-->
</ul>
    </td>
  </tr>
</table>
