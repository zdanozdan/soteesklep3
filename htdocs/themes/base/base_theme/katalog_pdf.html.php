<?php
/**
* @version    $Id: page_open.html.php,v 1.2 2007/03/20 13:36:06 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<?
$page = 0;
if (! empty($_REQUEST['page'])) {
    $page=$_REQUEST['page'];
}
//if(!preg_match($page,'[0-9]+')) die('xxx');

?>

<center>
<!-- BEGIN SUPER TABLE -->
<table width="770" cellspacing="0" cellpadding="0" border="0" align="center">
<tr><td>

  <table width="580" cellspacing="0" cellpadding="0" border="0" align="right" >
    <tr> 
      <td valign="top"> 
<?php
echo '<div class="head_1">';
echo $lang->bar_title["katalog"];
echo '</div>';
?>

<div id="block_1">

<h3>Szanowni Pañstwo, </h3>
<h2>Zapraszamy do korzystania z naszego katalogu wysy³kowego. <span style="color:red">Ka¿dy produkt w katalogu posiada swój unikalny kod a wpisanie go do wyszukiwarki na naszej stronie spowoduje podanie aktualnej ceny i dostêpno¶ci towaru. </span>Jest to prawdopodobnie pierwsze takie rozwi±zanie w Polsce które ³±czy oba ¶wiaty - internetu i katalogowej sprzeda¿y wysy³kowej.<br/><br/>Je¶li chcieliby¶cie Pañstwo otrzymaæ katalog prosimy o przes³anie danych swojej firmy na adres sklep @ mikran . pl z adnotacj± 'katalog mikran'<br/><br/>Pozdrawiamy, zespó³ mikran.pl</h2>


<?php if($page == 0 || $page == 1): ?>
      <a title="Pobierz nasz katalog w formacie PDF" href="/katalog_pdf/mikran_2010.pdf"><h1>Pobierz caly katalog jako jeden plik PDF</h1></a>
      <img title="katalog mikran" src="/katalog_pdf/mikran_katalog.jpg" width="580px" alt="Pobierz katalog PDF"/>
<?php else: ?>
<? $filename = sprintf("/katalog_pdf/image/katalog_page%04d.jpg",$page); ?>
<a title="Pobierz nasz katalog w formacie PDF" href="/katalog_pdf/mikran_2010.pdf"><h1>Pobierz caly katalog jako jeden plik PDF</h1></a>
<img title="katalog mikran strona <?php echo $page?>" src="<?php echo $filename ?>" width="580px" alt="Pobierz katalog PDF"/>
<?php endif ?>
      </div>
      </td>
    </tr>
    <tr>
     <td>
<h2>Przegladaj katalog on-line</h2>
      <div id="block_1">
<?

	for($i=1;$i<=154;$i++)
	{
		echo "<a href='/katalog-mikran-do-pobrania/page/$i'>",$i," &nbsp","</a>";
	//	echo "<a href='/go/_info/katalog.php?page=$i'>",$i," &nbsp","</a>";
	}
?>
</div>
</td></tr>
<!-- END CONTENT TABLE -->
  </table>

<!-- NAV TABLE -->
<table cellspacing="0" cellpadding="0" border="0"><tr>

<td valign="top" align="left">
    <?php $this->left();?>
</td></tr></table>

<!-- END SUPER TABLE -->
</td></tr>
</table>
</center>
