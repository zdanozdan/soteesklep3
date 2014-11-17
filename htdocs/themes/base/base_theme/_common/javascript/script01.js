function Buttons(){
    inputs = document.getElementsByTagName('input');
    for(i = 0; i < inputs.length; i++){
        if(inputs[i].type != 'image')
            inputs[i].className='input';
        if(inputs[i].type == 'submit')
            inputs[i].className='button';
    }
}
function Init(){
    Buttons();
}

function imageScale(sender, max_size) {
    p=0;
    if (sender.width > max_size) {
        p = (max_size / sender.width);
    }
    else {
        if (sender.height > max_size) {
            p = (max_size / sender.height);
        }
    }
    if(p > 0) {
        sender.width = p * sender.width;
    }
}

function doBlink() {
   var blink = document.all.tags("Blink")
   for (var i=0; i<blink.length; i++)
      blink[i].style.visibility = blink[i].style.visibility == "" ? "hidden" : "" 
}

function startBlink() {
   if (document.all)
      setInterval("doBlink()",1000)
}

function xmlhttpGet(strURL, resultId) {
    var xmlHttpReq = false;
    var self = this;

    //alert(strURL);
    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open('GET', strURL, true);
    self.xmlHttpReq.onreadystatechange = function() 
    {
       elem = document.getElementById(resultId);
       if (self.xmlHttpReq.readyState == 4) 
       {
          if (self.xmlHttpReq.status == 200)
             if (elem != null)
                elem.innerHTML = self.xmlHttpReq.responseText;  
             else
             {
                if (elem != null)
                   elem.innerHTML = "B³±d serwera ! Spróbuj ponownie";  
             }         
       }
    }
    self.xmlHttpReq.send(null);
}

function xmlhttpGetLogin(resultId) 
{
  var log_val=null;
  var log_pass=null;
  var elem = document.getElementById("login_form_left");
  if (elem != null)
     elem.innerHTML = "Proszê czekaæ, logowanie ... ";

  for (i=0; i<document.forms["form_login"].elements.length; i++)
  {
      if (document.forms["form_login"].elements[i].name == "form[login]")
      {
         log_val = document.forms["form_login"].elements[i].value;
      }
      if (document.forms["form_login"].elements[i].name == "form[password]")
      {
         log_pass = document.forms["form_login"].elements[i].value;
      }
  }
  xmlhttpGet("user_login.php?login="+log_val+"&password="+log_pass,resultId);
}

function basketRowDesc(id)
{
   elem = document.getElementById("name_"+id);
   if (elem != null)
      elem.innerHTML = "Przeliczanie cen, proszê czekaæ ...";
   
//    elem = document.getElementById("calculate_"+id);
//    if (elem != null)
//       elem.innerHTML = "...";
   
   elem = document.getElementById("sum_brutto_"+id);
   if (elem != null)
      elem.innerHTML = "...";
   
   elem = document.getElementById("delete_"+id);
   if (elem != null)
      elem.innerHTML = "...";
}

function basketDelete(url, rowId, resultId)
{
   strURL = url+"&row_id="+rowId;
   xmlhttpGet(strURL,resultId);
}

function basketUpdate(url, rowId, elementId, resultId)
{
   if (elementId != null)
   {
      strURL = url+"&row_id="+rowId+"&amount="+elementId.value;
      basketRowDesc(rowId);
      //alert(strURL);
      xmlhttpGet(strURL,resultId);
      // alert("basketUpdate koniec");
   }
}

function basketAdd(url, id, amount, resultId)
{
   strURL = url+"&prod_id="+id+"&amount="+amount;
   xmlhttpGet(strURL, resultId);
}

function basketDeliveryUpdate(url, rowId, elementId, resultId)
{
   var req = false;
   var self = this;

   basketUpdate(url, rowId, elementId, resultId);

   // Mozilla/Safari
   if (window.XMLHttpRequest) {
      self.req = new XMLHttpRequest();
   }
   // IE
    else if (window.ActiveXObject) {
        self.req = new ActiveXObject("Microsoft.XMLHTTP");
    }

    self.req.open('GET', "/go/_basket/ajax_basket.php?action=delivery", true);
    self.req.onreadystatechange = function() 
    {
       elem = document.getElementById("delivery_show");
       if (self.req.readyState == 4) 
       {
          if (self.req.status == 200)
             if (elem != null)
             {
                elem.innerHTML = self.req.responseText;  
                select_current();
             }
             else
             {
                if (elem != null)
                   elem.innerHTML = "B³±d serwera ! Spróbuj ponownie";  
             }         
       }
    }
    self.req.send(null);
}
