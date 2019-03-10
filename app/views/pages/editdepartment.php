<table  class='table table-bordered table-condensed' style='font-size:12px'>
    <tr>
        <td>Department Name</td>
        <td><input type='text' class='form-control' id='departmentname' value="<?php echo $data->departmentname  ?>"></td>
    </tr>

    <tr>
        <td>Department Code</td>
        <td><input type='text' class='form-control' id='departmentcode' value="<?php echo $data->departmentcode  ?>"></td>
    </tr>

    <tr>
        <td></td>
        <td><button class='btn btn-danger updatedepartment' departmentid='<?php echo $data->did  ?>' type='submit' name='updatedepartment' > Update </button></td>
    </tr>

</table>