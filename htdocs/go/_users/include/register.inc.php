<?php
/**
 * Wywolaj formularze zmowienia itp.
 *
 * \@global object $theme
 *
 * @author m@sote.pl
 * @version $Id: register.inc.php,v 2.2 2004/12/20 18:01:56 maroslaw Exp $
* @package    users
 */

class Register {
    /**
     * Wywolaj formularz rejestracji - dane bilingowe + zawartosc koszyka
     *
     * \@global object $my_basket
     */
    function billing_form() {
        global $theme;
        global $my_basket;
        global $_SESSION;
        global $_POST;
        global $lang;

        $my_basket->display="text";
        $my_basket->show_form();
        $theme->basket_amount($my_basket->amount);

        include_once ("include/form_check.inc");
        $form_check = new FormCheck; 

        // odczytaj parametry przekazane z formularza HTML
        // ktore sa zapisane w tablicy form
        if (! empty($_POST['form'])) {
            $form=$_POST['form'];
            $form_check->form=&$form; // przekaz dane z formularza
        }

        // definiuj funckje sprawdzajace poprawnosc wartosci pola z formularza
        // (z klasy FormCheck)
        $form_check->fun['firm']="null";
        $form_check->fun['name']="string";
        $form_check->fun['surname']="string";
        $form_check->fun['street']="string";
        $form_check->fun['street_n1']="string";
        $form_check->fun['street_n2']="string";
        $form_check->fun['postcode']="string";
        $form_check->fun['city']="string";
        $form_check->fun['phone']="string";
        $form_check->fun['email']="email";
        $form_check->fun['nip']="nip";
        $form_check->fun['description']="null";
        $form_check->fun['cor_addr']="null";

        // sprawdz czy jest to wywolanie wyswietlenia formularza, czy sprawdzenie
        if (! empty($form['check'])) {
            $form_check->check=my($form['check']);
        }

        // tablica z komunikatami bledow
        $form_check->errors=&$lang->register_billing_form_errors;
        
        // sprawdz czy formularz jest poprawnie wyswietlony
        // wymagane sa pola, ktore maja odpowiednia wartosc w $form_check->errors
        // tj. maja przypisany komunikat o bledzie        
        if ($form_check->check=="true") {
            if ($form_check->form_test()) {
                // poprawnie wypeniony formularz
                include_once ("register2.php");
                exit;
            }
        }
        
        // wyswietl ponownie formularz, jesli zostal zle
        // wypelniony (lub jesli jest to pierwsze wywolanie)
        // w przypadku zlego wypelnienia, dodaj komunikaty o bledach
        // zawarte (po sprawdzeniu formularza) w tablicy $form_check->errors_found
        $theme->users_form($form,$form_check);        

        return;
    }
}
?>
