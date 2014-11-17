<?php
/**
 * PHP Template:
 * Dodaj rekord do tabeli discounts_groups
 * 
 * @author m@sote.pl
 * \@template_version Id: add.php,v 2.1 2003/03/13 11:28:47 maroslaw Exp
 * @version $Id: add.php,v 1.4 2005/01/20 14:59:51 maroslaw Exp $
* @package    discounts
* @subpackage discounts_groups
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php

// dodaj obsluge ftp, wymagane przy uploadowaniu plikow i generowaniu pliku konfiguracyjnego
require_once ("include/ftp.inc.php");

// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("include/gen_user_config.inc.php");

$__edit="add";

// zalacz zdjecie
if (! empty($_FILES['item']['name']['photo'])) {
    $file=$_FILES['item'];
    $datafile=$file['name']['photo'];
    $datafile_tmp=$file['tmp_name']['photo'];
    $_POST['item']['photo']=$datafile;
    $ftp->connect();    
    $ftp->put($datafile_tmp,"$config->ftp_dir/htdocs/photo/_discounts_groups",$datafile);
    $ftp->close();
}


$theme->head_window();
$theme->bar($lang->discounts_groups_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("discounts_groups","",array("user_id"=>"user_id",
                                            "group_name"=>"string",
                                            "start_date"=>"start_date",
                                            "end_date"=>"end_date"),
                $lang->discounts_groups_form_errors
                );

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
