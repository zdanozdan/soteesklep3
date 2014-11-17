<?php
/**
* @version    $Id: send.php,v 1.5 2005/10/25 09:24:23 krzys Exp $
* @package    recommend
*/

$global_database=false;
$global_secure_test=true;
global $_POST;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("lib/Mail/MyMail.php");

$mail = new MyMail;

if (! empty($_POST['friend_email'])) {
	$friend_email=$_POST['friend_email'];
}

if (! empty($_POST['your_email'])) {
	$your_email=$_POST['your_email'];                        // przypisz adres email wysylajacego
} else {
	$your_email=$config->recommend_email;                    // w przeciwnym wypadku pobierz adres z config
}

if (! empty($_POST['id'])) {
	$id=$_POST['id'];
}

if (! empty($_POST['product'])) {
	$product=urldecode($_POST['product']);
}

$recommend_id_user=@$_SESSION['global_id_user'];
$user_id_main=$_REQUEST['id'];
$time=time();
$key="soteszyfr";

$string=$recommend_id_user.$user_id_main.$time.$key;
$crypt_string=md5($string);

$host=$_SERVER['HTTP_HOST'];                                 // nazwa hosta

$mypath="$DOCUMENT_ROOT/themes/_$config->lang/_html_files";   // sciezka do plikow z html_files

// sprawdzenie czy klient poleca sklep czy produkt
if ($_POST['shop']==1) {                                     // polecamy sklep

$shop_link="http://$host";                               // link do sklepu
$subject=$lang->recommend_shop_subject.$host;            // temat maila polecajacego sklep

// start naglowek
$filename="recommend_head_shop.html";                    // plik czytany z html_files
$fd=fopen("$mypath/$filename","r");                      // pobranie deskryptora pliku
$contents= fread ($fd, filesize ("$mypath/$filename"));  // czytanie zawartosci pliku
$order_body=$contents;                                   // naglowek z pliku dolaczony do maila
fclose ($fd);                                            // zamykanie pliku
// stop naglowek

$order_body.="\n\n";
$order_body.=$shop_link;
$order_body.="\n\n";

// start stopka
$filename="recommend_foot_shop.html";                     // plik czytany z html_files
$fd=fopen("$mypath/$filename","r");                       // pobranie deskryptora pliku
$contents = fread ($fd, filesize ("$mypath/$filename"));  // czytanie zawartosci pliku
$order_body.=$contents;                                   // stopka z pliku dolaczona do maila
fclose ($fd);                                             // zamykanie pliku
// stop stopka

} else {                                                      // polecamy produkt

if ((! empty($_SESSION['global_id_user'])) && (! empty($_SESSION['global_login']))){
	$product_link="http://$host/?id=$id&recom_code=$crypt_string&recom_product=$id&recom_user=$recommend_id_user&recom_t=$time";
}else{
	$product_link="http://$host/?id=$id";
}
// link do produktu

$subject=$lang->recommend_product_subject;                // temat maila
$subject.=$lang->recommend_shop.$host;

// start naglowek
$filename="recommend_head_product.html";                  // plik czytany z html_files
$fd=fopen("$mypath/$filename","r");                       // pobranie deskryptora pliku
$contents = fread ($fd, filesize ("$mypath/$filename"));  // czytanie zawartosci pliku
$order_body=$contents;                                    // naglowek z pliku dolaczony do maila
fclose ($fd);                                             // zamykanie pliku
// stop stopka

$order_body.="\n\n";
$order_body.=$lang->recommend_product_body.$product;
$order_body.="\n\n";
$order_body.=$product_link;
$order_body.="\n\n";

// start stopka
$filename="recommend_foot_product.html";                   // plik czytany z html_files
$fd=fopen("$mypath/$filename","r");                        // pobranie deskryptora pliku
$contents = fread ($fd, filesize ("$mypath/$filename"));   // czytanie zawartosci pliku
$order_body.=$contents;                                    // stopka z pliku dolaczona do maila
fclose ($fd);                                              // zamykanie pliku
// stop stopka

}

// parametry maila
$from=@$your_email;  // od kogo
$to=@$friend_email;  // do kogo
$reply=$from;

// wysylam maila
if(($mail->send($from,$to,$subject,$order_body,$reply)) && (! empty($_POST['friend_email']))) {
	$theme->theme_file("plugins/_recommend/recommend_send_ok.html.php");         // udalo sie wyslac maila
} elseif (empty($_POST['friend_email'])) {
	$theme->theme_file("plugins/_recommend/recommend_send_error1.html.php");     // nie podales maila adresata !
} else {
	$theme->theme_file("plugins/_recommend/recommend_send_error.html.php");      // nie udalo sie wyslac
};

?>
