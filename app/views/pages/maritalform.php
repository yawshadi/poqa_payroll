<div class="modal-header text-center">
                    <h6 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel">
                        <img class="hidden-lg-up" src="<?php echo URLROOT ?>/img/vamed.png" alt=""
                             style="height: 50px !important; width: 50px; margin-top: -5px;"><br/>
                        <strong>
                           Marital Form
                        </strong>
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
 </div>
<div class="container">
<div class="col-md-12">
<table class='table'>
         <tr>
         <td><input type="text" class="form-control bom"  id="spouse" placeholder="Spouse Name" value="<?= isset($data['maritaldata']->spouse)?$data['maritaldata']->spouse:''?>"/></td>
         <td><input type="text" class="form-control bom" value="<?= isset($data['maritaldata']->spousecontact)?$data['maritaldata']->spousecontact:''?>"id="spousecontact" placeholder="Contact No."/></td>
         </tr>
         <tr>
         <td><input type="text" class="form-control bom" id="1st" value="<?= isset($data['maritaldata']->first)?$data['maritaldata']->first:''?>" placeholder="1st dependant"/></td>
         <td><input type="text" class="form-control bom"  id="2nd" value="<?= isset($data['maritaldata']->second)?$data['maritaldata']->second:''?>" placeholder="2nd dependant"/></td>
         </tr>
         <tr>
         <td><input type="text" class="form-control bom" id="3rd"value="<?= isset($data['maritaldata']->third)?$data['maritaldata']->third:''?>" placeholder="3rd dependant"/></td>
         <td><input type="text" class="form-control bom"  id="4th" value="<?= isset($data['maritaldata']->fourth)?$data['maritaldata']->fourth:''?>"placeholder="4th dependant"/></td>
         </tr>
   </table> 
   <input type="hidden" name="randomnumber" id="mrandomnumber" value="<?= $data['randomnumber']?>">
        <button type="button" id="maritalsubmit" name="submit" style="border-radius:12px;background-color:#00ACE5" class="btn btn-primary btn-block">Submit</button>
    </div>
</div>



<script>
var urlroot = marketplacecfg.urlroot;

  $("#maritalsubmit").click(function (e) { 
        e.preventDefault();
        var spouse = $("#spouse").val();
        var contact = $("#spousecontact").val();
        var first = $("#1st").val();
        var second = $("#2nd").val();
        var third = $("#3rd").val();
        var fourth = $("#4th").val();
        var mode = 'save';
        var randomnumber = $("#mrandomnumber").val();
        ajaxurl = urlroot + "/pages/marital";
        postdata ={randomnumber:randomnumber,mode:mode,spouse:spouse,contact:contact,first:first,second:second,third:third,fourth:fourth}
        $.ajax({
            type: "POST",
            url:  ajaxurl,
            data: postdata,
            dataType: "html",
            success: function (text) {
              console.log(text);
              notie.alert({ type: 4, text: 'Marital Information Saved', time: 3 });

            }
            })
    });
</script>