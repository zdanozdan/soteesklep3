<?php
/**
* Create dbf file from structures
*
* @author      Robert Diak <rdiak@sote.pl>
* @version     1.0
* @since       PHP 4.0.3pl1
*/

include_once("include/metabase.inc");

class NewsletterControl {
    // {{{ properties

    /**
     * String actually query to database;
     * @var  array
     * @access   private
     */
    var $_query = '';

    /**
     * Name of saved file
     * @var  string
     * @access   private
     */
    var $_filename = '';

    /**
     * Status sending of newsletter
     * @var  string
     * @access   private
     */
    var $_status = 0;

    /**
     * Status sending of newsletter
     * @var  string
     * @access   private
     */
    var $_dataEmail = array();
    
    // {{{ constructor

    /**
     * Class constructor
     * @param    string      $query          query to database.
     * @access   public
     */
    function NewsletterControl() 
    {
    	global $DOCUMENT_ROOT;
		$this->_filename="$DOCUMENT_ROOT/tmp/newsletter_email.txt";
		return true;
    } // end constructor

	/**
     * Check query
     *
     * @param     string    $query   query to database
     * @access    public
     * @return    void
     */
    function checkQuery($query='') 
    {
    	global $database;
    	if(!empty($query)) {
    		$this->_id=$database->sql_select("id","newletter_status","status=0","ORDER BY id DESC LIMIT 1");
			if($this->_id) {
				// jesli jest jakis niedokonczony newsletter w bazie to go wyciagnij
				$query=$database->sql_select("query","newletter_status","id=$this->_id");
				// wczytaj do tablicy adresy do ktorych zosta³ juz wyslany newsletter
				$this->_readSendEmail("r");
				$this->_status=1;
			} else {
				// stworz czysty plik do zapisu
				$this->_fd=fopen($this->_filename,"w");
    			fclose($this->_fd);
			}
    	}
    	$this->_query=$query;
    	return $query;
    } // end func checkQuery

    /**
     * Odczytanie adresow email z pliku i wpisanie ich do tablicy
     *
     * @param     string    $mode  tryb otwarcia pliku
     * @access    public
     * @return    void
     */
    function _readSendEmail($mode) 
    {
    	$this->_fd=fopen($this->_filename,"r");
		if(!empty($this->_fd)) {
			$contents = fread ($this->_fd, filesize ($this->_filename));
			$this->_dataEmail=preg_split("/\n/",$contents,-1,PREG_SPLIT_NO_EMPTY);
			$this->_dataEmail=array_flip ($this->_dataEmail);
			fclose($this->_fd);
		}	
    	return;
    } // end func _readSendEmail
    
    /**
     * Save information about newsletter in database
     *
     * @param     string    $email   address email
     * @access    public
     * @return    void
     */
    function checkOldEmail($email) 
    {
    	if(!empty($email)) {
			if(array_key_exists($email, $this->_dataEmail)) {    	
    			return false;
			}
    	}
		return true;
    } // end func checkOldEmail
    
    /**
     * Save information about newsletter in database
     *
     * @param     string    $query   query to database
     * @access    public
     * @return    void
     */
    function saveInformation() 
    {
    	global $database;
    	if(!empty($this->_query)) {
    		$result=$database->sql_insert("newletter_status",array(
    														"query"=>$this->_query,
    														"start_date"=>date("Y-m-d H:i:s"),
    														"status"=>0
    														)
    							);
    		if(!$result) {
    			print $lang->no_save_db;
    			exit;
    		} else {
    			$this->_id=$database->sql_select("max(id)","newletter_status");
    		}
    	}													
    	return;
    } // end func saveInformation

     /**
     * Save information about newsletter in database
     *
     * @param     string    $query   query to database
     * @access    public
     * @return    void
     */
    function saveEmailToFile($email='')
    {
    	if(!empty($email)) {
	    	$this->_fd=fopen($this->_filename,"a+");
  			fputs($this->_fd,$email."\n");
    		fclose($this->_fd);
    	}	
    	return true;
    } // end func saveEmailToFile
    
     /**
     * Save information about newsletter in database
     *
     * @param     string    $query   query to database
     * @access    public
     * @return    void
     */
    function endAction($send_ok,$send_error,$send_leave) {
    	global $database;
    	// updatejtujemy baze danych
    	$count=$send_ok.":".$send_error.":".$send_leave;
    	$database->sql_update("newletter_status","id=$this->_id",array(
			  														"stop_date"=>date("Y-m-d H:i:s"),
    																"status"=>1,
    																"count"=>$count
    											)
    						);					
    } // end func endAction
} // end class NewsletterControl;    