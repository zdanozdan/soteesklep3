<script language="JavaScript">
/**
* Zaznacz wszystkie rekordy del[x]
*
* @param object obiekt formularza
* @return void
* @version    $Id: select_all.js,v 1.2 2004/12/20 18:01:27 maroslaw Exp $
* @package    themes
*/
function select_all(form) {
    var indexLength=form.elements.length;
    var indexNum=0;
    
    for (indexNum=0;indexNum<indexLength;indexNum++) {        
        var formElement=form.elements[indexNum];
        formElement.checked=1;        
    } // end for
    
    return;
} // end select_all()
</script>
