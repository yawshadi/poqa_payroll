<div class="modal-header text-center">
                    <h6 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel">
                        <img class="hidden-lg-up" src="<?php echo URLROOT ?>/img/vamed.png" alt=""
                             style="height: 50px !important; width: 50px; margin-top: -5px;"><br/>
                        <strong>
                           Employee Folder
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
         <td width="60%"><input type="text" id='filename' class="form-control bom" placeholder="Document Type / heading"></td>
         <td><input type="file" id="fileupload"/></td>
         </tr>
   </table> 
   <input type="hidden" name="" id="randomnumber" value="<?= $data['randomnumber']?>">
   <table class='table table-condensed table-bordered'>
                <tr style="font-weight:bold">
                <td>Document Type</td>
                <td> Filename</td>
                <td>Action</td>
                </tr>
   <?php
             foreach($data['document'] as $doc):
                   ?>
                   <tr>
                   <td><?=$doc->documentname  ?></td>
                   <td> <a target='_blank' href="<?= URLROOT?>/uploads/<?=$doc->newname ?>"><?=$doc->name  ?></a> </td>
                   <td align="center"><a  did='<?= $doc->did ?>' class='deldoc' style='color:red'><i class='fa fa-trash'></i></a></td>
                   </tr>
            <?php
              endforeach
            ?> 
   </table>
    </div>
</div>



<script>
var urlroot = marketplacecfg.urlroot;

function AjaxPostContainer(ajaxurl, postdata, containerclass){

$.ajax({
    type: "POST",
    url: ajaxurl,
    data : postdata,
    beforeSend: function () {
        $.blockUI();
    },
    success: function (text) {
      $('.'+containerclass+'').html(text);
    },
    complete: function () {
        $.unblockUI();
    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status + " " + thrownError);
    }
});
}

function AjaxPostRequest(ajaxurl, postdata){

$.ajax({
    type: "POST",
    url: ajaxurl,
    data : postdata,
    beforeSend: function () {
        $.blockUI();
    },
    success: function (text) {
        $("#ajaxcontainer").html(text);
    },
    complete: function () {
        $.unblockUI();
    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status + " " + thrownError);
    }
});
}

var randomnumber = $("#randomnumber").val();
ajaxu = urlroot + "/pages/folder";
postd = {randomnumber:randomnumber};

$("#fileupload").uploadifive({
    buttonText: "Browse For File",
    buttonClass: "uploadbutton",
    auto: true,
    method: "post",
    multi: true,
    width: 220,
    'onUpload' : function(){
        $('#fileupload').data('uploadifive').settings.formData = {
                'filename': $('#filename').val(),
                'randomnumber':$('#randomnumber').val()
        }},
    onUploadComplete: function (file, data) {
      console.log("filedata", data);
      console.log("file", file);
          
            AjaxPostContainer(ajaxu,postd,'folderform');
    },

    uploadScript: urlroot + "/pages/folderupload"
  });

  
$('.deldoc').on('click', function(){
 
 var did = $(this).attr('did');
 var x = confirm('Do you want to delete?');

 if(x == true){

             ajaxurl = urlroot + "/ajax/deletefolder";
             postdata = {did:did};
             AjaxPostRequest(ajaxurl,postdata);
            AjaxPostContainer(ajaxu,postd,'folderform');

        return false;
}

return false;

})
</script>