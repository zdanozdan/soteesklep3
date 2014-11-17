<?php
$lang->cardpay_menu=array(
                        "about"=>"O us�udze",                      
                        "setup"=>"Konfiguracja",                      
                        "order"=>"Transakcje",
                        );
$lang->cardpay_title="Obs�uga kart p�atniczych w sklepie";
$lang->cardpay=array('active'=>"W��cz obs�ug� kart p�atniczych w sklepie",
						"ssl_warning"=>"<b>Uwaga!</b><br>W sklepie musi by� w��czona obs�uga bezpiecznych po��cze� ssl (mo�na je w��czy� <u><a href=/go/_configure/>tutaj</a></u>), aby m�c korzysta� z tej formy p�atno�ci.",
						); 
$lang->cardpay_bcmath_error="Do korzystania z tej funkcji sklepu konieczna jest biblioteka bcmath na serwerze www.<br> 
W na twoim serwerze www <font style=\"color: red;\"><b>nie</b></font> jest ona dost�pna!
<br>Skontaktuj si� z administratorem serwera aby przekompilowa� php z opcj� --enable-bcmath !<br>
Po tym jak administrator zainstaluje biblioteke na serwerze prosz� reinstalowa� sklep.<br><br> ";
$lang->cardpay_about="<br>
&nbsp;&nbsp;Je�eli w sklepie nie ma mo�liwo�ci aktywowania innych metod p�atno�ci - takich jak PolCard, Przelewy24, P�atno�ciPL czy PayPal - sprzedawca mo�e skorzysta� z tego modu�u.<br><br>
&nbsp;&nbsp;Podczas zam�wienia w sklepie pobierane s� dane z kart p�atniczych klient�w, po zaszyrfowaniu zapisywane s� one w bazie danych.<br><br>
&nbsp;&nbsp;Sprzedawca przegl�daj�c szczeg�y zam�wienia zobaczy jakie dane wprowadzi� klient, nast�pnie skontaktuje si� telefonicznie z wybranym wcze�niej bankiem i autoryzuje transakcje.<br><br>
&nbsp;&nbsp;Dane kart s� szyfrowane 128 bitowym kluczem asynchronicznym i s� bezpowrotnie usuwane z bazy danych po zaznaczeniu przez sprzedawce �e transakcja zosta�a op�acona.<br><br>
&nbsp;&nbsp;P�atno�� ta wymaga w��czenia bezpiecznego po��czenia ssl w sklepie aby dodatkowo zabezpieczy� przesy�ane do sklepu dane.<br><br>
&nbsp;&nbsp;Ponadto p�atno�� ta wymaga pewnych ustawie� serwera na kt�rym znajduje si� sklep - domy�lnie w��czonych na wi�kszo�ci serwer�w.<br>
&nbsp;&nbsp;Je�eli w��czenie kt�rejkolwiek z powy�szych opcji nie b�dzie mo�liwe - w zak�adce konfiguracja pojawi sie odpowiedni komunikat.<br><br>
<br>Aby aktywowa� modu� przejd� do zak�adki <a href=index.php>Konfiguracja</a><br><br>";
$lang->cardpay_errors=array(
							"bcmath"=>"Na serwerze brakuje modu�u bcmath, skontaktuj si� z administratorem serwera aby zainstalowa� brakuj�cy modu�.<br>",
							"openssl"=>"Na serwerze brakuje modu�u ssl, skontaktuj si� z administratorem aby zainstalowa� brakuj�cy modu� i skonfigurowa� serwer.<br>",
							"config-ssl"=>"W sklepie wy��czona jest obs�uga formularzy ssl, prosz� w��czy� j� zaznaczaj�c widoczne poni�ej pole i klikaj�c \"Aktualizuj\".<br>",
							"notice"=>"<font color=red>Aby w��czy� modu� najpierw usu� powy�sze b��dy!</font><br>",
							);
$lang->configure_form['ssl']="Formularze zam�wie� przez ssl";
$lang->cardpay_ssl_warning="Opcja bezpiecznych formularzy ssl jest teraz w��czona w sklepie.<br>Aby sprawdzi� czy serwer jest poprawnie skonfigurowany - dodaj do koszyka dowolny produkt, i zam�w go.<br>
Je�eli po klikni�ciu na przycisk \"Realizuj zam�wienie\" wyst�pi� b��d - skontaktuj si� z administratorem serwera i popro� go o skonfigurowanie serwera tak, by mo�liwe by�y bezpieczne po��czenia https.";							
//Opcja bezpiecznych formularzy ssl jest w��czona w sklepie, aby sprawdzi� czy serwer jest poprawnie skonfigurowany - dodaj do koszyka dowolny produkt, i zam�w go.<br>
//Je�eli wyst�pi� b��d - prosze skontaktowa� si� z administratorem serwera - aby skonfigurowa� on serwer tak aby obs�ugiwa� on bezpieczne po��czenia https.
?>