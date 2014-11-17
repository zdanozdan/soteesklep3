<?php
$lang->tips="Grupy rabatowe pozwalaj± na indywidualne przygotowanie ofert dla klientów";
$lang->discounts_groups_bar="discounts_groups";
$lang->discounts_bar="discounts";
$lang->discounts_main_menu=array(
                'discounts'=>"Definiuj rabaty",
                'discounts_groups'=>"Edytuj grupy rabatowe",
                'export'=>"Aktualizuj",
                );
$lang->discounts_groups_add_bar="Dodaj now± grupê rabatow±";
$lang->discounts_groups_record_add="Nowa grupa rabatowa zosta³a dodana";
$lang->discounts_groups_update_bar="Aktualizacja grup rabatowych/obroty";
$lang->discounts_groups_edit_update_ok="Rekord zaktualizowany";
$lang->discounts_groups_form_errors=array(
                'user_id'=>array(
                                '1'=>"Brak identyfitaktora grupy (liczba ca³kowita >0)",
                                '2'=>"Podany identyfikator istnieje w bazie danych!",
                                '10'=>"Podany numer ID juz istnieje (wprowadz inn± warto¶æ >0)",
                                ),
                                
                'group_name'=>"Brak nazwy grupy rabatowej",
                'start_date'=>array(
                                '1'=>"Brak danych !",
                                '2'=>"Z³y format danych (2003-10-09;09:45 itp.)",
                                '3'=>"Z³y format daty (2003-10-09 itp.)",
                                '4'=>"Data rozpoczêcia musi byæ po¼niejsza b±d¼ rowna aktualnej ",
                                '5'=>"Z³y rok (2003,2004,2005 itd.)",
                                '6'=>"Z³y miesi±c (01-12)",
                                '7'=>"Z³y dzieñ (01-31)",
                                '8'=>"Z³y format godziny (10, 23, 10, 00  itp.)",
                                '9'=>"B³êdny format minut (12, 33, 55, 00 itp.)",
                                '10'=>"Czas rozpoczêcia promocji musi byæ rowny b±d¼ po¼niejszy od aktualnego czasu",
                                ),
                                
                'end_date'=>array(
                                '1'=>"Brak danych !",
                                '2'=>"Z³y format danych (2003-10-09;09:00)",
                                '3'=>"Z³y format daty (2003-10-09)",
                                '4'=>"Z³y format godziny (09:00, 23:45, 14:33  itp.)",
                                '5'=>"Data koñca promocji musi byæ po¼niejsza ni¿ data pocz±tkowa",
                                '6'=>"Z³y rok (2003,2004,2005 itd.)",
                                '7'=>"Z³y miesi±c (01-12)",
                                '8'=>"Z³y dzieñ (01-31)",
                                '9'=>"Z³y format godziny (10, 23, 10, 00  itp.)",
                                '10'=>"B³êdny format minut (12, 33, 55, 00 itp.)",
                                '11'=>"Czas rozpoczêcia promocji musi byæ rowny b±d¼ po¼niejszy od aktualnego czasu",
                                ),
                                
                );
$lang->discounts_groups_cols_row=array(
                'user_id'=>"ID",
                'group_name'=>"nazwa grupy rabatowej",
                'default_discount'=>"domy¶lny rabat %",
                );
$lang->discounts_groups_cols=array(
                'user_id'=>"ID",
                'group_name'=>"nazwa grupy rabatowej",
                'default_discount'=>"domy¶lny rabat",
                'public'=>"nazwa grupy bêdzie widoczna dla klienta",
                'photo'=>"grafika np. nazwa grupy itp.",
                'group_amount'=>"próg obrotów",
                'calculate_period'=>"okres rozliczeniowy obrotów",
                'start_date'=>"Pocz±tek promocji np. (2003-10-17;11:55)",
                'end_date'=>"Koniec promocji np. (2003-10-17;13:55)",
                );
$lang->discounts_groups_menu=array(
                'add'=>"Dodaj grupê rabatow±",
                'list'=>"Lista grup",
                'update'=>"Aktualizuj grupy rabatowe/obroty",
                );
$lang->discounts_groups_list_bar="Lista grup rabatowych";
$lang->discounts_groups_no_period="bezterminowy";
$lang->discounts_groups_year="roczny";
$lang->discounts_groups_start_year="od pocz±tku roku";
$lang->discounts_groups_update_dg="Aktualizacja zakoñczona pomy¶lnie :)";
$lang->discounts_groups_update_dg1="Przeniesiono u¿ytkownika o id=";
$lang->discounts_groups_update_dg2="do grupy rabatowej o id=";
$lang->discounts_groups_update_dg_no="Wszyscy u¿ytkownicy nale¿± do w³a¶ciwych grup";
$lang->discounts_groups_user_id="Identyfikator u¿ytkownika";
$lang->discounts_groups_group_id="Przeniesienie do grupy";
$lang->discounts_groups_happyhour_override_error="B³±d: grupa Happy our istnieje w sklepie i nie mo¿na jej zmieniaæ lub nadpisywaæ.";
$lang->discounts_no_discounts_groups="Brak zdefiniowanych grup rabatowych !";
$lang->discounts_configuration="Konfiguracja";
?>