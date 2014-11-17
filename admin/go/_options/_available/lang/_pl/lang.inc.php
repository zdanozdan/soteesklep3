<?php
$lang->available_bar="Zarz±dzanie dostêpno¶ci± towarów";
$lang->available_menu=array(
                'add'=>'Nowy okres dostêpno¶ci',
                'list'=>'Lista dostêpno¶ci',
                'configure'=>'Konfiguracja',
                "deliverers"=>"Dostawcy magazynowi",
                "availability"=>"Dostêpno¶æ",
                "depository"=>"Magazyn",
                'help'=>'Pomoc',
                );
$lang->available_edit="Edytuj w³a¶ciwo¶ci dostêpno¶ci towaru";
$lang->available_cols=array(
                'name'=>'nazwa dostêpno¶ci',
                'user_id'=>'id (identyfikator dostêpno¶ci, liczba ca³okowita)',
                'num_from'=>'Stan magazynowy od (liczba)',
                'num_to'=>'Stan magazynowy do (liczba lub znak *)',
                );
$lang->available_edit_form_errors=array(
                'name'=>'brak nazwy dostêno¶ci',
                'user_id'=>'b³êdna warto¶æ',
                );
$lang->available_add_bar="Dodaj now± dostêpno¶æ";
$lang->available_export_ok="Lista statusow dostêpno¶ci zosta³a wyeksportowna do sklepu";
$lang->available_list=array(
                'name'=>'Nazwa',
                'num_from'=>'Stan od',
                'num_to'=>'Stan do',
                );
                
$lang->error_message['duplicated_from_value'] = "Wielokrotnie wpisano ten sam pocz±tek przedzia³u";
$lang->error_message['no_from_zero_entry'] = "Brak przedzia³u zaczynaj±cego siê od zera";
$lang->error_message['invalid_interval_boundaries'] = "Przedzia³y magazynowe zazêbiaj± siê lub jest luka miêdzy nimi. B³êdne granice to ";
$lang->error_message['interval_from_gt_interval_to'] = "Granica koñcowa przedzia³u mniejsza jest ni¿ granica pocz±tkowa";
$lang->error_message['duplicated_inf_boundary'] = "Wprowadzono przynajmniej dwa przedzia³y z gwiazdk± (*)";
$lang->error_message['invalid_data_format'] = "Niepoprawny format wpisanych warto¶ci";
$lang->error_message['no_to_inf_entry'] = "Brak przedzia³u z gwiazdk± (*)";

$lang->error_message['duplicate_depository'] = "Wybrany produkt posiada ju¿ swój stan magazynowy.";
$lang->error_message['invalid_product_id'] = "Produkt o podanym numerze ID nie istnieje.";
$lang->error_message['need_to_repair'] = "Powy¿szy komunikat oznacza, ¿e konieczne jest poprawienie przedzia³ów stanów magazynowych w odpowiednich dostêpno¶ciach (patrz: Pomoc).<br>W przeciwnym razie stany magazynowe bêd± b³êdnie interpretowane i modu³ magazynowy nie bêdzie dzia³a³ poprawnie.";
$lang->error_message['not_changed'] = "Przedzia³y nie zosta³y zmienione.";
$lang->confirm='Zatwierd¼ przedzia³y';
$lang->confirm_conf='Zatwierd¼';
$lang->display_availability="Pokazuj w sklepie informacjê o dostêpno¶ci produktów";

?>