<script language='JavaScript'>
<!--
/**
* Funkcja [bitmapViewer onChange]; funkcja podmieniajaca bitmapy z pola <select>
*
* @author  rp@sote.pl m@sote.pl
* @version $Id: imgChange.js,v 1.1 2006/11/23 16:15:55 tomasz Exp $
*
* @param object myButmap adres zmienianej bitmapy
*/
function imgChange(myBitmap){    
 	var i=myBitmap.selectedIndex;
	var fileName=myBitmap.options[i].value;	
	var myRegExp=/:/;
	var fileName=fileName.split(myRegExp);
	var max=document.getElementsByName('max_images');
	
	//document.write(max[0].value);
	
	//document.photo.src=fileName[2];
	var photo_max=fileName[2].split('/');
	o_photolink = document.getElementById('photolink');
	if(o_photolink != null)
	{
	    //if (max[0].value.search(photo_max[photo_max.length-1]) > -1)
	    //{
	       o_photolink.style.display="inline";
	       //document.write('dziala');
	       o_photolink.href = '/photo/max_'+photo_max[photo_max.length-1];
	   // }
	  // else
	  // o_photolink.style.display="none";
	   
	}   
	o_photo = document.getElementById('photo');
	if(o_photo != null)
	   o_photo.src = fileName[2];

	o_modallink = document.getElementById('modalphoto');
        if(o_modallink != null)
	    o_modallink.src = fileName[2];

	// priceChange(923);
}

// TODO
// function priceChange(price) {    
//    document.price.price_preview.value=price;
//     
//     function priceCalc(param) {
//         return 0;    
//     }
// }

/**
 * Example:
 *
 * <center>
 * <img src="photo/1.jpg" name="photo"> 
 * <form name="attrib">
 *  <select name="selectBitmap" size="1" onChange="imgChange(this)">
 *    <option value="IMG:wartosc1:/photo/1.jpg">Picture 1
 *    <option value="IMG:wartosc2:/photo/2.jpg">Picture 2
 *    <option value="IMG:wartosc3:/photo/3.jpg">Picture 3
 *     <option value="IMG:wartosc5:/photo/4.jpg">Picture 4
 *  </select>
 * </form>
 * </center>
 */
 
-->
</script>
