<?php

function check_options($id, $xml_options)
{
   // odczytujemy opcje towaru z bazy danych i obliczamy ich rozmiar (ilo�� element�w)
   $opt = get_xml_options($id);
   $elements = get_xml_options_no_of_items($opt);
   
   $user_count = 0;

   //jesli xml_options sa tablica to jest to typ multi
   if (is_array($xml_options))
   {
      foreach ($xml_options as $item) 
      {
         if (!empty($item))
         {
            if (!eregi("^---",$item) && !eregi("^IMG:---",$item))
            {
               //print $item;
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
   
   //Na koniec sprawdzamy czy user wybra� wszystkie wymagane opcje
   if ($user_count < $elements)
   {
      //print "User wybra� : " . $user_count . " opcje, musi wybra� : " . $elements . " dla towaru o id=$id";
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
   if (! empty($xml_options))
   { 
      // je�li mamy multi to trzeba policzy� ile jest items�w
      if (eregi("^multi",$xml_options)) 
      {
         $groups=preg_split("/\n\s/",$xml_options,ATTR_MAX_NUM,PREG_SPLIT_NO_EMPTY);
         // multi jest liczone jako element tablicy ale chcemy tylko faktyczn� ilo�� opcji
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