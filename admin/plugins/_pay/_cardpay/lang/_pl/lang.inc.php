<?php
$lang->cardpay_menu=array(
                        "about"=>"O us³udze",                      
                        "setup"=>"Konfiguracja",                      
                        "order"=>"Transakcje",
                        );
$lang->cardpay_title="Obs³uga kart p³atniczych w sklepie";
$lang->cardpay=array('active'=>"W³±cz obs³ugê kart p³atniczych w sklepie",
						"ssl_warning"=>"<b>Uwaga!</b><br>W sklepie musi byæ w³±czona obs³uga bezpiecznych po³±czeñ ssl (mo¿na je w³±czyæ <u><a href=/go/_configure/>tutaj</a></u>), aby móc korzystaæ z tej formy p³atno¶ci.",
						); 
$lang->cardpay_bcmath_error="Do korzystania z tej funkcji sklepu konieczna jest biblioteka bcmath na serwerze www.<br> 
W na twoim serwerze www <font style=\"color: red;\"><b>nie</b></font> jest ona dostêpna!
<br>Skontaktuj siê z administratorem serwera aby przekompilowa³ php z opcj± --enable-bcmath !<br>
Po tym jak administrator zainstaluje biblioteke na serwerze proszê reinstalowaæ sklep.<br><br> ";
$lang->cardpay_about="<br>
&nbsp;&nbsp;Je¿eli w sklepie nie ma mo¿liwo¶ci aktywowania innych metod p³atno¶ci - takich jak PolCard, Przelewy24, P³atno¶ciPL czy PayPal - sprzedawca mo¿e skorzystaæ z tego modu³u.<br><br>
&nbsp;&nbsp;Podczas zamówienia w sklepie pobierane s± dane z kart p³atniczych klientów, po zaszyrfowaniu zapisywane s± one w bazie danych.<br><br>
&nbsp;&nbsp;Sprzedawca przegl±daj±c szczegó³y zamówienia zobaczy jakie dane wprowadzi³ klient, nastêpnie skontaktuje siê telefonicznie z wybranym wcze¶niej bankiem i autoryzuje transakcje.<br><br>
&nbsp;&nbsp;Dane kart s± szyfrowane 128 bitowym kluczem asynchronicznym i s± bezpowrotnie usuwane z bazy danych po zaznaczeniu przez sprzedawce ¿e transakcja zosta³a op³acona.<br><br>
&nbsp;&nbsp;P³atno¶æ ta wymaga w³±czenia bezpiecznego po³±czenia ssl w sklepie aby dodatkowo zabezpieczyæ przesy³ane do sklepu dane.<br><br>
&nbsp;&nbsp;Ponadto p³atno¶æ ta wymaga pewnych ustawieñ serwera na którym znajduje siê sklep - domy¶lnie w³±czonych na wiêkszo¶ci serwerów.<br>
&nbsp;&nbsp;Je¿eli w³±czenie którejkolwiek z powy¿szych opcji nie bêdzie mo¿liwe - w zak³adce konfiguracja pojawi sie odpowiedni komunikat.<br><br>
<br>Aby aktywowaæ modu³ przejd¼ do zak³adki <a href=index.php>Konfiguracja</a><br><br>";
$lang->cardpay_errors=array(
							"bcmath"=>"Na serwerze brakuje modu³u bcmath, skontaktuj siê z administratorem serwera aby zainstalowa³ brakuj±cy modu³.<br>",
							"openssl"=>"Na serwerze brakuje modu³u ssl, skontaktuj siê z administratorem aby zainstalowa³ brakuj±cy modu³ i skonfigurowa³ serwer.<br>",
							"config-ssl"=>"W sklepie wy³±czona jest obs³uga formularzy ssl, proszê w³±czyæ j± zaznaczaj±c widoczne poni¿ej pole i klikaj±c \"Aktualizuj\".<br>",
							"notice"=>"<font color=red>Aby w³±czyæ modu³ najpierw usuñ powy¿sze b³êdy!</font><br>",
							);
$lang->configure_form['ssl']="Formularze zamówieñ przez ssl";
$lang->cardpay_ssl_warning="Opcja bezpiecznych formularzy ssl jest teraz w³±czona w sklepie.<br>Aby sprawdziæ czy serwer jest poprawnie skonfigurowany - dodaj do koszyka dowolny produkt, i zamów go.<br>
Je¿eli po klikniêciu na przycisk \"Realizuj zamówienie\" wyst±pi³ b³±d - skontaktuj siê z administratorem serwera i popro¶ go o skonfigurowanie serwera tak, by mo¿liwe by³y bezpieczne po³±czenia https.";							
//Opcja bezpiecznych formularzy ssl jest w³±czona w sklepie, aby sprawdziæ czy serwer jest poprawnie skonfigurowany - dodaj do koszyka dowolny produkt, i zamów go.<br>
//Je¿eli wyst±pi³ b³±d - prosze skontaktowaæ siê z administratorem serwera - aby skonfigurowa³ on serwer tak aby obs³ugiwa³ on bezpieczne po³±czenia https.
?>