<center>
  <table width="770" cellspacing="0" cellpadding="0" border="0">
    <tr> 
      <td width="180" valign="top" align="left"> 
        <?php $this->left();?>
      </td>
      <td width="10" valign="top">&nbsp;</td>
         <td width="580" valign="top" align="center">
         <form method=post action="/custom/index.php">
         <?php $this->bar("Kontakt z pracownikiem"); ?>
         <?php 
            $repaint_from = false;

            if (isset($_POST['send_email']))
            {
               $name = trim($_POST['name']);
               $imie = trim($_POST['imie']);
               $nazwa=trim($_POST['nazwa']);
               $produkt=trim($_POST['produkt']);
               $dane=trim($_POST['dane']);
               $mail=trim($_POST['mail']);
               $tresc=trim($_POST['tresc']);
               $dest=trim($_POST['dest']);

               if (!ereg("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $mail))
               {
                  $repaint_form = true;
               }
               else
               {
                  $ccaddress = "sklep@mikran.pl"; 
                  //$toaddress = "tomasz@mikran.pl"; 
                  $toaddress = $dest;
                  
                  $headers = "From:" . $mail . "\r\n" .
                  "Reply-To:". $dest . "\r\n" .
                  "Cc:".$ccaddress."\r\n" .
                  "X-Mailer: PHP/" . phpversion();
                  
                  $subject = "List z formularza ze strony www";
                  $mailcontent = "Klient: ".$imie."\n"
                  ."Firma: ".$nazwa."\n"
                  ."Produkt: ".$produkt."\n"
                  ."Adres/tel: ".$dane."\n"
                  ."e-mail: ".$mail."\n"
                  ."Tre¶æ: \n".$tresc."\n";
                  ?>
                  <div id="block_1">
                   <table width="100%">
                   <tr style="font-size:larger"> <br><br>
                   
                   <?php
                   if (mail($toaddress, $subject, $mailcontent, $headers ) == true)
                   {
                      print "Dziêkujemy, wiadomo¶æ zosta³a wys³ana do " . $name;

                   }
                   else
                   {
                      print "B³±d ! Nie uda³o siê wys³aæ wiadomo¶ci. Spróbuj wys³aæ wiadomo¶æ do " . $dest . " w inny sposób";
                   }
                  ?>
                   <br><br>
                   </tr></table>
                  <?php
               }
            }
            if($repaint_form == true || isset($_POST['n']))
            {
               if (isset($_POST['n']))
               {
                  $name = $_POST['n'];
                  if (strcmp($name,"ab") == 0)
                  {
                     $name = "Aneta Bartoszak (aneta@mikran.pl)";
                     $dest = "aneta@mikran.pl";
                  }
                  if (strcmp($name,"tz") == 0)
                  {
                     $name = "Tomasz Zdanowski (tomasz@mikran.pl)";
                     $dest = "tomasz@mikran.pl";
                  }
                  if (strcmp($name,"kz") == 0)
                  {
                     $name = "Krystyna Zdanowska (krystyna@mikran.pl)";
                     $dest = "krystyna@mikran.pl";
                  }
                  if (strcmp($name,"ap") == 0)
                  {
                     $name = "Alina Perz (ala@mikran.pl)";
                     $dest = "ala@mikran.pl";
                  }
                  if (strcmp($name,"pn") == 0)
                  {
                     $name = "Pawe³ Nowak (pawel@mikran.pl)";
                     $dest = "pawel@mikran.pl";
                  }
                  if (strcmp($name,"as") == 0)
                  {
                     $name = "Agnieszka Sitarska (agnieszka@mikran.pl)";
                     $dest = "agnieszka@mikran.pl";
                  }
                  if (strcmp($name,"ag_s") == 0)
                  {
                     $name = "Agnieszka Stefaniak (agnieszka_s@mikran.pl)";
                     $dest = "agnieszka_s@mikran.pl";
                  }
                  if (strcmp($name,"mg") == 0)
                  {
                     $name = "Monika Graban (monika@mikran.pl)";
                     $dest = "monika@mikran.pl";
                  }
                  if (strcmp($name,"sklep") == 0)
                  {
                     $name = "Sklep mikran.pl (sklep@mikran.pl)";
                     $dest = "sklep@mikran.pl";
                  }
                  if (strlen($name) == 0)
                  {
                     $name = "Sklep mikran.pl (sklep@mikran.pl)";
                     $dest = "sklep@mikran.pl";
                  }
               }
         ?>
         <div id="block_1">
         <table width="100%" style="text-align:left;">
         <tr>
         Wype³nij pola poni¿szego formularza i wpisz tre¶æ maila <br><br>
         </tr>
         <tr>
         <td>Wiadomo¶æ dla:</td>
         <td><?php print $name ?></td>
         </tr>
         <tr>
         <td>Imiê i Nazwisko:</td>
         <td><input type=text name="imie" size=50></td>
         </tr>
         <tr>
         <td>Nazwa firmy:</td>
         <td><input type=text name="nazwa" size=50></td>
         </tr>
         <tr>
         <td>Produkt:</td>
         <td><input type=text name="produkt" size=50></td>
         </tr>
         <tr>
         <td>Dane tele-adresowe:</td>
         <td><input type=text name="dane" size=50></td>
         </tr>
         <tr>
         <td>email nadawcy:</td>
         <td>
          <?php 
          if ($repaint_form == true)
          {
             print "<span style=\"color:#FF0000\">";
             print "Wpisa³e¶ nieprawid³owy adres e-mail"."<br></span>";
          }
          ?>
          <input type=text name="mail" size=50>
         </td>
         </tr>
         <tr>
         <td>Zapytanie:</td>
         <td><textarea name="tresc" rows=10 cols=70>tu wpisz tre¶æ listu</textarea></td>
         </tr>
         </table>
         </div>

         <input type=hidden name="send_email" value="yes">
         <?php print "<input type=hidden name=\"dest\" value=\"$dest\">" ?>
         <?php print "<input type=hidden name=\"name\" value=\"$name\">" ?>
         <input type=submit id="payment" value="Wy¶lij zapytanie">
         </form>
          
          <?php } ?>
         
</td>
</tr>
</table>
</center>

         
