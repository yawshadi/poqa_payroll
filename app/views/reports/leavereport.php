<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/report.php' ; ?>


<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #FB6600;
  padding:2px;
}

.vas{
  font-weight: 700;
  font-size: 12px;
}
.btn{
  border-radius:0px !important;
  margin-top:2px;
}

</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">



  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-md-6">
          <h1 style='color:#FB6600; font-weight:700' class="page-title">Leave Report for <?= date('Y') ?></h1>

        </div>
        <!-- <div class="col-md-6">
          <button onclick="window.print()"class='btn btn-primary pull-right'>Download</button>

        </div> -->
   </div>

      <hr/>

<div class="row" style="margin-bottom:20px">

      <div class="col-lg-12 col-md-12 col-sm-12">

      <div class='card'>
      <div class="container">
      <br/>
      <div>
      <table  class='table table-bordered table-condensed' style='font-size:12px'>
      <tr>
          <td colspan="5" align='center' style='font-weight:700'>LEAVE DEDUCTIONS FOR <?= date('Y')?> </td>
        </tr>
      </table>

      <table  class='exp table table-bordered table-condensed' style='font-size:12px'>
      <thead>
          <th>Staff Name </th>
          <th>Leave entitled to </th>
          <th>Dates on Leave(From) </th>
          <th>Dates on Leave (To)</th>
          <th>Total No. of days applied</th>
          <th>Outstanding days</th>
      </thead>
      <tbody>
      <?php
      $x=1; 
      foreach(Leave::LeaveEmp() as $employee):
      ?>
      <tr>
      
        <td> <?= $employee->surname.' '.$employee->firstname.' '.$employee->othernames ?></td>
        <td><?= $employee->accumulatedleave ?></td>
        <td><?= $employee->startdate ?></td>
        <td><?= $employee->endate ?></td>
        <td> <?= $employee->actualdays ?></td>
        <td> <?= Leavedays::availabledays($employee->basic_id,date('Y')) ?></td>
      </tr>
      <?php 
      $x++;
      endforeach;
      ?>
      </tbody>

      </table>
   
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>

      <div class="row" style="margin-bottom:20px"> </div>
    </div>   <!-- End of Placeholder -->

    </div>
    </div>
    <?php require APPROOT .'/views/inc/footer.php'  ?>


<script>
var t = $(".exp").tableExport({
    headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
    footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
    formats: ["xlsx"],    // (String[]), filetypes for the export
    fileName: "LeaveReport",                    // (id, String), filename for the downloaded file
    bootstrap: false,                   // (Boolean), style buttons using bootstrap
    position: "top" ,                // (top, bottom), position of the caption element relative to table
    ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file(s)
    ignoreCols: null,                  // (Number, Number[]), column indices to exclude from the exported file(s)
    ignoreCSS: ".tableexport-ignore",  // (selector, selector[]), selector(s) to exclude from the exported file(s)
    emptyCSS: ".tableexport-empty",    // (selector, selector[]), selector(s) to replace cells with an empty string in the exported file(s)
    trimWhitespace: false              // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s)
});

</script>