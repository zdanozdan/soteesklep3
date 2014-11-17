<?php
/**
 * Generowanie sumy kontrolnej. Sprawdzenie loginu i hasla administratora sklepu
 *
 * @author  m@sote.pl
 * @version $id$
* @package    setup
 */
 
class AuthSign {
    function gen($login,$password) {
        global $DOCUMENT_ROOT;

        $md5_code=md5($login.$password);
        
        $php="<?php\n";
        $php.="\$global_auth_sign='$md5_code';\n";
        $php.="?>";
        
        $fd=fopen("$DOCUMENT_ROOT/setup/tmp/auth_sign.php","w+");
        fwrite ($fd,$php,strlen($php));
        fclose($fd);

        return;
    } // end gen()
} // end class AuthSign

?>
