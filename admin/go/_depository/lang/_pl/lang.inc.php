<?php
$lang->available_bar = "Przedzia�y dost�pno�ci";
$lang->configure_bar = "Konfiguracja";
$lang->available_list['name'] = "Nazwa";
$lang->available_list['from'] = "Od";
$lang->available_list['to'] = "Do";
$lang->confirm = "Zatwierd�";

$lang->error_message['duplicated_from_value'] = "Wielokrotnie wpisano ten sam pocz�tek przedzia�u";
$lang->error_message['no_from_zero_entry'] = "Brak przedzia�u zaczynaj�cego si� od zera";
$lang->error_message['invalid_interval_boundaries'] = "Niepoprawne granice s�siednich przedzia��w. Granice te to ";
$lang->error_message['interval_from_gt_interval_to'] = "Granica ko�cowa przedzia�u mniejsza jest ni� granica pocz�tkowa";
$lang->error_message['duplicated_inf_boundary'] = "Wprowadzono przynajmniej dwa przedzia�y z gwiazdk� (*)";
$lang->error_message['invalid_data_format'] = "Niepoprawny format wpisanych warto�ci";
$lang->error_message['no_to_inf_entry'] = "Brak przedzia�u z gwiazdk� (*)";

$lang->error_message['duplicate_depository'] = "Wybrany produkt posiada ju� sw�j stan magazynowy.";
$lang->error_message['invalid_product_id'] = "Produkt o podanym numerze ID nie istnieje.";

$lang->ok_message['intervals_changes'] = "Przedzia�y zosta�y poprawnie zmienione.";

$lang->depository_bar="depository";

// dodanie rekordu
$lang->depository_add_bar="Dodaj now� pozycj� magazynow�";
$lang->depository_record_add="Pozycja magazynowa dodana";

// aktualizacja rekordu
$lang->depository_update_bar="Aktualizacja pozycji magazynowej";
$lang->depository_edit_update_ok="Pozycja magazynowa zaktualizowana";

// komunikaty o bledach, pojawia sie jesli dane pole jest wymagane i nie jest wprowadzone
// jesli jakies pole jest wymagane, to odpowiedni wpis dla tego pola musi sie znalezc w ponizszej tablicy !
$lang->depository_form_errors=array(
                                 "user_id_main"=>"Niepoprawny identyfikator produktu",
                                 "num"=>"Niepoprawna warto�� stanu magazynowego",
                                 "min_num"=>"Niepoprawna warto�� minimalna stanu magazynowego",
                                 "id_deliverer"=>"Niepoprawny dostawca magazynowy",
				);

// nazwy kolumn do formularza, nazwy pojawia sie przy wyswietleniu pol formularza - w edycji
$lang->depository_cols=array("ID"    =>"ID",                          
                               "user_id_main"=>"ID produktu",
                               "num"=>"Stan",
                               "min_num"=>"Stan minimalny",
                               "deliverer"=>"Dostawca magazynowy",
                          );

// pola, ktore poajwia sie na liscie rekordow + nazwy (na podstawie tych danych sa generowane opisy do <th>)
$lang->depository_cols_list=array(
                               "id"    =>"ID",
                               "change"=>"",
                               "user_id_main"=>"ID produktu : nazwa",
                               "num"=>"Stan",
                               "min_num"=>"Stan min.",
                               "diff"=>"R�nica",
                               "deliverer"=>"Dostawca magazynowy",
                               );

$lang->depository_menu=array(
                        "add"=>"Dodaj pozycj� magazynow�",
                        "list"=>"Lista pozycji magazynowych",
                        "intervals"=>"Przedzia�y",
                        "configure"=>"Konfiguracja",
                        "deliverers"=>"Dostawcy magazynowi",
                        "availability"=>"Dost�pno��",
                        "depository"=>"Magazyn",
                          );

$lang->depository_list_bar="Lista pozycji magazynowych";

$lang->show_unavailable="Pokazuj towar, kt�rego nie ma w magazynie";
$lang->available_type_to_hide="Typ dost�pno�ci, dla kt�rego produkty b�d� niedost�pne<br>(je�li powy�sze pole b�dzie zaznaczone)";
$lang->general_min_num="Domy�lny stan minimalny";
$lang->update_num_on_action=array(
                        "title"=>"Zdejmuj produkty z magazynu",
                        "on_take_order"=>"w chwili z�o�enia zam�wienia",
                        "on_confirm"=>"w chwili potwierdzenia zam�wienia (on-line przez kupuj�cego lub w panelu przez administratora)",
                        "on_paid"=>"w chwili zmiany statusu zam�wienia na <i>zap�acone</i>",
);
$lang->return_on_cancel="Przywracaj stan magazynowy przy anulowaniu zam�wienia";
?>