<table  class='table table-bordered table-condensed' style='font-size:12px'>

    <tr>
        <td>Bank Name</td>
        <td><input type='text' class='form-control' required id='bankname' value="<?php echo $data['bankdata']->bankname  ?>"> </td>
    </tr>

    <tr>
        <td>Bank Code</td>
        <td><input type='text' class='form-control' required id='bankcode' value="<?php echo $data['bankdata']->bankcode  ?>"></td>
    </tr>

    <tr>
        <td>Branch Name</td>
        <td><input type='text' class='form-control' required id='branchname' value="<?php echo $data['bankdata']->branch  ?>"></td>
    </tr>

    <tr>
        <td>Branch Code</td>
        <td><input type='text' class='form-control' required id='branchcode' value="<?php echo $data['bankdata']->branchcode  ?>"></td>
    </tr>

    <tr>
        <td></td>
        <td><button class='btn btn-danger updatebank' bankid="<?php echo $data['bankdata']->bankid ?>" type='button'  > Update </button></td>
    </tr>

</table>