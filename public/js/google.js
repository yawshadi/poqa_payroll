$(document).ready(function(){

  const urlroot = marketplacecfg.urlroot;

     $('.googlequantityupdate').click(function(){

   //$googleid, $subscriptionid, $plan, $quantity
      var googleid = $(this).attr('googleid');
      var subid = $(this).attr('subid');
      var plan = $(this).attr('plan');
      var maxseats = $(this).attr('maxseats');
      var counter = $(this).attr('counter');

      var values = [];
      var ovalues = [];
      $("input[name='qty[]']").each(function() {
       values.push($(this).val());
      });

      $("input[name='oldqty[]']").each(function() {
       ovalues.push($(this).val());
      });

      var quantity = values[counter];
      var oldquantity = ovalues[counter];


      if(plan == 'ANNUAL' && (oldquantity > quantity)){
       alert('Number of licences can only be increased and not decreased')
       return false;
      }

     var postdata = {subid:subid, plan:plan, googleid:googleid, quantity:quantity};


     var ajaxurl =  urlroot + '/subscriptions/updategooglesubscriptions';

       $.ajax({
           type: "POST",
           url: ajaxurl,
           data : postdata,
           beforeSend: function () {
               $.blockUI();
           },
           success: function(text) {
              $("#testarea").notify('Quantity sucessfully updated', "success" );
              //$("#testarea").html(text)
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
