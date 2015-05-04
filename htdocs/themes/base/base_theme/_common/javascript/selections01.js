var selectedRadio = null;
var deliverySelected = null;

function onFormSubmit(f) 
{
   if (selectedRadio == null) {
      setStyleById("wp","font","normal 17px Tahoma");
      setStyleById("wp","color","#FF0000");
      setStyleById("wp","display","block");
      setStyleById("wp1","font","normal 12px Tahoma");
      setStyleById("wp1","color","#808080");
      setStyleById("wp1","display","block");
      return false;
   }
   return true;
}

function clearSelections() 
{
   selectedRadio = null;
   for(var x = 1; x < 7; x++) {
      var s = "sel_" + x;
      setStyleById(s,"color","#004080");
      setStyleById(s,"font","normal 13px Tahoma");
      s=s+"1";
      setStyleById(s,"color","#004080");
      setStyleById(s,"font","normal 13px Tahoma");
   }
}

function changeSelection(row) 
{
   clearSelections();
   selectedRadio = row;
   setStyleById(row,"font","normal 13px Tahoma");
   setStyleById(row+"1","font","normal 13px Tahoma");
   setStyleById(row,"color","#BB0000");
   setStyleById(row+"1","color","#BB0000");
}

function select_current()
{
   deliverySelection(deliverySelected);
}

function deliverySelection(row) 
{
   if (deliverySelected != null)
   {
      setStyleById(deliverySelected,"color","#004080");
      setStyleById(deliverySelected,"font","normal 13px Tahoma");
      setStyleById(deliverySelected+"1","color","#004080");
      setStyleById(deliverySelected+"1","font","normal 13px Tahoma");
      setStyleById(deliverySelected+"2","color","#004080");
      setStyleById(deliverySelected+"2","font","normal 13px Tahoma");
   }
   setStyleById(row,"font","normal 13px Tahoma");
   setStyleById(row,"color","#BB0000");
   setStyleById(row+"1","font","normal 13px Tahoma");
   setStyleById(row+"1","color","#BB0000");
   setStyleById(row+"2","font","normal 13px Tahoma");
   setStyleById(row+"2","color","#BB0000");
   deliverySelected = row;
}
