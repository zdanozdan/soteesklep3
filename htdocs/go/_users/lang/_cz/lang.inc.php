<?php
$lang->address_book_add="P�idej adresu";
$lang->nologin="Chyb� id  klienta";
$lang->users_discount="Z�kladn� rabat";
$lang->users_group="Skupina";
$lang->users_remind_title="P�ipomenut� hesla na ��et obchodu";
$lang->users_forgot_password="Nepamatuje� heslo?";
$lang->users_click_here="Klikni zde";
$lang->users_remind_info1="Jestli si nepamatuje� sv� heslo, tak n�e zadej svou e-mailovou adresu. Na Tv� e-mailov� ��et bude zasl�no nov� heslo.";
$lang->users_remind_info2="<p>Bohu�el nem��eme obnovit Tv� star� heslo, proto�e je z d�vodu vy��� bezpe�nosti neuchov�v�me
                           neza�ifrovan�ch hesel na serveru. Proto ti syst�m p�id�l� nov� heslo, kter� m��e� pozd�ji zm�nit 
                           p�i p�ihl�en� do obchodu.
                          
                          ";
$lang->users_email="Napi� e-mail";
$lang->users_send="Po�li nov� heslo";
$lang->users_email_not_exists="nen� takov� adresa v datab�zi nebo je �patn� zad�na";
$lang->users_remind_sent="Na Tvou e-mailovou adresu bylo zasl�no nov� heslo. Zkontroluj si po�tu.";
$lang->users_remind_subject="P�ipomenut� hesla z internetov�ho obchodu";
$lang->users_remind_body="V�en� pane, v�en� pan�

Syst�m p�id�lil Tv�mu kontu nov� heslo.
K p�ihl�en� do obchodu {PROTOCOL}://{WWW} je nutn� zadat n�sleduj�c� data:

login: {LOGIN}
haslo: {PASSWORD}

Jestli se chce� p�ihl�sit, klikni zde: {PROTOCOL}://{WWW}/go/_users/
Po p�ihl�en� do obchodu je mo�n� zm�nit heslo.

--
Automaticky vygenerovan� zpr�va";
$lang->users_password_info="Pokud chce� zm�nit p��stupov� heslo, vypl� n�e uveden� formul��";
$lang->users_old_password="Star� heslo";
$lang->users_new_password="Nov� heslo";
$lang->users_password_errors=array(
                'old_password'=>"chybn� heslo",
                'password'=>"chybn� heslo, zadej min. 6 znak�",
                'password2'=>"�patn� opakovan� heslo",
                );
$lang->users_password_changed="Tv� heslo bylo zm�n�no";
$lang->users_register_billing_form_errors=array(
                'name'=>"chyb� jm�no",
                'surname'=>"chyb� p��jmen�",
                'street'=>"chyb� ulice",
                'street_n1'=>"chyb� ��slo popisn� domu",
                'postcode'=>"chyb� po�tovn� sm�rovac� ��slo",
                'city'=>"chyb� n�zev m�sta",
                'phonWyst�pi�y problemy z realizacj� zam�wienia.<br>Ilo�� punkt�w dost�pnych dla u�ytkownika nie zgadza si�.<br> Prosz� spr�bowa� ponownie z�o�y� zam�wienie.e'=>"chyb� ��slo telefonu",
                'email'=>"�patn� e-mailov� adresa",
                );
$lang->reminder_form_errors=array(
                'month'=>"nespr�vn� form�t datumu",
                'day'=>"nespr�vn� form�t datumu",
                'occasion'=>"dopi� p��le�itost",
                'event'=>"nezad�na data do tohoto pole",
                'advise'=>"opakov�n� ud�losti",
                'handling1'=>"vyber si zp�sob informov�n�",
                'handling2'=>"vyber si zp�sob informov�n�",
                'handling3'=>"vyber si zp�sob informov�n�",
                );
$lang->occasion=array(
                '0'=>"Sv�tek",
                '1'=>"Narozeniny",
                '2'=>"V�ro��",
                '3'=>"Jin�",
                '4'=>"-- P��le�itost --",
                '5'=>"Gratulace",
                '6'=>"Narozeniny d�t�te",
                '7'=>"L�ska",
                '8'=>"Pod�kov�n�",
                '9'=>"Pozdraven�",
                '10'=>"-- �wi�ta --",
                '11'=>"Po�ehn�n�",
                '12'=>"Den matek",
                '13'=>"Den u�itel�",
                '14'=>"Den otc�",
                '15'=>"Halloween",
                '16'=>"Valent�n",
                '17'=>"Velikonoce",
                '18'=>"V�noce",
                );
$lang->advise=array(
                'annually'=>"Ka�d� rok",
                'once'=>"Jednor�zov�",
                );
$lang->add_reminder="P�idej z�pis do termin��e";
$lang->users_address_book="Adres��";
$lang->users_reminder="Termin��";
$lang->order_basket=array(
                'name'=>"n�zev produktu",
                'options'=>"funkce",
                'user_id'=>"id",
                'price_netto'=>"cena bez DPH",
                'vat'=>"DPH",
                'num'=>"mno�stv�",
                'price_brutto'=>"cena v�etn� DPH",
                'sum'=>"��stka",
                );
$lang->order_names=array(
                'order_id'=>"��slo transakce",
                'amount'=>"��stka k zaplacen�",
                'delivery_cost'=>"Cena dod�n�",
                'id_currency'=>"M�na",
                'id_pay_method'=>"Splatnost",
                'date_add'=>"Datum transakce",
                'time_add'=>"Hodina",
                'xml_description'=>"objedn�vka",
                'id_user'=>"id u�ivatele",
                'xml_user'=>"data objednavatele",
                'name'=>"objednavatel",
                'id_delivery'=>"Dodavatel",
                'id_status'=>"Statut",
                'confirm'=>"Zaplacena",
                'confirm_user'=>"Potvrzena e-mailem",
                'description'=>"Dopl�kov� informace",
                'status'=>"Statut",
                'checksum'=>"skontroln� ��stka transakce",
                'send_date'=>"Datum odesl�n� z�silky",
                'send_number'=>"��slo z�silky",
                'send_confirm'=>"Z�silka odesl�na",
                );
$lang->users_bar="V�tejte v u�ivatelsk�m panelu !";
$lang->plugins_transuser_ask4trans="Dotaz na stav transakce �.:";
$lang->plugins_transuser_ask4="Zeptej se na transakci";
$lang->trans_bar_title="M� transakce";
$lang->trans_products="Transakce ��slo:";
$lang->users_add_error="U�ivatel nebyl korektn� p�id�n do datab�ze";
$lang->users_order_status_undefined="Nedefinovan�";
$lang->users_paste="Vlo�it";
$lang->users_edit="Editovat";
$lang->users_delete="Odstranit";
$lang->users_status="Status";
$lang->users_entry_updated="�daje byly zaps�ny do Adres��e";
$lang->users_entry_added="�daje v Adres��i byly aktualizov�ny";
$lang->users_entry_deleted="�daje byly odstran�ny z Adres��e";
$lang->users_entry_added2="�daje byly p�id�ny do formul��e jako <b>adres wysy�kowy</b>";
$lang->reminder_subject = "P�ipomenut� - kalend�� servisu";
$lang->reminder_fields=array(
                'occasion'=>'P��le�itost',
                'person'=>'Osoba / Ud�lost',
                'date'=>'Datum',
                );
$lang->users_logout_action="D�kujeme za n�v�t�vu a zveme znovu!";
$lang->points_unit="pkt.";

?>