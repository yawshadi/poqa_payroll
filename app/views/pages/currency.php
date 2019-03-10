<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/config.php' ; ?>

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
                <h1 style='color:#FB6600; font-weight:700' class="page-title"> EXCHANGE RATE CONFIGURATION </h1>
            </div>
        </div>

        <hr/>

        <div id='placeholder'>


            <?php // require APPROOT .'/views/inc/dash.php' ; ?>


        </div>



        <div class="row" style="margin-bottom:20px">


            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class = 'card'>
                    <form method='post'>


                        <table  class='table table-bordered table-condensed' style='font-size:12px'>

                            <tr>
                                <td>EUROS</td>
                                <td><input type='text' class='form-control' name='euros' value="<?php echo $data['euros']  ?>"></td>
                            </tr>

                            <tr>
                                <td>DOLLARS</td>
                                <td><input type='text' class='form-control' name='dollars' value="<?php echo $data['dollars']  ?>"></td>
                            </tr>

                            <tr>
                                <td>POUNDS</td>
                                <td><input type='text' class='form-control' name='pounds' value="<?php echo $data['pounds']  ?>"></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td><button class='btn btn-danger' type='submit' name='updaterates' > Update Rates </button></td>
                            </tr>

                        </table>

                    </form>

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
