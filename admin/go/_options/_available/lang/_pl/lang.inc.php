<?php
$lang->available_bar="Zarz�dzanie dost�pno�ci� towar�w";
$lang->available_menu=array(
                'add'=>'Nowy okres dost�pno�ci',
                'list'=>'Lista dost�pno�ci',
                'configure'=>'Konfiguracja',
                "deliverers"=>"Dostawcy magazynowi",
                "availability"=>"Dost�pno��",
                "depository"=>"Magazyn",
                'help'=>'Pomoc',
                );
$lang->available_edit="Edytuj w�a�ciwo�ci dost�pno�ci towaru";
$lang->available_cols=array(
                'name'=>'nazwa dost�pno�ci',
                'user_id'=>'id (identyfikator dost�pno�ci, liczba ca�okowita)',
                'num_from'=>'Stan magazynowy od (liczba)',
                'num_to'=>'Stan magazynowy do (liczba lub znak *)',
                );
$lang->available_edit_form_errors=array(
                'name'=>'brak nazwy dost�no�ci',
                'user_id'=>'b��dna warto��',
                );
$lang->available_add_bar="Dodaj now� dost�pno��";
$lang->available_export_ok="Lista statusow dost�pno�ci zosta�a wyeksportowna do sklepu";
$lang->available_list=array(
                'name'=>'Nazwa',
                'num_from'=>'Stan od',
                'num_to'=>'Stan do',
                );
                
$lang->error_message['duplicated_from_value'] = "Wielokrotnie wpisano ten sam pocz�tek przedzia�u";
$lang->error_message['no_from_zero_entry'] = "Brak przedzia�u zaczynaj�cego si� od zera";
$lang->error_message['invalid_interval_boundaries'] = "Przedzia�y magazynowe zaz�biaj� si� lub jest luka mi�dzy nimi. B��dne granice to ";
$lang->error_message['interval_from_gt_interval_to'] = "Granica ko�cowa przedzia�u mniejsza jest ni� granica pocz�tkowa";
$lang->error_message['duplicated_inf_boundary'] = "Wprowadzono przynajmniej dwa przedzia�y z gwiazdk� (*)";
$lang->error_message['invalid_data_format'] = "Niepoprawny format wpisanych warto�ci";
$lang->error_message['no_to_inf_entry'] = "Brak przedzia�u z gwiazdk� (*)";

$lang->error_message['duplicate_depository'] = "Wybrany produkt posiada ju� sw�j stan magazynowy.";
$lang->error_message['invalid_product_id'] = "Produkt o podanym numerze ID nie istnieje.";
$lang->error_message['need_to_repair'] = "Powy�szy komunikat oznacza, �e konieczne jest poprawienie przedzia��w stan�w magazynowych w odpowiednich dost�pno�ciach (patrz: Pomoc).<br>W przeciwnym razie stany magazynowe b�d� b��dnie interpretowane i modu� magazynowy nie b�dzie dzia�a� poprawnie.";
$lang->error_message['not_changed'] = "Przedzia�y nie zosta�y zmienione.";
$lang->confirm='Zatwierd� przedzia�y';
$lang->confirm_conf='Zatwierd�';
$lang->display_availability="Pokazuj w sklepie informacj� o dost�pno�ci produkt�w";

?>