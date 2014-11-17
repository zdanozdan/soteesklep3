<?php
$lang->address_book_add="Pøidej adresu";
$lang->nologin="Chybí id  klienta";
$lang->users_discount="Základní rabat";
$lang->users_group="Skupina";
$lang->users_remind_title="Pøipomenutí hesla na úèet obchodu";
$lang->users_forgot_password="Nepamatuje¹ heslo?";
$lang->users_click_here="Klikni zde";
$lang->users_remind_info1="Jestli si nepamatuje¹ své heslo, tak ní¾e zadej svou e-mailovou adresu. Na Tvé e-mailový úèet bude zasláno nové heslo.";
$lang->users_remind_info2="<p>Bohu¾el nemù¾eme obnovit Tvé staré heslo, proto¾e je z dùvodu vy¹¹í bezpeènosti neuchováváme
                           neza¹ifrovaných hesel na serveru. Proto ti systém pøidìlí nové heslo, které mù¾e¹ pozdìji zmìnit 
                           pøi pøihlá¹ení do obchodu.
                          
                          ";
$lang->users_email="Napi¹ e-mail";
$lang->users_send="Po¹li nové heslo";
$lang->users_email_not_exists="není taková adresa v databázi nebo je ¹patnì zadána";
$lang->users_remind_sent="Na Tvou e-mailovou adresu bylo zasláno nové heslo. Zkontroluj si po¹tu.";
$lang->users_remind_subject="Pøipomenutí hesla z internetového obchodu";
$lang->users_remind_body="Vá¾ený pane, vá¾ená paní

Systém pøidìlil Tvému kontu nové heslo.
K pøihlá¹ení do obchodu {PROTOCOL}://{WWW} je nutné zadat následující data:

login: {LOGIN}
haslo: {PASSWORD}

Jestli se chce¹ pøihlásit, klikni zde: {PROTOCOL}://{WWW}/go/_users/
Po pøihlá¹ení do obchodu je mo¾né zmìnit heslo.

--
Automaticky vygenerovaná zpráva";
$lang->users_password_info="Pokud chce¹ zmìnit pøístupové heslo, vyplò ní¾e uvedený formuláø";
$lang->users_old_password="Staré heslo";
$lang->users_new_password="Nové heslo";
$lang->users_password_errors=array(
                'old_password'=>"chybné heslo",
                'password'=>"chybné heslo, zadej min. 6 znakù",
                'password2'=>"¹patnì opakované heslo",
                );
$lang->users_password_changed="Tvé heslo bylo zmìnìno";
$lang->users_register_billing_form_errors=array(
                'name'=>"chybí jméno",
                'surname'=>"chybí pøíjmení",
                'street'=>"chybí ulice",
                'street_n1'=>"chybí èíslo popisné domu",
                'postcode'=>"chybí po¹tovní smìrovací èíslo",
                'city'=>"chybí název mìsta",
                'phonWyst±pi³y problemy z realizacj± zamówienia.<br>Ilo¶æ punktów dostêpnych dla u¿ytkownika nie zgadza siê.<br> Proszê spróbowaæ ponownie z³o¿yæ zamówienie.e'=>"chybí èíslo telefonu",
                'email'=>"¹patná e-mailová adresa",
                );
$lang->reminder_form_errors=array(
                'month'=>"nesprávný formát datumu",
                'day'=>"nesprávný formát datumu",
                'occasion'=>"dopi¹ pøíle¾itost",
                'event'=>"nezadána data do tohoto pole",
                'advise'=>"opakování události",
                'handling1'=>"vyber si zpùsob informování",
                'handling2'=>"vyber si zpùsob informování",
                'handling3'=>"vyber si zpùsob informování",
                );
$lang->occasion=array(
                '0'=>"Svátek",
                '1'=>"Narozeniny",
                '2'=>"Výroèí",
                '3'=>"Jiná",
                '4'=>"-- Pøíle¾itost --",
                '5'=>"Gratulace",
                '6'=>"Narozeniny dítìte",
                '7'=>"Láska",
                '8'=>"Podìkování",
                '9'=>"Pozdravení",
                '10'=>"-- ¦wiêta --",
                '11'=>"Po¾ehnání",
                '12'=>"Den matek",
                '13'=>"Den uèitelù",
                '14'=>"Den otcù",
                '15'=>"Halloween",
                '16'=>"Valentýn",
                '17'=>"Velikonoce",
                '18'=>"Vánoce",
                );
$lang->advise=array(
                'annually'=>"Ka¾dý rok",
                'once'=>"Jednorázovì",
                );
$lang->add_reminder="Pøidej zápis do termináøe";
$lang->users_address_book="Adresáø";
$lang->users_reminder="Termináø";
$lang->order_basket=array(
                'name'=>"název produktu",
                'options'=>"funkce",
                'user_id'=>"id",
                'price_netto'=>"cena bez DPH",
                'vat'=>"DPH",
                'num'=>"mno¾ství",
                'price_brutto'=>"cena vèetnì DPH",
                'sum'=>"èástka",
                );
$lang->order_names=array(
                'order_id'=>"Èíslo transakce",
                'amount'=>"Èástka k zaplacení",
                'delivery_cost'=>"Cena dodání",
                'id_currency'=>"Mìna",
                'id_pay_method'=>"Splatnost",
                'date_add'=>"Datum transakce",
                'time_add'=>"Hodina",
                'xml_description'=>"objednávka",
                'id_user'=>"id u¾ivatele",
                'xml_user'=>"data objednavatele",
                'name'=>"objednavatel",
                'id_delivery'=>"Dodavatel",
                'id_status'=>"Statut",
                'confirm'=>"Zaplacena",
                'confirm_user'=>"Potvrzena e-mailem",
                'description'=>"Doplòkové informace",
                'status'=>"Statut",
                'checksum'=>"skontrolní èástka transakce",
                'send_date'=>"Datum odeslání zásilky",
                'send_number'=>"Èíslo zásilky",
                'send_confirm'=>"Zásilka odeslána",
                );
$lang->users_bar="Vítejte v u¾ivatelském panelu !";
$lang->plugins_transuser_ask4trans="Dotaz na stav transakce è.:";
$lang->plugins_transuser_ask4="Zeptej se na transakci";
$lang->trans_bar_title="Má transakce";
$lang->trans_products="Transakce èíslo:";
$lang->users_add_error="U¾ivatel nebyl korektnì pøidán do databáze";
$lang->users_order_status_undefined="Nedefinovaný";
$lang->users_paste="Vlo¾it";
$lang->users_edit="Editovat";
$lang->users_delete="Odstranit";
$lang->users_status="Status";
$lang->users_entry_updated="Údaje byly zapsány do Adresáøe";
$lang->users_entry_added="Údaje v Adresáøi byly aktualizovány";
$lang->users_entry_deleted="Údaje byly odstranìny z Adresáøe";
$lang->users_entry_added2="Údaje byly pøidány do formuláøe jako <b>adres wysy³kowy</b>";
$lang->reminder_subject = "Pøipomenutí - kalendáø servisu";
$lang->reminder_fields=array(
                'occasion'=>'Pøíle¾itost',
                'person'=>'Osoba / Událost',
                'date'=>'Datum',
                );
$lang->users_logout_action="Dìkujeme za náv¹tìvu a zveme znovu!";
$lang->points_unit="pkt.";

?>