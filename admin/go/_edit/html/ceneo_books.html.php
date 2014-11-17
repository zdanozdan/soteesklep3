<?php
global $lang;
?>
<tr>
  <td>
    &nbsp;
   </td>
</tr>


<tr>
  <td>
    <b>Ksi±¿ki</b>
   </td>
</tr>


<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_autor'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_autor] size=50 value="<?php print @$rec->data['ceneo_autor'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_isbn'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_isbn] size=50 value="<?php print @$rec->data['ceneo_isbn'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_page'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_page] size=50 value="<?php print @$rec->data['ceneo_page'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_publisher'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_publisher] size=50 value="<?php print @$rec->data['ceneo_publisher'];?>">
  </td>
</tr>


