<?php
/**
* @version    $Id: error.html.php,v 1.1 2007/11/29 14:12:24 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
header("HTTP/1.0 404 Not Found");
?>
   <HTML>
	<HEAD><TITLE>Page Not Found</TITLE></HEAD>
	<BODY BGCOLOR="#FFFFFF" LINK="maroon" VLINK="maroon" ALINK="maroon">
	<CENTER>
	<TABLE WIDTH="85%" BORDER="1" BORDERCOLOR="#000000" CELLSPACING="0" CELLPADDING="3">
	<TR>
	<TD>
		<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">

		<TR>
   <td><img alt="" src='<?php $this->img("error404.jpg"); ?>' border="0"></td>
			<TD ALIGN="CENTER"><H2 STYLE="font-family: arial, sans-serif">Nie znaleziono ��danej strony</H2></TD>
		</TR>
		</TABLE>
	</TD>
	</TR>
	<TR>

	<TD>
 <P STYLE="margin-left: 10px; margin-right: 10px; margin-top: 10px; margin-bottom: 10px; font-size: 10pt; font-family: arial, sans-serif">
        Strona kt�r� pr�bujesz otworzy� nie istnieje na serwerze. Mo�e by� to spowodowane przez:
	<OL>
        <P>
	<LI STYLE="font-size: 10pt; font-family: arial, sans-serif"><STRONG>Produkt kt�rego szukasz zmieni� nazw� lub zosta� wycofany.</STRONG> Skorzystaj z wyszukiwarki po lewej stronie i spr�buj wyszuka� produkt ponownie. Prosimy o kontakt je�li nie mo�esz znale�� produktu.
	<P>
	<LI STYLE="font-size: 10pt; font-family: arial, sans-serif"><STRONG>Adres URL kt�ry wpisa�e� w przegl�darce jest nieprawid�owy.</STRONG> Sprawd� adres i spr�buj ponownie.
	</OL>
	</TD>
	</TR>
	</TABLE>
	</BODY>
<HTML>
