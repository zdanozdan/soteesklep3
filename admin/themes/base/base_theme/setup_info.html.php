<?php
/**
* @version    $Id: setup_info.html.php,v 1.2 2004/12/20 18:01:23 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
global $_POST;
$form=$_POST['form'];
?>

<table align=center width=70%><tr><td>
<b>Pliki konfiguracyjne zosta�y zainstalowane poprawnie:)</b>

<ol>
<!--------------------------------------------------->
<li> Za�� baz� <B><?php print $form['dbname'];?></B> w bazie MySQL oraz u�ytkwonik�w
 <B><?php print $form['nobody_dbuser'];?></B> i 
 <B><?php print $form['admin_dbuser'];?></B>
     <pre>mysql -u root -p mysql
Enter password: ******</pre>
<!--------------------------------------------------->
<li> Zaznacz poni�sze instrukcje (mo�esz zaznaczy� ca�o�� od razu) i wklej do MySQL.
<pre>
CREATE DATABASE <B><?php print $form['dbname'];?></B>;
INSERT INTO user (Host,User,Password) values ('<B><?php print $form['dbhost'];?></B>','<B><?php print $form['nobody_dbuser'];?></B>',PASSWORD('<B><?php print $form['nobody_dbpassword'];?></B>'));
INSERT INTO user (Host,User,Password) values ('<B><?php print $form['dbhost'];?></B>','<B><?php print $form['admin_dbuser'];?></B>',PASSWORD('<B><?php print $form['admin_dbpassword'];?></B>'));
INSERT INTO db (Host,Db,User) VALUES ('<B><?php print $form['dbhost'];?></B>','<B><?php print $form['dbname'];?></B>','<B><?php print $form['nobody_dbuser'];?></B>');
INSERT INTO db (Host,Db,User,Select_Priv,Insert_Priv,Update_Priv,Delete_Priv,Create_Priv,
    Drop_Priv,Grant_Priv,References_Priv,Index_Priv,Alter_Priv) VALUES 
    ('<B><?php print $form['dbhost'];?></B>','<B><?php print $form['dbname'];?></B>','<B><?php print $form['admin_dbuser'];?></B>','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');
     </pre>
<!--------------------------------------------------->
<li> Wyjd� z MySQL
<pre>exit</pre>
<li> Prze�aduj baz� MySQL
<pre>mysqladmin -u root -p reload
Enter password: ******
</pre>
<!--------------------------------------------------->
<li> Za�aduj baz� do MySQL - wykonaj polecenia z poziomu shell'a: 
<pre>
cd soteesklep2/sql
make
mysql -u <?php print $form['admin_dbuser'];?> -p <?php print $form['dbname'];?> < soteesklep2.mysql
Enter password: *******
mysql -u <?php print $form['admin_dbuser'];?> -p <?php print $form['dbname'];?> < perm.mysql
Enter password: *******
</pre>                                     
<!--------------------------------------------------->
<li>
<font color=red>Po zako�czeniu instalacji koniecznie zabezpiecz program!</font> <BR>Przejd� do katalogu (z poziomu shell'a) w kt�rym zainstalowany jest sklep i wydaj polecenie:
  
 <pre>cd soteesklep2
./security-sh </pre>
<!--------------------------------------------------->
<li> Wywo�aj panel oraz sklep w przegl�darce (te same nazwy domen, kt�re s�
ustawione w httpd.conf) np:<BR>
    <ul>
      <li><a href=http://<?php print $this->admin_domain;?> target=admin><u>http://<?php print $this->admin_domain;?></u></a>  (login: <b><?php print $form['admin_dbuser'];?></b> has�o: <b><?php print $form['admin_dbpassword'];?></b>)
      <li><a href=http://<?php print $this->domain;?> target=soteesklep><u>http://<?php print $this->domain;?></u></a>
    </ul>
<!--------------------------------------------------->
</ol>

</td></tr></table>
