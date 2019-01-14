$(document).ready(function(){

      const urlroot = marketplacecfg.urlroot;

  $('.updatequantity').click(function(){

   var etag = $(this).attr('etag');
   var subid = $(this).attr('subid');
   var count = $(this).attr('count');
   var values = [];
   var tenantid = $('#tenantid').val();
   var region = $('#region').val();

   $("input[name='qty[]']").each(function() {
   values.push($(this).val());
   });

   var qty = values[count];
   var postdata = {etag:etag, subid:subid, tenantid:tenantid, region:region, quantity:qty};

   var ajaxurl =  urlroot + '/subscriptions/microsoftquantityupdate';

     $.ajax({
         type: "POST",
         url: ajaxurl,
         data : postdata,
         beforeSend: function () {
             $.blockUI();
         },
         success: function(text) {
            $("#testarea").notify('Quantity sucessfully updated', "success" );
         },
         complete: function () {
             $.unblockUI();
         },
         error: function (xhr, ajaxOptions, thrownError) {
             alert(xhr.status + " " + thrownError);
         }
     });


  })


  //Update Customer Subscription status
  $('.subaction').change(function(){

   var action  = $(this).val();
   var etag = $(this).attr('etag');
   var subid = $(this).attr('subid');
   var tenantid = $('#tenantid').val();
   var region = $('#region').val();

   var postdata = {etag:etag, subid:subid, tenantid:tenantid, region:region, action:action};

   var ajaxurl =  urlroot + '/subscriptions/microsoftstatusupdate';

     $.ajax({
         type: "POST",
         url: ajaxurl,
         data : postdata,
         beforeSend: function () {
             $.blockUI();
         },
         success: function(text) {
              $("#testarea").notify('Status Successfully Updated', "success" );

         },
         complete: function () {
             $.unblockUI();
         },
         error: function (xhr, ajaxOptions, thrownError) {
             alert(xhr.status + " " + thrownError);
         }
     });


  })

})
