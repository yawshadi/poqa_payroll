<style>
.form-control{
    border-top:    none;
    border-right:  none;
    border-bottom: 1px solid #C4C4C4;
    border-left:   none;
    }
    
</style>
<div class="modal-header text-center">
                    <h6 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel">
                        <img class="hidden-lg-up" src="<?php echo URLROOT ?>/img/vamed.png" alt=""
                             style="height: 50px !important; width: 50px; margin-top: -5px;"><br/>
                        <strong>
                           Leave Form
                        </strong>
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
 </div>
<div class="container">
<div class="col-md-12">
    <div class="form-area">
        <form role="form">
        <br style="clear:both">
    				<div class="form-group">
						<input type="text" class="form-control employeename" id="employeename" name="name" placeholder="Name" required>
						<input type="hidden" class="form-control" id="employeeid">
					</div>
					<div class="form-group">
						<input type="text" class="form-control alldate" id="startdate" name="startdate" placeholder="Start Date" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control alldate" id="enddate" name="enddate" placeholder="End Date" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="subject" name="subject" placeholder="Remarks" required>
					</div>

        <button type="button" id="submit" name="submit" style="border-radius:12px;background-color:#00ACE5" class="btn btn-primary btn-block">Submit</button>
        </form>
    </div>
</div>
</div>

<script type="text/javascript" src="<?php echo URLROOT ?>/js/main.js"></script>
