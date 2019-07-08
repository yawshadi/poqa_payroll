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

</style>


<!-- Commhr content goes here -->
<div class="content-wrapper" style="background: #fafafa">



    <div class="container-fluid main_container" style='margin-top:-10px'>

        <div class="row">
            <div class="col-12">
                <h1 style='color:#FB6600; font-weight:700' class="page-title">MASTER LIST </h1>
            </div>
        </div>

        <hr/>

        <div id='placeholder'>

        </div>



        <div class="row" style="margin-bottom:20px">

            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class='card'>
                    <div class="container">
                        <br/>
                        <div align='center'>


                            <?php if(isset($data['ghdata'])):

                                ?>

                                <div style='width:100%; margin-top:10px;'>
                                    <div><a style='font-size:10px'   href="<?php echo URLROOT.'/masterlist/masterlistexcel' ?>"
                                            class='btn btn-danger pull-left'>Download</a></div>
                                    <br/>

                                    <table class='table table-bordered table-condensed' >
                                        <tr>
                                            <td colspan="13"><h6>LIST OF GHANAIAN EMPLOYEES</h6></td>
                                        </tr>
                                        <tr style ='font-weight:700; color:#fff' bgcolor="#00ACE5">
                                            <td>No:</td>
                                            <td>Name</td>
                                            <td>Position </td>
                                            <td>Birth Date</td>
                                            <td>Academic Title</td>
                                            <td>Entry Date</td>
                                            <td>Monthly Salary (GHC)</td>
                                            <td>Monthly Salary (EUROS)</td>
                                            <td>Annual Bonus (GHC)</td>
                                            <td>Annual Bonus (EUROS)</td>
                                            <td>Location</td>
                                            <td>Gender</td>
                                        </tr>
                                        <?php

                                        foreach($data['ghdata'] as $key=>$get):

                                            $count  = $key + 1;

                                            $income = Payinformation::gross($get->basic_id);
                                            $eurorate = $data['euros'];
                                            $euroincome  = payround($income / $eurorate);

                                            ?>
                                            <tr>
                                                <td><?php echo $count ?></td>
                                                <td><?php echo $get->surname.' '.$get->firstname;  ?></td>
                                                <td><?php echo $get->position;  ?></td>
                                                <td><?php echo $get->dateofbirth;     ?></td>
                                                <td><?php echo $get->academictitle;    ?></td>
                                                <td><?php echo $get->entrydate;    ?></td>
                                                <td><?php echo $income  ?></td>
                                                <td><?php echo $euroincome  ?></td>
                                                <td></td>
                                                <td></td>
                                                <td><?php echo $get->location  ?></td>
                                                <td><?php echo $get->gender  ?></td>

                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                    </table>

                                    <table class='table table-bordered table-condensed' >

                                        <tr>
                                            <td colspan="13"><h6>LIST OF EXPATRIATE EMPLOYEES</h6></td>
                                        </tr>
                                        <tr style ='font-weight:700; color:#fff' bgcolor="#00ACE5">
                                            <td>No:</td>
                                            <td>Name</td>
                                            <td>Position </td>
                                            <td>Birth Date</td>
                                            <td>Academic Title</td>
                                            <td>Entry Date</td>
                                            <td>Monthly Salary (GHC)</td>
                                            <td>Monthly Salary (EUROS)</td>
                                            <td>Annual Bonus (GHC)</td>
                                            <td>Annual Bonus (EUROS)</td>
                                            <td>Location</td>
                                            <td>Gender</td>
                                        </tr>
                                        <?php

                                        foreach($data['exdata'] as $key=>$get):

                                            $count  = $key + 1;

                                            $income = Payinformation::gross($get->basic_id);
                                            $eurorate = $data['euros'];
                                            $euroincome  = payround($income / $eurorate);

                                            ?>
                                            <tr>
                                                <td><?php echo $count ?></td>
                                                <td><?php echo $get->surname.' '.$get->firstname;  ?></td>
                                                <td><?php echo $get->position;  ?></td>
                                                <td><?php echo $get->dateofbirth;     ?></td>
                                                <td><?php echo $get->academictitle;    ?></td>
                                                <td><?php echo $get->entrydate;    ?></td>
                                                <td><?php echo $income  ?></td>
                                                <td><?php echo $euroincome  ?></td>
                                                <td></td>
                                                <td></td>
                                                <td><?php echo $get->location  ?></td>
                                                <td><?php echo $get->gender  ?></td>

                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                    </table>

                                    <table class='table table-bordered table-condensed' >
                                        <tr>
                                            <td colspan="6"><h6>LIST OF JOINING STAFF IN THE REFERRING REPORTING MONTH</h6></td>
                                        </tr>
                                        <tr style ='font-weight:700; color:#fff' bgcolor="#00ACE5">
                                            <td>No:</td>
                                            <td>Name</td>
                                            <td>Position </td>
                                            <td>Birth Date</td>
                                            <td>Academic Title</td>
                                            <td>Entry Date</td>

                                        </tr>
                                        <?php

                                        foreach($data['entrydata'] as $key=>$get):

                                            $count  = $key + 1;
                                            ?>
                                            <tr>
                                                <td><?php echo $count ?></td>
                                                <td><?php echo $get->surname.' '.$get->firstname;  ?></td>
                                                <td><?php echo $get->position  ?></td>
                                                <td><?php echo $get->dateofbirth    ?></td>
                                                <td><?php echo $get->academictitle    ?></td>
                                                <td><?php echo $get->entrydate    ?></td>

                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                    </table>

                                    <table class='table table-bordered table-condensed' >
                                        <tr>
                                            <td colspan="6"><h6>LIST OF LEAVING OF PERMANENT STAFF IN THE REFERRING REPORTING MONTH</h6></td>
                                        </tr>
                                        <tr style ='font-weight:700; color:#fff' bgcolor="#00ACE5">
                                            <td>No:</td>
                                            <td>Name</td>
                                            <td>Position </td>
                                            <td>Birth Date</td>
                                            <td>Academic Title</td>
                                            <td>Exit Date</td>

                                        </tr>
                                        <?php

                                        foreach($data['exitdata'] as $key=>$get):

                                            $count  = $key + 1;
                                            ?>
                                            <tr>
                                                <td><?php echo $count ?></td>
                                                <td><?php echo $get->surname.' '.$get->firstname; ?></td>
                                                <td><?php echo $get->position  ?></td>
                                                <td><?php echo $get->dateofbirth;     ?></td>
                                                <td><?php echo $get->academictitle    ?></td>
                                                <td><?php echo $get->exitdate    ?></td>

                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                    </table>

                                </div>

                                <?php
                            endif;
                            ?>


                        </div>
                    </div>
                </div>

            </div>


        </div>




        <!-- End of first upper row -->


        <div class="row" style="margin-bottom:20px">




        </div>
    </div>   <!-- End of Placeholder -->

</div>
</div>
<?php require APPROOT .'/views/inc/footer.php'  ?>
