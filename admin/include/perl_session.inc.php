<?php
/**
 * Zapisz dane w sesji Perl. nazwa generowanego pliku jest przekazywana do skryptow CGI.
 * Dzieki temu skrypty, te maja dostep waznych danych, bez przesylania ich przez siec, czy zapisywania
 * w plikach konfiguracyjnych, z dostepem dla "wszystkich".
 */
class PerlSession {
    var $perl_path="#!/usr/bin/perl";
    var $perl_head="package session;";
    var $perl_foot="\n1;\n";
    var $vars=array();

    function add($name,$value) {
        $this->vars[$name]=$value;             
        return;
    }

    function delete($name) {
        $this->vars[$name]='';
        return;
    }

    function gen_perl_file() {
        $perl="";
        $perl.=$this->perl_path."\n\n";
        $perl.=$this->perl_head."\n\n";
        while (list($name,$value) = each ($this->vars)) {
            $perl.="\$$name=\"$value\";\n";
        }        
        $perl.=$this->perl_foot;
        return $perl;
    }
}

?>