<?php
$lang->address_book_add="Dodaj adres";
$lang->nologin="Brak id  klienta";
$lang->users_discount="Rabat podstawowy";
$lang->users_group="Grupa";
$lang->users_remind_title="Przypomnienie has³a do konta sklepu";
$lang->users_forgot_password="Nie pamiêtasz has³a?";
$lang->users_click_here="Kliknij tutaj";
$lang->users_remind_info1="Je¶li nie pamiêtasz swojego has³a, to wpisz poni¿ej adres e-mail. Na Twoje konto e-mail zostanie wys³ane nowe has³o.";
$lang->users_remind_info2="<p>Niestety nie mo¿emy odtworzyæ Twojego starego has³a, gdy¿ dla podwy¿szenia bezpieczeñstwa, nie przechowujemy

                           niezaszyfrowanych hase³ na serwerze. Dlatego system nada Ci nowe has³o, które po¼niej mo¿esz sobie zmieniæ 

                           loguj±c siê do sklepu.

                          ";
$lang->users_email="Wpisz e-mail";
$lang->users_send="Prze¶lij nowe has³o";
$lang->users_email_not_exists="nie ma takiego adresu e-mail w bazie, lub adres jest niepoprawny";
$lang->users_remind_sent="Na Twoje konto e-mail zosta³o wys³ane nowe has³o. Sprawd¼ pocztê.";
$lang->users_remind_subject="Przypomnienie hasla ze sklepu internetowego";
$lang->users_remind_body="Sz.P.



System nadal dla Twojego konta nowe haslo.

Aby zalogowac sie do sklepu {PROTOCOL}://{WWW} nalezy wprowadzic ponizsze dane:



login: {LOGIN}

haslo: {PASSWORD}



Jesli chcesz sie zalogowac kliknij tutaj: {PROTOCOL}://{WWW}/go/_users/

Po zalogowaniu sie do sklepu mozna zmienic haslo.



--

Wiadomosc wygenerowana automatycznie

";
$lang->users_password_info="Je¶li chcesz zmieniæ has³o dostêpu do konta, wype³nij poni¿szy formularz";
$lang->users_old_password="Stare has³o";
$lang->users_new_password="Nowe has³o";
$lang->users_password_errors=array(
                'old_password'=>"b³êdne has³o",
                'password'=>"b³êdne has³o, wpisz min. 6 znaków",
                'password2'=>"b³êdnie powtórzone has³o",
                );
$lang->users_password_changed="Twoje has³o zosta³o zmienione";
$lang->users_register_billing_form_errors=array(
                'name'=>"brak imienia",
                'surname'=>"brak nazwiska",
                'street'=>"brak ulicy",
                'street_n1'=>"brak numeru domu",
                'postcode'=>"brak kodu pocztowego",
                'city'=>"brak nazwy miasta",
                'phone'=>"brak numeru telefonu",
                'email'=>"z³y adres email",
                );
$lang->reminder_form_errors=array(
                'month'=>"niepoprawny format daty",
                'day'=>"niepoprawny format daty",
                'occasion'=>"przypisz okazje",
                'event'=>"nie wpisano danych dla tego pola",
                'advise'=>"cyklicznosc wydarzenia",
                'handling1'=>"wybierz sposób powiadomiania",
                'handling2'=>"wybierz sposób powiadomiania",
                'handling3'=>"wybierz sposób powiadomiania",
                );
$lang->occasion=array(
                '0'=>"Imieniny",
                '1'=>"Urodziny",
                '2'=>"Rocznica",
                '3'=>"Inna",
                '4'=>"-- Okazje --",
                '5'=>"Gratulacje",
                '6'=>"Narodziny dziecka",
                '7'=>"Mi³o¶æ",
                '8'=>"Podziêkowania",
                '9'=>"Pozdrowienia",
                '10'=>"-- ¦wiêta --",
                '11'=>"B³ogos³awieñstwo",
                '12'=>"Dzieñ matki",
                '13'=>"Dzieñ nauczyciela",
                '14'=>"Dzieñ ojca",
                '15'=>"Halloween",
                '16'=>"Walentynki",
                '17'=>"Wielkanoc",
                '18'=>"Wigilija",
                );
$lang->reminder_subject = "Przypomnienie - terminarz serwisu";
$lang->reminder_fields=array(
                'occasion'=>'Okazja',
                'person'=>'Osoba / Wydarzenie',
                'date'=>'Data',
);
$lang->advise=array(
                'annually'=>"Corocznie",
                'once'=>"Jednorazowo",
                );
$lang->add_reminder="Dodaj wpis do terminarza";
$lang->users_address_book="Ksi±¿ka adresowa";
$lang->users_reminder="Terminarz";
$lang->order_basket=array(
                'name'=>"nazwa produktu",
                'options'=>"opcje",
                'user_id'=>"id",
                'price_netto'=>"cena netto",
                'vat'=>"VAT",
                'num'=>"ilo¶æ",
                'price_brutto'=>"cena brutto",
                'sum'=>"suma",
                );
$lang->order_names=array(
                'order_id'=>"Numer transakcji",
                'amount'=>"Kwota do zap³aty",
                'delivery_cost'=>"Koszty dostawy",
                'id_currency'=>"Waluta",
                'id_pay_method'=>"P³atno¶æ",
                'date_add'=>"Data transakcji",
                'time_add'=>"Godzina",
                'xml_description'=>"zamówienie",
                'id_user'=>"id u¿ytkownika",
                'xml_user'=>"dane zamawiaj±cego",
                'name'=>"zamawiaj±cy",
                'id_delivery'=>"Dostawca",
                'id_status'=>"Status",
                'confirm'=>"Zap³acona",
                'confirm_user'=>"Potwierdzona mailem",
                'description'=>"Informacje dodatkowe",
                'status'=>"Status",
                'checksum'=>"suma kontrolna transakcji",
                'send_date'=>"Data wys³ania przesy³ki",
                'send_number'=>"Numer przesy³ki",
                'send_confirm'=>"Przesy³ka wys³ana",
                );
$lang->users_bar="Witamy w panelu u¿ytkownika !";
$lang->plugins_transuser_ask4trans="Zapytanie o stan transakcji nr:";
$lang->plugins_transuser_ask4="Zapytaj o transakcje";
$lang->trans_bar_title="Moje transakcje";
$lang->trans_products="Transakcja numer:";
$lang->users_add_error="U¿ytkownik nie zosta³ poprawnie dodany do bazy";
$lang->users_logout_action="Dziêkujemy za odwiedziny i zapraszamy ponownie!";
$lang->users_order_status_undefined="Niezdefiniowany";
$lang->users_paste="Wklej";
$lang->users_edit="Edytuj";
$lang->users_delete="Usuñ";
$lang->users_status="Status";
$lang->users_entry_updated="Wpis zosta³ zaktualizowany w Ksi±¿ce Adresowej";
$lang->users_entry_added="Wpis zosta³ dodany do Ksi±¿ki Adresowej";
$lang->users_entry_deleted="Wpis zosta³ usuniêty z Ksi±¿ki Adresowej";
$lang->users_entry_added2="Wpis zosta³ dodany do formularza jako <b>adres wysy³kowy</b>";
$lang->points_unit="pkt.";
$lang->users_partners=array(
                'order_count'=>"Liczba transakcji",
                'total_sum'=>"Suma warto¶ci",
                'rake_sum'=>"Suma prowizji",
                'search_orders'=>"Znajd¼ zamówienia z³o¿one",
                'from'=>"Od",
                'to'=>"Do",
                'format'=>"[dd-mm-rrrr]",
                'confirm'=>"Potwierd¼",
                'bar'=>"[KONTO PARTNERA] :: ",
                );
                
?>