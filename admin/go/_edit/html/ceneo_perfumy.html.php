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
    <b>Perfumy</b>
   </td>
</tr>


<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_perfumy_producent'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_perfumy_producent] size=50 value="<?php print @$rec->data['ceneo_perfumy_producent'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_perfumy_model'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_perfumy_model] size=50 value="<?php print @$rec->data['ceneo_perfumy_model'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_perfumy_rodzaj'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_perfumy_rodzaj] size=50 value="<?php print @$rec->data['ceneo_perfumy_rodzaj'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_ceneo['ceneo_perfumy_pojemnosc'];?> &nbsp;&nbsp;&nbsp; 
    <input type=text name=item[ceneo_perfumy_pojemnosc] size=50 value="<?php print @$rec->data['ceneo_perfumy_pojemnosc'];?>">
  </td>
</tr>
