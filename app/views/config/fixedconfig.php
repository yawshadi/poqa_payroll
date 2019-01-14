<style>

.form-control{
  font-size:12px
}

</style>


<table class='table'>
  <tr style=''>
  <td>Total Full Present Hours This Month</td>
  <td><input type='text' id='totalfullpresent'  value="<?php echo $data['totalfullpresent'] ?>" class='form-control'/>  </td>
  </tr>

  <tr>
  <td>Basic Salary</td>
  <td>  <input type='text' id='basicsalary'  value="<?php echo $data['basicsalary'] ?>" class='form-control'/> </td>
  </tr>

  <tr  style=''>
  <td>Transport Allowance</td>
  <td><input type='text' id='transportallowance'  value="<?php echo $data['transportallowance'] ?>" class='form-control'/> </td>
  </tr>

  <tr style=''>
  <td  >Gross </td>
  <td>  <input type='text'  id='gross'  value="<?php echo $data['gross'] ?>"  class='form-control'/></td>
  </tr>

  <tr  style=''>
  <td>Weekly Hourly Rate</td>
  <td> <input type='text' id='weekdayhourlyrate'  value="<?php echo $data['weekdayhourlyrate'] ?>"  class='form-control'/></td>
  </tr>


  <tr>
  <td>Extra / Overtime Allowance</td>
  <td> <input type='text' id='weekdayovertimerate'  value="<?php echo $data['weekdayovertimerate'] ?>"  class='form-control'/></td>
  </tr>


  <tr  style=''>
  <td>Holiday & Weekend Overtime Rate</td>
  <td> <input type='text' id='holidayovertimerate'  value="<?php echo $data['holidayovertimerate'] ?>"  class='form-control'/></td>
  </tr>

  <tr  style=''>
  <td>Night Shift Allowance</td>
  <td> 
  <input type='text' id='nightshiftallowance'  value="<?php echo $data['nightshiftallowance'] ?>"  class='form-control'/>
  <input type='hidden' id='posid'  value="<?php echo $data['posid'] ?>"  class='form-control'/>
  
  </td>
  </tr>

  

  <tr>
  <td></td>
  <td><button class='btn btn-block btn-danger' id='updatepositionbtn'
       company='<?php echo $data['company']  ?>'
       department='<?php echo $data['department']  ?>'
       position='<?php echo $data['position']  ?>'
  >update</button></td>
  </tr>
  </table>              