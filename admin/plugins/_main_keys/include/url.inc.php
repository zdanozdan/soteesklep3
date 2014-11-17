<?php
/**
* Sprawdz, czy dany kod jest powiazany z plikiem z main_keys_ftp. Jesli
* tak, to generuj odpowiedni link url odpowiadajacy kodowi
*
* @author  m@sote.pl
* @version $Id: url.inc.php,v 1.3 2004/12/20 18:00:03 maroslaw Exp $
*
* @param array $this->data dane rekordu z main_keys
* @package    main_keys
*/

global $mdbd,$config;
if (@$this->secure_test!=true) die ("Forbidden");

$ftp=$mdbd->select("ftp","main_keys_ftp","user_id_main=?",array($this->data['user_id_main']=>"text"),"LIMIT 1");
if (! empty($ftp)) {
       $this->data['main_key_md5']=md5($my_crypt->endecrypt("",$this->data['main_key']));       
       $this->data['url']="http://".$config->www.$config->url_prefix."/plugins/_main_keys/$ftp?code=".
       $this->data['main_key_md5'];
} else $this->data['url']='';
?>
