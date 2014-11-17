<?php
class ErrorMessage 
{
      /**
       * Wyswietl error
       */
      function show() {
         global $theme;
         $theme->theme_file("error.html.php");
      } 
}
?>
   