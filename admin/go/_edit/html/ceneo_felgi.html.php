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
    <b>Felgi</b>
   </td>
</tr>


<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_producer'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_producer] size=50 value="<?php print @$rec->data['ceneo_producer'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_size'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_size] size=50 value="<?php print @$rec->data['ceneo_size'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_rozstaw'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_rozstaw] size=50 value="<?php print @$rec->data['ceneo_rozstaw'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_odsadzenie'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_odsadzenie] size=50 value="<?php print @$rec->data['ceneo_odsadzenie'];?>">
  </td>
</tr>


