<table  class='table table-bordered table-condensed' style='font-size:12px'>
    <tr>
        <td>Position</td>
        <td><input type='text' class='form-control' id='positionname' value="<?php echo $data['positiondata']->positionname  ?>"></td>
    </tr>

    <tr>
        <td>Department</td>
        <td>
            <select class="form-control" id="departmentname">
                <option><?php echo  $data['positiondata']->department  ?></option>
                <?php
                  foreach ($data['departmentdata'] as $get){
                      echo "<option>$get->departmentname</option>";
                  }
                ?>

            </select>



    <tr>
        <td></td>
        <td><button class='btn btn-danger updateposition' positionid='<?php echo $data['positiondata']->pid ?>' type='submit' name='updatedepartment' > Update </button></td>
    </tr>

</table>