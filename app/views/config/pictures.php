<table>

<tr>
<?php
 
 foreach($data as $get):
?>
<td><img height=200 width=200  src='<?php echo DOCROOT. $get->filename    ?>'   /><td>
<?php
endforeach;
?>

</tr>

</table>