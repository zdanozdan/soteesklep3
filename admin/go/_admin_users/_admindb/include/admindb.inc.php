<?PHP
/**
* Klasa kasowania zawartosci tabel w bazie danych
*
* @author rdiak@sote.pl
* @version $Id: admindb.inc.php,v 1.8 2005/03/29 13:11:37 scalak Exp $
* @package    admin_users
* @subpackage admindb
*/


/**
* Klasa AdminDb
*
* @package admin_users
* @subpackage admin
*/
class AdminDB {
    
    /**
    * Konstruktor obiektu AdminDbAction
    *
    * @return boolean true/false
    */
    function AdminDb() {
        return true;
    } // end AdminDb
    
    /**
    * G³owna funkcja klasy AdminDbAction
    *
    * @return boolean true/false
    */
    function AdminDbAction() {
        global $_REQUEST;
        global $lang;
        if(!empty($_REQUEST['update'])) {
            $this->AdminDbDelete();
        }
        include_once("./html/admindb.html.php");
        return true;
    } // end AdminDbAction
    
    /**
    * Funkcja kasuj±ca dane a tabel
    *
    * @return boolean true/false
    */
    function AdminDbDelete() {
        global $_REQUEST;
        global $mdbd;
        global $lang;
        if(!empty($_REQUEST['item'])) {
            $data=$_REQUEST['item'];
        } else {
            $data='';
        }
        if(!empty($data)) {
            foreach($data as $key=>$value) {
                if($data[$key] == 1) {
                    if($key == 'main') {
                        $result=$mdbd->delete('main');
                        $mdbd->resetId('main');
                        $this->printInfo('main',$result);
                    } elseif($key == 'mainand' ) {
                        $result=$mdbd->delete('main');
                        $mdbd->resetId('main');
                        $this->printInfo('main',$result);
                        $result=$mdbd->delete('main_param');
                        $this->printInfo('main_param',$result);
                        $result=$mdbd->delete('category1');
                        $mdbd->resetId('category1');
                        $this->printInfo('category1',$result);
                        $result=$mdbd->delete('category2');
                        $mdbd->resetId('category2');
                        $this->printInfo('category2',$result);
                        $result=$mdbd->delete('category3');
                        $mdbd->resetId('category3');
                        $this->printInfo('category3',$result);
                        $result=$mdbd->delete('category4');
                        $mdbd->resetId('category4');
                        $this->printInfo('category4',$result);
                        $result=$mdbd->delete('category5');
                        $mdbd->resetId('category5');
                        $this->printInfo('category5',$result);
                        $result=$mdbd->delete('producer');
                        $mdbd->resetId('producer');
                        $this->printInfo('producer',$result);
                    } elseif( $key == 'users' ) {
                        $result=$mdbd->delete('users');
                        $mdbd->resetId('users');
                        $this->printInfo('users',$result);
                    } elseif( $key == 'order' ) {
                        $result=$mdbd->delete('order_register');
                        $mdbd->resetId('order_register');
                        $this->printInfo('order_register',$result);
                        $result=$mdbd->delete('order_id');
                        $mdbd->resetId('order_id');
                        $this->printInfo('order_id',$result);
                        $result=$mdbd->delete('order_products');
                        $mdbd->resetId('order_products');
                        $this->printInfo('order_products',$result);
                    }
                }
            }
        } else {
            print "<br><b>".$lang->admindb_noselected."</b><br>";
        }
        return true;
    } // end AdminDbDelete
    
    /**
    * Funkcja printuje komunikat na strone o skasowaniu zawartosci tabeli
    *
    * @return boolean true/false
    */
    function printInfo($table,$result) {
        global $lang;
        if($result) {
            print "<b>".$table."::".$lang->admindb_deleted."</b><br>";
        } else {
            print "<b>".$table."::".$lang->admindb_nodeleted."</b><br>";
        }
        return true;
    } // end printInfo
} // end class AdminDB
?>
