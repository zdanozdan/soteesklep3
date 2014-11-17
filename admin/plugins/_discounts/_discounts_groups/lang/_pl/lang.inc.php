<?php
$lang->tips="Grupy rabatowe pozwalaj� na indywidualne przygotowanie ofert dla klient�w";
$lang->discounts_groups_bar="discounts_groups";
$lang->discounts_bar="discounts";
$lang->discounts_main_menu=array(
                'discounts'=>"Definiuj rabaty",
                'discounts_groups'=>"Edytuj grupy rabatowe",
                'export'=>"Aktualizuj",
                );
$lang->discounts_groups_add_bar="Dodaj now� grup� rabatow�";
$lang->discounts_groups_record_add="Nowa grupa rabatowa zosta�a dodana";
$lang->discounts_groups_update_bar="Aktualizacja grup rabatowych/obroty";
$lang->discounts_groups_edit_update_ok="Rekord zaktualizowany";
$lang->discounts_groups_form_errors=array(
                'user_id'=>array(
                                '1'=>"Brak identyfitaktora grupy (liczba ca�kowita >0)",
                                '2'=>"Podany identyfikator istnieje w bazie danych!",
                                '10'=>"Podany numer ID juz istnieje (wprowadz inn� warto�� >0)",
                                ),
                                
                'group_name'=>"Brak nazwy grupy rabatowej",
                'start_date'=>array(
                                '1'=>"Brak danych !",
                                '2'=>"Z�y format danych (2003-10-09;09:45 itp.)",
                                '3'=>"Z�y format daty (2003-10-09 itp.)",
                                '4'=>"Data rozpocz�cia musi by� po�niejsza b�d� rowna aktualnej ",
                                '5'=>"Z�y rok (2003,2004,2005 itd.)",
                                '6'=>"Z�y miesi�c (01-12)",
                                '7'=>"Z�y dzie� (01-31)",
                                '8'=>"Z�y format godziny (10, 23, 10, 00  itp.)",
                                '9'=>"B��dny format minut (12, 33, 55, 00 itp.)",
                                '10'=>"Czas rozpocz�cia promocji musi by� rowny b�d� po�niejszy od aktualnego czasu",
                                ),
                                
                'end_date'=>array(
                                '1'=>"Brak danych !",
                                '2'=>"Z�y format danych (2003-10-09;09:00)",
                                '3'=>"Z�y format daty (2003-10-09)",
                                '4'=>"Z�y format godziny (09:00, 23:45, 14:33  itp.)",
                                '5'=>"Data ko�ca promocji musi by� po�niejsza ni� data pocz�tkowa",
                                '6'=>"Z�y rok (2003,2004,2005 itd.)",
                                '7'=>"Z�y miesi�c (01-12)",
                                '8'=>"Z�y dzie� (01-31)",
                                '9'=>"Z�y format godziny (10, 23, 10, 00  itp.)",
                                '10'=>"B��dny format minut (12, 33, 55, 00 itp.)",
                                '11'=>"Czas rozpocz�cia promocji musi by� rowny b�d� po�niejszy od aktualnego czasu",
                                ),
                                
                );
$lang->discounts_groups_cols_row=array(
                'user_id'=>"ID",
                'group_name'=>"nazwa grupy rabatowej",
                'default_discount'=>"domy�lny rabat %",
                );
$lang->discounts_groups_cols=array(
                'user_id'=>"ID",
                'group_name'=>"nazwa grupy rabatowej",
                'default_discount'=>"domy�lny rabat",
                'public'=>"nazwa grupy b�dzie widoczna dla klienta",
                'photo'=>"grafika np. nazwa grupy itp.",
                'group_amount'=>"pr�g obrot�w",
                'calculate_period'=>"okres rozliczeniowy obrot�w",
                'start_date'=>"Pocz�tek promocji np. (2003-10-17;11:55)",
                'end_date'=>"Koniec promocji np. (2003-10-17;13:55)",
                );
$lang->discounts_groups_menu=array(
                'add'=>"Dodaj grup� rabatow�",
                'list'=>"Lista grup",
                'update'=>"Aktualizuj grupy rabatowe/obroty",
                );
$lang->discounts_groups_list_bar="Lista grup rabatowych";
$lang->discounts_groups_no_period="bezterminowy";
$lang->discounts_groups_year="roczny";
$lang->discounts_groups_start_year="od pocz�tku roku";
$lang->discounts_groups_update_dg="Aktualizacja zako�czona pomy�lnie :)";
$lang->discounts_groups_update_dg1="Przeniesiono u�ytkownika o id=";
$lang->discounts_groups_update_dg2="do grupy rabatowej o id=";
$lang->discounts_groups_update_dg_no="Wszyscy u�ytkownicy nale�� do w�a�ciwych grup";
$lang->discounts_groups_user_id="Identyfikator u�ytkownika";
$lang->discounts_groups_group_id="Przeniesienie do grupy";
$lang->discounts_groups_happyhour_override_error="B��d: grupa Happy our istnieje w sklepie i nie mo�na jej zmienia� lub nadpisywa�.";
$lang->discounts_no_discounts_groups="Brak zdefiniowanych grup rabatowych !";
$lang->discounts_configuration="Konfiguracja";
?>