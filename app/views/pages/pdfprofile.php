<?php

ob_start();
?>
<style>
table, td, th {
    border: 1px thin #dedede;
    padding:3px
}
</style>
<body style ='font-size:10px;'>
  <table width="700"align="center" cellpadding='3' style="border-collapse: collapse; border:1px solid #000; font-size:10px">
    <tr>
      <td width="200" valign=top rowspan="22" align='center'>
        <br/>
        <img style="border-radius:50%" src='<?php echo URLROOT.'/uploads/'.$data['passport']->newname  ?>'
         height=250 width=180  /></td>
      <td colspan="2"><h3>VISA APPLICATION PROFILE</h3></td>
    </tr>
    <tr>
      <td width="220">Full Name</td>
      <td width="280"><span style='font-weight:bold; color:green'><?php echo strtoupper($data['basicdata']->fullname)  ?></span></td>
    </tr>
    <tr>
      <td>Firstname</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->firstname)  ?></span></td>
    </tr>
    <tr>
      <td>Family name</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->surname)  ?></span></td>
    </tr>
    <tr>
      <td>Gender</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->gender)  ?></span></td>
    </tr>
    <tr>
      <td>Date of Birth</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->dateofbirth)  ?></span></td>
    </tr>
    <tr>
      <td>Year of birth</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->yearofbirth)  ?></span></td>
    </tr>
    <tr>
      <td>Original Profession</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->profession)  ?></span></td>
    </tr>
    <tr>
      <td>Intended Profession</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->intendedprofession)  ?></span></td>
    </tr>

    <tr>
      <td>Passport Number</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->passportnumber)  ?></span></td>
    </tr>

    <tr>
      <td>Date of issue of passport</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->dateofpassportissue)  ?></span></td>
    </tr>

    <tr>
      <td>Date of expiry of passport</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->dateofpassportexpiry)  ?></span></td>
    </tr>

    <tr>
      <td>Mother's name</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->mothersname)  ?></span></td>
    </tr>

    <tr>
      <td>Father's name</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->fathersname)  ?></span></td>
    </tr>

    <tr>
      <td>Spouse name</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->spousename)  ?></span></td>
    </tr>

    <tr>
      <td>Spouse date of birth</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->dateofbirthofspouse)  ?></span></td>
    </tr>

    <tr>
      <td>Spouse place of birth</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->placeofbirthofspouse)  ?></span></td>
    </tr>

    <tr>
      <td>Spouse contact number</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->telephoneofspouse)  ?></span></td>
    </tr>

    <tr>
      <td>Family Address</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->familyaddress)  ?></span></td>
    </tr>
    <tr>
      <td>Height (cm)</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->height)  ?></span></td>
    </tr>

    <tr>
      <td>Number of children</td>
      <td><span style='font-weight:bold; color:#DE561E;'><?php echo strtoupper($data['basicdata']->numberofchildren)  ?></span></td>
    </tr>

    <tr>
      <td>Name & date of birth of children</td>
      <td>&nbsp;</td>
    </tr>


  </table>
</body>

<?php
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(5, 20, 5, 5));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        // send the PDF
        $pdffile = $html2pdf->Output('prince.pdf','F');//,'D');
        $fp = fopen('prince.pdf','r');

        $path = 'prince.pdf';
        Header('Content-Type: application/pdf');
    		Header('Content-Description: File Transfer');
    		Header('Content-Disposition: inline; filename='.basename($path));
    		Header('Content-Transfer-Encoding: binary');
    		Header('Expires: 0');
    		Header('Cache-Control: must-revalidate, post-check=0, precheck=0');
    		Header('Pragma: public');
    		Header('Content-Length: '.filesize($path));
        ob_clean();
        flush();
        readfile($path);

        //print fread($fp,filesize('prince.pdf'));
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
