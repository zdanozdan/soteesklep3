<script language='JavaScript'>
<!--
/**
 * Funckja zmieniajaca zawartosc zaleznego elementu SELECT w zaleznosci od warosci drugiego elementu SELECT
 * 
 * @author  m@sote.pl
 * @version $Id: selectChange.js,v 1.3 2003/12/16 22:46:42 maroslaw Exp $ 
 *
 * @param object form     adres formularza: this.form
 * @param object my       adres elementu wywolujacego funkcje: this
 * @param string attrName nazwa zmeinianego elementu formularza
 * @param string attr     sformatowane dane okreslajace wartosci zmienianego elementu w zaleznosci od wart. elementu: my
 */
function selectChange (form,my,attrName,attr) {   
   var attrValue   = my.value;
   
   // przeksztalc attrValue na warotsc jesli dane sa postaci IMG:wartosc:/photo/zdjecie.jpg
   var myRegExp4=/:/;
   var tabvalue=attrValue.split(myRegExp4);
   if (tabvalue.length>0) {
     attrValue=tabvalue[1];   
     imgChange(my);
   }
      
   // ustal obiekt elementu formularza, ktory bedzie zmieniany   
   var numFormElements = form.elements.length;
   for (var elementIndex = 0 ; elementIndex < numFormElements; elementIndex++ ) {
     var formElement = form.elements[elementIndex];
     
     if (formElement.name == attrName) {
         destName=form.elements[elementIndex];         
     }
   }

   // sprawdz, czy sa zapamietane elementy obiektu form w polu attr_memory
   // format danych   
   if (form.attr_memory.value=='null') {       
       // zapamietaj dane wejciowe elementu select w parametrze attr_memory
       attrSetMemory(form,destName);
   }
   
   var myRegExp = /;/;
   var myRegExp2= /->/;
   var myRegExp3= /,/;  
   var results = attr.split(myRegExp);   // L->zielony,niebieski; XL->czerwony,zolty
   var data = new String;
   var attrV2 = new String;
   var attr2Vdefined = new String;
   var i=0;
   var item=0;

   for (item=0;item<results.length;item++) {    
      data=results[item];         
      data2=data.split(myRegExp2);      // data2[0]=L; data2[1]=zielony,niebieski
              
      if (data2[0]==attrValue) {        // L==L  
        
        // odczytaj elementy tablicy
        listElements = data2[1].split(myRegExp3); // zielony;niebieski

        // zeruj tablice select i ustaw liczbe elementow tablicy
        destName.options[0] = null;           
        destName.options.length = listElements.length;                 
        
        for (i=0;i<listElements.length;i++) {
            attrV2=listElements[i];
            attrV2Defined=attrGetMemory(form,attrV2);
            myNewOption = new Option (attrV2Defined,attrV2);
            destName.options[i]=myNewOption;
        }       
      } 
            
   }

} // end selectChange()

/**
* Zapamietaj dane elementu select 
*
* @param object form     formularz
* @param object destName modyfikowany element select
* @return none
*/
function attrSetMemory(form,destName) {
    var l=destName.options.length;
    var i=0;
    var memVal = new String;
    
    memVal='';
    for (i=0;i<l;i++) {
        // memVal = wartosc=>tekst\n wartosc2=>tekst2\n        
        memVal=memVal+destName.options[i].value+'=>'+destName.options[i].text;
        if (i<l-1) {
            memVal=memVal+'\n';   
        }
    } // end for
    
    form.attr_memory.value=memVal;
    
    return;
} // end attrSetMemory()


/**
* Odczytaj zapamietane dane elementu select i podstaw je pod odpowiednie pole formularza
*
* @param  object form   formularz
* @param  object option nazwa opcji (wartosc)
* @return string text wyswietlany przy danej opcji select
*/
function attrGetMemory(form,option) {
    var memRegExp = /\n/;
    var memRegExp2 = /=>/;
    
    var data  = form.attr_memory.value.split(memRegExp);
    var ldata = data.length;

    var textVal = new String;   
    
    for (i=0;i<ldata;i++) {
        data2=data[i].split(memRegExp2);
        textVal = data2[1];
        if (data2[0]==option) return textVal;
    } // end for
    
    return;
} // end attrGetMemory()

/**
 * Example:
 * 
 * <form name=myForm>
 * <input type=hidden name=attr_memory>
 * <select name=options[attr_1] onChange='selectChange(this.form,this,"options[attr_2]","czerwony->S,M,L;niebieski->L,XL");'>
 * <option value=czerwony>czerwony</option>
 * <option value=niebieski>niebieski</option>
 * </select>
 * <select name=options[attr_2]>
 * <option value=S>S</option>
 * <option value=M>M</option>
 * <option value=L>L</option>
 * <option value=XL>XL</option>
 * </select>
 * </form>
 */
-->
</script>