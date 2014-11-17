<?php
$lang->available_bar = "Przedzia³y dostêpno¶ci";
$lang->configure_bar = "Konfiguracja";
$lang->available_list['name'] = "Nazwa";
$lang->available_list['from'] = "Od";
$lang->available_list['to'] = "Do";
$lang->confirm = "Zatwierd¼";

$lang->error_message['duplicated_from_value'] = "Wielokrotnie wpisano ten sam pocz±tek przedzia³u";
$lang->error_message['no_from_zero_entry'] = "Brak przedzia³u zaczynaj±cego siê od zera";
$lang->error_message['invalid_interval_boundaries'] = "Niepoprawne granice s±siednich przedzia³ów. Granice te to ";
$lang->error_message['interval_from_gt_interval_to'] = "Granica koñcowa przedzia³u mniejsza jest ni¿ granica pocz±tkowa";
$lang->error_message['duplicated_inf_boundary'] = "Wprowadzono przynajmniej dwa przedzia³y z gwiazdk± (*)";
$lang->error_message['invalid_data_format'] = "Niepoprawny format wpisanych warto¶ci";
$lang->error_message['no_to_inf_entry'] = "Brak przedzia³u z gwiazdk± (*)";

$lang->error_message['duplicate_depository'] = "Wybrany produkt posiada ju¿ swój stan magazynowy.";
$lang->error_message['invalid_product_id'] = "Produkt o podanym numerze ID nie istnieje.";

$lang->ok_message['intervals_changes'] = "Przedzia³y zosta³y poprawnie zmienione.";

$lang->depository_bar="depository";

// dodanie rekordu
$lang->depository_add_bar="Dodaj now± pozycjê magazynow±";
$lang->depository_record_add="Pozycja magazynowa dodana";

// aktualizacja rekordu
$lang->depository_update_bar="Aktualizacja pozycji magazynowej";
$lang->depository_edit_update_ok="Pozycja magazynowa zaktualizowana";

// komunikaty o bledach, pojawia sie jesli dane pole jest wymagane i nie jest wprowadzone
// jesli jakies pole jest wymagane, to odpowiedni wpis dla tego pola musi sie znalezc w ponizszej tablicy !
$lang->depository_form_errors=array(
                                 "user_id_main"=>"Niepoprawny identyfikator produktu",
                                 "num"=>"Niepoprawna warto¶æ stanu magazynowego",
                                 "min_num"=>"Niepoprawna warto¶æ minimalna stanu magazynowego",
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
                               "diff"=>"Ró¿nica",
                               "deliverer"=>"Dostawca magazynowy",
                               );

$lang->depository_menu=array(
                        "add"=>"Dodaj pozycjê magazynow±",
                        "list"=>"Lista pozycji magazynowych",
                        "intervals"=>"Przedzia³y",
                        "configure"=>"Konfiguracja",
                        "deliverers"=>"Dostawcy magazynowi",
                        "availability"=>"Dostêpno¶æ",
                        "depository"=>"Magazyn",
                          );

$lang->depository_list_bar="Lista pozycji magazynowych";

$lang->show_unavailable="Pokazuj towar, którego nie ma w magazynie";
$lang->available_type_to_hide="Typ dostêpno¶ci, dla którego produkty bêd± niedostêpne<br>(je¶li powy¿sze pole bêdzie zaznaczone)";
$lang->general_min_num="Domy¶lny stan minimalny";
$lang->update_num_on_action=array(
                        "title"=>"Zdejmuj produkty z magazynu",
                        "on_take_order"=>"w chwili z³o¿enia zamówienia",
                        "on_confirm"=>"w chwili potwierdzenia zamówienia (on-line przez kupuj±cego lub w panelu przez administratora)",
                        "on_paid"=>"w chwili zmiany statusu zamówienia na <i>zap³acone</i>",
);
$lang->return_on_cancel="Przywracaj stan magazynowy przy anulowaniu zamówienia";
?>