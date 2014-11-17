<?php
class ThemeLocal extends ThemePlugins {

    /**
     * Pokaz ikonke/oznaczenie statusu platnosci transakcji
     *
     * @param string $pay_status wartosc pola pay_status z tabeli order_register
     */
    function delivery_zone_row($rec) {
        global $config;
        global $DOCUMENT_ROOT;

        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        include ("$DOCUMENT_ROOT/go/_options/_delivery/_zone/html/zone_row.html.php");
        return;
    } // end delivery_zone_row

} // end class ThemeLocal

$theme = new ThemeLocal;
?>
