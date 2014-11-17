<?php 
/**
* Obs³uga koszyka. Wykonywanie podstawowych operacji na koszyku.
*
* @author  m@sote.pl
* @version $Id: basket.php,v 2.7 2005/12/13 08:41:33 lukasz Exp $
* @package basket
* @subpackage basket_lib
*/

class Basket {
    
    /* @var array lista pozycji w koszyku */
    var $items=array();
    
    /**
    * @var int aktualny numer na podstawie którego wyliczne jest ID, zawsze + 1
    *          chodzio unikniêcie sytuacji w której po skasowaniu jakiej¶ pozycji z koszyka
    *          inna pozycjia przejmuje ID wcze¶niej skasowanej
    * @access private
    */
    var $_count=0;
    
    /**
    * Ilo¶c pozycji w koszyku
    *
    * @return int
    */
    function count() {
        return sizeof($this->items);
    } // end count()
    
    /**
    * Odczytaj bie¿±cy ideks koszyka
    * @return none
    */
    function getCount() {
        return $this->_count;
    } // end getCount()
    
    /**
    * Dodaj pozycje do koszyka
    *
    * @param string $ID    id pozycji w koszyku
    * @param string $name  nazwa pozycji w koszyku
    * @param string $num   ilo¶æ
    * @param float  $price cena
    * @param array  $data  parametry dodatkowe, opcje itp.
    *
    * @return none
    */
    function add($ID,$name,$num=1,$price=0,$data=array(),$points_value=0) {
        $this->items[++$this->_count]=array("ID"=>$ID,"name"=>$name,"num"=>$num,"price"=>$price,"data"=>$data,"points_value"=>$points_value);
        return;
    } // end add()
    
    /**
    * Odczytaj cenê pozycji
    *
    * @param int $id id systemowe pozycji w koszyku
    *
    * @return float
    */
    function getPrice($id) {
        if (! empty($this->items[$id]['price'])) return $this->items[$id]['price'];
        return 0;
    } // end getPrice()
    
    /**
    * Odczytaj ilo¶æ dla danej pozycji
    *
    * @param int $id id systemowe pozycji w koszyku
    *
    * @return int
    */
    function getNum($id) {
        if (! empty($this->items[$id]['num'])) return $this->items[$id]['num'];
        return 0;
    } // end getNum()
    
    /**
    * Odczytaj dane dodatkowe do pozycji
    *
    * @param int $id id systemowe pozycji w koszyku
    *
    * @return int
    */
    function getData($id) {
        if (! empty($this->items[$id]['data'])) return $this->items[$id]['data'];
        return 0;
    } // end getData()
    
    /**
    * Odczytaj id systemowe dla danej pozycji
    *
    * @param int   $ID id pozycji w koszyku
    * @param array parametry dodatkowe
    *
    * @return int
    */
    function getId($ID,$data) {
        if (! empty($this->items)) {
            foreach ($this->items as $id=>$item) {
                if (($item['data']==$data) && ($item['ID']==$ID)) return $id;
            }
        }
        return 0;
    } // end getId()
    
    /**
    * Usuñ pozycjê z koszyka
    *
    * @param int $id id systemowe pozycji
    *
    * @return none
    */
    function del($id) {
        unset($this->items[$id]);
    } // end del()
    
    /**
    * Ustal ilo¶æ danego pozycji w koszyku
    *
    * @param int $id  id systemowe pozycji
    * @param int $num ilo¶æ
    *
    * @return none
    */
    function setNum($id,$num) {
        $this->items[$id]['num']=$num;
        return;
    } // end setNum
    
    /**
    * Ustal dane doadatkowe do pozycji w koszyku
    *
    * @param int $id   id systemowe pozycji
    * @param int $data dane dodatkowe
    *
    * @return none
    */
    function setData($id,$data) {
        $this->items[$id]['data']=$data;
        return;
    } // end setNum
    
    /**
    * Odczytaj dane pozycji z koszyka
    *
    * @param int $id id systemowe pozycji
    *
    * @return array tablica z danymi pozycji koszyka
    */
    function getInfo($id) {
        if (! empty($this->items[$id])) return $this->items[$id];
        return array();
    } // end getInfo()
    
    /**
    * Skasuj zawarto¶æ koszyka.
    */
    function emptyBasket() {
        $this->_count=0;
        $this->items=array();
        return;
    } // end emptyBasket()
    
    
} // end class Basket

// UWAGA! na koncu nie moze byc zadnych znakow
?>