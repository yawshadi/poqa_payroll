<style>

.form-control{
  font-size:12px
}

</style>


<table class='table'>

  <tr>
  <td>Basic Salary</td>
  <td>  <input type='text' id='basicsalary'  value="<?php echo $data['basicsalary'] ?>" class='form-control'/> </td>
  </tr>
  <input type='hidden' id='posid'  value="<?php echo $data['posid'] ?>"  class='form-control'/>

  <tr>
  <td></td>
  <td><button class='btn btn-block btn-danger' id='updateofficerbtn'
       company='<?php echo $data['company']  ?>'
       department='<?php echo $data['department']  ?>'
       position='<?php echo $data['position']  ?>'
  >update</button></td>
  </tr>
  </table>
