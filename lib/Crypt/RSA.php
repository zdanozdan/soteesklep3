/**
* Class providing functions to handle RSA encryption/decryption
*
* @package Crypt_RSA
* @author  Christian Dickmann <dickmann@php.net>
* @version 1.0
**/

class Crypt_RSA
{
    function Crypt_RSA()
    {
    }
    

    /**
     * Generate prime number with specified number of bits
     *
     * @param integer $bits Number of bits of the generated prime number
     * @return ressource GMP Ressource of the generated prime number
     *
     * @access private
     **/
    function _genPrime($bits)
    {
        $p = gmp_random($bits / 32);
        if (gmp_cmp(gmp_and($p, 1), 1) != 0) { // is even?
            $p = gmp_add($p, 1); // $p++
        };
        
        while(gmp_prob_prime($p) == 0) {
            $p = gmp_add($p, $this->two); // $p += 2
        };
        // now $p is prime
        return $p;    
    }    
    
    /**
     * Generate a RSA key with the specified number of bits
     *
     * @param integer $bits Number of bits of Key-Modulo (n)
     * @return array Associative Array with the 3 components which build a RSA key (n = Modulo, e = private component, v = public component)
     **/
    function generateKey($bits)
    {
        $p = $this-> _genPrime($bits / 2);
        $q = $this-> _genPrime($bits / 2);
        
        $n = gmp_mul($p, $q);
        
        $phi = gmp_mul(gmp_sub($p, 1), gmp_sub($q, 1)); // $phi = ($p - 1) * ($q - 1)
        
        $v = $this-> _genPrime(64);
        if (gmp_cmp(gmp_and($p, 1), 1) != 0) {
            $v = gmp_add($v, 1);
        };
        while(gmp_cmp(gmp_gcd($v, $phi), 1) != 0){
            $v = gmp_add($v, 2);
        } // while
        
        $e = gmp_invert($v, $phi);
        
        var_dump(gmp_strval($p, 16));
        var_dump(gmp_strval($q, 16));
        var_dump(gmp_strval($n, 16));
        var_dump(gmp_strval($phi, 16));
        var_dump(gmp_strval($v, 16));
        var_dump(gmp_strval($e, 16));
        return array(
            'n' => $n,
            'v' => $v,
            'e' => $e,
            );
    }
    
    /**
     * Encrypt message with RSA
     *
     * @param mixed $msg If integer or GMP ressource, this number is used as message. If string, the value is interpreted as the decimal representation of the message
     * @param array $key RSA key. Needs Modulo and public key component
     * @return ressource GMP Ressource of chiffre text
     **/
    function encrypt($msg, $key)
    {
        if (is_int($msg) || is_string($msg)) {
            $msg = gmp_init($msg);
        };
    
        $chiffre = gmp_powm($msg, $key['v'], $key['n']);
        return $chiffre;
    }
    
    /**
     * Decrypt chiffre text with RSA
     *
     * @param ressource $chiffre GMP ressource of chiffre text
     * @param array $key RSA key. Needs Modulo and private key component
     * @return ressource GMP ressource of plaintext message
     **/
    function decrypt($chiffre, $key)
    {
        $msg = gmp_powm($chiffre, $key['e'], $key['n']);
        return $msg;
    }
    
    /**
     * Sign a message with RSA
     *
     * @param ressource $chiffre GMP ressource of text to sign
     * @param array $key RSA key. Needs Modulo and private key component
     * @return ressource GMP ressource of signed message
     **/
    function sign($chiffre, $key)
    {
        return $this->decrypt($chiffre, $key);
    }

    /**
     * Verify the signature of a message with RSA
     *
     * @param mixed $msg If integer or GMP ressource, this number is used as message. If string, the value is interpreted as the decimal representation of the message
     * @param array $key RSA key. Needs Modulo and public key component
     * @return ressource GMP Ressource of plain message
     **/
    function verify($msg, $key)
    {
        return $this->encrypt($msg, $key);
    }
    
    /**
     * Save RSA Key to File (using a simple, non-standard type)
     *
     * @param string $filename Filename
     * @param array $key RSA key
     * @param boolean $private (optional) Save private key component too?
     * @return boolean true on success, false on error
     **/
    function saveKeyToFile($filename, $key, $private = false)
    {
        $fp = fopen($filename, "w");
        if ($fp === null) {
            return false;
        };
        fwrite($fp, gmp_strval($key['n'], 16));
        fwrite($fp, "|");
        fwrite($fp, gmp_strval($key['v'], 16));
        if ($private) {
            fwrite($fp, "|");
            fwrite($fp, gmp_strval($key['e'], 16));
        };
        fclose($fp);
        return true;
    }
    
    /**
     * Get RSA Key from file (using a simple, non-standard type)
     *
     * @param string $filename Filename
     * @return array associative RSA Key array
     **/
    function getKeyFromFile($filename)
    {
        $fp = fopen($filename, "r");
        if ($fp === null) {
            return false;
        };
        $content = fread($fp, filesize($filename));
        $content = explode("|", $content);
        
        $key['n'] = gmp_init('0x'.$content[0]);
        $key['v'] = gmp_init('0x'.$content[1]);
        if (isset($content[2])) {
            $key['e'] = gmp_init('0x'.$content[2]);
        };
        return $key;
    }
    
    /**
     * Encode String for the use with Crypt_RSA::encrypt()
     *
     * @param string $msg Message to be encoded
     * @return ressource GMP ressource of encoded message
     **/
    function encode($msg)
    {
        $msg = (string) $msg;
        $code = gmp_init(0);
        for ($i = strlen($msg) - 1; $i >= 0; $i--) {
            $code = gmp_mul($code, 256);
            $code = gmp_add($code, ord($msg{$i}));
        };
        return $code;
    }
    
    /**
     * Decode String which has been originally encoded to be used with Crypt_RSA::encrypt()
     *
     * @param ressource $code GMP ressource of encoded message
     * @return string Plaintext message
     **/
    function decode($code)
    {
        $msg = '';
        while(gmp_cmp($code, 0) != 0){
            list($code, $remain) = gmp_div_qr($code, 256);
            $msg .= chr(gmp_intval($remain));
        } // while
        return $msg;
    }
};

function send($fp, $msg)
{
    $len = strlen($msg);
    if ($len > 65535) {
        return;
    };
    $_len = chr($len >> 8) . chr($len % 256);
    socket_write($fp, $_len);
    socket_write($fp, $msg);
}

function recv($fp)
{
    $_len = socket_read($fp, 2);
    $len = ord($_len{0})*256 + ord($_len{1});

    $str = socket_read($fp, $len);
    return $str;
}

// Testing code follows:
exit;

// Initialize RSA class
$rsa = new Crypt_RSA();    

// Generate or load Keys
if (!file_exists('server.private.key')) {
    $serverKey = $rsa->generateKey(1024);
    $clientKey = $rsa->generateKey(1024);
    
    $rsa->saveKeyToFile('server.private.key', $serverKey, true);
    $rsa->saveKeyToFile('server.public.key',  $serverKey, false);

    $rsa->saveKeyToFile('client.private.key', $clientKey, true);
    $rsa->saveKeyToFile('client.public.key',  $clientKey, false);
} else {
    $serverKey = $rsa->getKeyFromFile('server.private.key');
    $clientKey = $rsa->getKeyFromFile('client.public.key');
};

// Server Socket erstellen
$sock = socket_create (AF_INET, SOCK_STREAM, 0);

// Server an IP Adresse und Port binden
$ret  = socket_bind($sock, '192.168.0.5', 3000);
$ret  = socket_listen($sock, 5);

// In Schleife zur Abarbeitung von Clientverbindungen treten
while(true){
    // Client Connection aufbauen
    $csock = socket_accept($sock);
    echo "Client connected (".date("d.m.Y h:i").")\n";
    // Passwort empfangem, entschl-Büsseln, verifizieren und decodieren-A
    $pass  = gmp_init('0x'.recv($csock));
    $pass  = $rsa->decrypt($pass, $serverKey);
    $pass  = $rsa->verify($pass, $clientKey);
    $pass  = $rsa->decode($pass);
    echo "PASS: $pass\n";
    
    // Passwort pr-Büfen und Response festlegen-A
    if ($pass == 'test@unsinn.de') {
        $msg = 'OK';
    } else {
        $msg = 'FAILED';
    };
    
    echo "MSG: $msg\n";
    // Response verschl-Büsseln und senden-A
    $msg = $rsa->encode($msg);
    $msg = $rsa->encrypt($msg, $clientKey);
    send($csock, gmp_strval($msg, 16));
    
    // Socketverbindung mit Client beenden
    socket_close($csock);    
} // while

// Connect to Server
$fp = fsockopen('192.168.4.3', 3000);

// Encode Passphrase
$msg = $rsa->encode($_SERVER['argv'][1]);

// Sign Pass with our Digital Signature
$chiffre = $rsa->sign($msg, $serverKey);

// Encrypt signed Pass with Servers Public Key
$chiffre = $rsa->encrypt($chiffre, $clientKey);

// Send encrypted signed Pass
send($fp, gmp_strval($chiffre, 16));

echo "Waiting for the Server to respond ... \n";

// Receive encrypted Response
$chiffre = gmp_init('0x'.recv($fp));

// Decrypt encrypted response with our Private Key
$msg = $rsa->decrypt($chiffre, $serverKey);

// Decode Response
$msg = $rsa->decode($msg);

// Output decoded Response
var_dump($msg);

// Close Connection
fclose($fp);
?> 