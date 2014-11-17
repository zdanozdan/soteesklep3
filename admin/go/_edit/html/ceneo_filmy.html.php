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
    <b>Filmy</b>
   </td>
</tr>


<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_rezyser'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_rezyser] size=50 value="<?php print @$rec->data['ceneo_rezyser'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_obsada'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_obsada] size=50 value="<?php print @$rec->data['ceneo_obsada'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_nosnik'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_nosnik] size=50 value="<?php print @$rec->data['ceneo_nosnik'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_tytul_org'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_tytul_org] size=50 value="<?php print @$rec->data['ceneo_tytul_org'];?>">
  </td>
</tr>
