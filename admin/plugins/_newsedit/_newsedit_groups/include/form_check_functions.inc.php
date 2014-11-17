<?php
/**
* Sprawd¼ poprawno¶æ formularza, dodatkowe funkcje.
*
* @author  m@sote.pl
* \@template_version Id: form_check_functions.inc.php,v 2.3 2003/06/14 21:59:37 maroslaw Exp
* @version $Id: form_check_functions.inc.php,v 1.4 2005/07/18 07:17:37 lukasz Exp $
*
* \@global  int $this->id
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/
class FormCheckFunctions extends FormCheck {
	
    /**
     * Sprawdzanie czy ju¿ s± 3 grupy o atrybucie multi
     *
     * @author Lukasz Andrzejak
     * @param int $multi
     */
    function multi($multi)
    {
    	if ($multi==1) {
	    	global $db;
    		$query = "SELECT id FROM newsedit_groups WHERE multi='1'";
	    	$preparedquery = $db->PrepareQuery($query);
	    	$result=$db->ExecuteQuery($preparedquery);
	    	$num_rows=$db->NumberOfRows($result);
			if ($num_rows>=3) {
					return false;
			}
    	}
    	return true;
    } // end function multi
    // lokalne definicja fukcji sptrawdzajacych poprawnosc pol formularza
} // end class FormCheckFunctions
?>
