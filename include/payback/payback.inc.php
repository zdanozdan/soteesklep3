<?php
/**
* Funckje obslugi komunikacji z PayBack nadeslany przez kg@payback.pl
*
* @author  PayBack
* @version $Id: payback.inc.php,v 1.2 2004/12/20 18:03:00 maroslaw Exp $
* @package    include
*/

// start SOTE: (drobne zmiany)
define("MY_PASSWORD", $payback_config->id);
define("MY_ID",       $payback_config->password);
include 'include/payback/xmlrpc.inc.php';
// end SOTE:

// funkcja do naliczania punkt�w
function pb_give_points($komu, $ile, $idt)
{
	$pb['login']   = $komu;		// komu dajemy punkty (string) - login klienta w PayBack
	$pb['points']  = $ile;		// ile
	$pb['idt']     = $idt;		// za co - powinien to by� unikalny numer (id transakcji) typu integer
	$pb['partner'] = MY_ID;		// identyfikator sklepu w PayBacku
	$pb['time']    = time();	// wiadomo

	// teraz generujemy podpis, kt�ry zostanie sprawdzony w PayBacku
	// taki anty-spoofing ;-) 
	$pb['sig']     = md5($pb['login'] . $pb['points'] . $pb['partner'] . $pb['time'] . $pb['idt']  . MY_PASSWORD);	
	
	// generujemy paczk�
	$paczka = xmlrpc_encode($pb);

	// i wysy�amy...
	$server = new xmlrpc_client('/xmlrpc/server.php', 'kg.payback.pl', 80);
	$message = new xmlrpcmsg('GivePoints', array($paczka));
	$result = $server->send($message);

	if (!$result)	// brak po��czenia
	{
/*
		Tutaj (lub ju� po wyj�ciu z funkcji) wskazane by by�o wrzucenie
		informacji o punktach do jakiej� kolejki (np. tabeli w bazie danych),
		aby mo�na by�o naliczy� punkty nast�pnym razem (gdy ju� b�dzie po��czenie)
*/
		return "Brak po��czenia";
	}
	elseif ($result->faultCode())	// po��czono, ale nast�pi� jaki� b��d
	{
/*
		To te� mo�na zmieni� (jakie� w�asne komunikaty, itp.)
		Standardowo serwer zwraca nast�puj�ce b�edy:
		
		$result->faultCode()	$result->faultString()
		801			Brak parametr�w
		802			Brak u�ytkownika
		803			Brak punkt�w
		804			Brak id
		805			Brak klucza
		806			Brak u�ytkownika $paczka[login]
		810			Niepoprawny podpis
		811			Zdublowana transakcja
		815			B��d podczas naliczania punkt�w
*/
		return "B��d XML-RPC #" . $result->faultCode() . ": " . utf8_decode($result->faultString());
	}
	else
	{
/*
		Je�li wszystko posz�o OK 
		to serwer zwraca komunikat
		"U�ytkownik $paczka[login] otrzyma� $paczka[points] punkt�w"
		Oczywi�cie te� mo�na to zmieni� :)
*/
		$resval = $result->value();
		$val = utf8_decode($resval->scalarval());

		return $val;
	}
}

// funkcja do weryfikacji transakcji
function pb_verify_transaction($idt, $ver)
{
	$pb['idt']     = $idt;		// id transakcji
	$pb['partner'] = MY_ID;		// identyfikator sklepu w PayBacku
	$pb['ver']     = $ver;	    // jak weryfikujemy (0 - odrzucamy punkty, 1 - uznajemy)
	$pb['time']    = time();	// wiadomo

	// teraz generujemy podpis, kt�ry zostanie sprawdzony w PayBacku
    // podobnie jak w pb_give_points()
	$pb['sig']     = md5($pb['idt'] . $pb['partner']. $pb['ver']. $pb['time'] . MY_PASSWORD);

	// generujemy paczk�
	$paczka = xmlrpc_encode($pb);

	// i wysy�amy...
	$server = new xmlrpc_client('/xmlrpc/server.php', 'kg.payback.pl', 80);
	$message = new xmlrpcmsg('VerifyTransaction', array($paczka));
	$result = $server->send($message);

    // dalej podobnie jak w pb_give_points()
	if (!$result) 
	{
		return "Brak po��czenia";
	}
	elseif ($result->faultCode())
	{
		return "B��d XML-RPC #" . $result->faultCode() . ": " . utf8_decode($result->faultString());
	}
	else
	{
/*
		Je�li wszystko posz�o OK 
		to serwer zwraca komunikat
		"Zweryfikowano transakcj� $paczka[idt]"
		Oczywi�cie te� mo�na to zmieni� :)
*/
		$resval = $result->value();
		$val = utf8_decode($resval->scalarval());

		return $val;
	}
}

function pb_user_exists($pb_login)
{
	$server = new xmlrpc_client('/xmlrpc/server.php', 'kg.payback.pl', 80);
	$message = new xmlrpcmsg('UserExists', array(xmlrpc_encode(utf8_encode($pb_login))));
	$result = $server->send($message);

    // dalej podobnie jak w pb_give_points()
	if (!$result) 
	{
		return "Brak po��czenia";
	}
	elseif ($result->faultCode())
	{
		return "B��d XML-RPC #" . $result->faultCode() . ": " . utf8_decode($result->faultString());
	}
	else
	{
		$resval = $result->value();
		$val = $resval->scalarval();

		return $val;
	}
}

?>
