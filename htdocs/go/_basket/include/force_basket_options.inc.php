<?php

function check_options($id, $xml_options)
{
   // odczytujemy opcje towaru z bazy danych i obliczamy ich rozmiar (ilo¶æ elementów)
   $opt = get_xml_options($id);
   $elements = get_xml_options_no_of_items($opt);
   
   $user_count = 0;

   //echo "elements: ".$elements."<br/>";

   //jesli xml_options sa tablica to jest to typ multi
   if (is_array($xml_options))
   {
      foreach ($xml_options as $item=>$value) 
      {
         //echo $value;
         if (!empty($value))
         {
            if (!eregi("^---",$value) && !eregi("^IMG:---",$value))
            {
               //echo $value;
               $user_count++;
            }
         }
      }
   }
   else
   {
      if (!empty($xml_options))
         $user_count = 1;
   }

   //print "User wybra³ : " . $user_count . " opcje, musi wybraæ : " . $elements . " dla towaru o id=$id";
   //die();
   
   //Na koniec sprawdzamy czy user wybra³ wszystkie wymagane opcje
   if ($user_count < $elements)
   {
      //print "User wybra³ : " . $user_count . " opcje, musi wybraæ : " . $elements . " dla towaru o id=$id";
      return false;
   }
   else
   {
      return true;
   }
}

function get_xml_options($uid) 
{
   global $mdbd;
   $xml_options='';
   if (empty($uid)) return "unknown";
   $xml_options=$mdbd->select('xml_options','main',"id=?",array("$uid"=>"int"));
   return $xml_options;
}

function get_xml_options_no_of_items($xml_options)
{
   if (!empty($xml_options))
   { 
      if (eregi("^multi",$xml_options)) 
      {
         $groups=preg_split("/\n\s/",$xml_options,-1,PREG_SPLIT_NO_EMPTY);
         return (count($groups) - 1);
      }
      // Jesli nie jest multi to rozmiar opcji = 1
      else
      {
         return 1;
      }
   }
   else
   {
      return 0;
   }
}

?>