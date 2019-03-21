$(document).ready(function() {


    const urlroot = marketplacecfg.urlroot;

//This handles the datatables
// TODO  : will be moved from here to separate js file
    $('.holidaytable').DataTable({
        responsive: true,
        "order": [
            [1, "asc"]
        ]
    });
    $('.apptables').DataTable({
        responsive: true
    });

// Handles the tabs on pagesCount
// TODO : will be moved from here to separate js file
    $('#tabs').tabs();

  // datepicker

  $("#from, #to, #prostart, #proend, #hiredate, #dob, #entrydate, #exitdate, #contractstart, #contractend").datepicker({inline: true,
  changeMonth: true, changeYear: true, yearRange: "1920:2080", dateFormat: 'yy-mm-dd' });

  $(".alldate").datepicker({inline: true,
  changeMonth: true, changeYear: true, yearRange: "1920:2080", dateFormat: 'yy-mm-dd' });


// This Function will handle all ajax post request
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


    function AjaxPostRedirection(ajaxurl, postdata, redirectionurl){

                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data : postdata,
                    beforeSend: function () {
                        $.blockUI();
                    },
                    success: function (text) {
                       window.location.href = redirectionurl;
                    },
                    complete: function () {
                        $.unblockUI();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + " " + thrownError);
                    }
                });
    }


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


    function AjaxPostRequestforbooking(ajaxurl, postdata, containerclass,selectedday){

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data : postdata,
            beforeSend: function () {
                $.blockUI();
            },
            success: function (text) {
                $('.' + containerclass + '').html(text);
                $('#startdate').val(selectedday);
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }
        });
    }

    function viewevent(eventid) {
        ajaxurl = urlroot + '/operations/eventview';
        postdata = { eventid: eventid };
        containerclass = "bookingform";
        console.log("eventview method");
        AjaxPostContainer(ajaxurl, postdata, containerclass);
    }

    function callbookingform(selectedday) {
        ajaxurl = urlroot + '/operations/bookingform';
        postdata = {};
        containerclass = "bookingform";
        console.log("callbooking form method");
        AjaxPostRequestforbooking(ajaxurl, postdata, containerclass, selectedday);
    }

    $(document).on('click', '.deletecompany', function(){

        //$('#viewmodal').modal('show');
        var companyid =  $(this).attr('companyid');


        var postdata = {companyid:companyid};
        var ajaxurl =  urlroot + '/ajax/deletecompany';
        var redirectionurl =  urlroot + '/pages/companies';

        if(confirm('Do you want to delete company ?')){
        AjaxPostRedirection(ajaxurl, postdata,redirectionurl);
        }

    })


    $(document).on('click', '.deletedepartment', function(){

        var  departmentid =  $(this).attr('departmentid');

        var postdata = {departmentid:departmentid};
        var ajaxurl =  urlroot + '/ajax/deletedepartment';
        var redirectionurl =  urlroot + '/pages/departments';

        if(confirm('Do you want to delete department ?')){
         AjaxPostRedirection(ajaxurl, postdata,redirectionurl);
        }

    })


    $(document).on('click', '.deleteholiday', function(){

        var  holidayid =  $(this).attr('holidayid');

        var postdata = {holidayid:holidayid};
        var ajaxurl =  urlroot + '/ajax/deleteholiday';
        var redirectionurl =  urlroot + '/operations/holiday';

        if(confirm('Do you want to delete holiday ?')){
         AjaxPostRedirection(ajaxurl, postdata,redirectionurl);
        }

    })


    $(document).on('click', '.deleteleaveday', function(){

        var  daysid =  $(this).attr('daysid');

        var postdata = {daysid:daysid};
        var ajaxurl =  urlroot + '/ajax/deleteleavedays';
        var redirectionurl =  urlroot + '/operations/leavedays';

        if(confirm('Do you want to delete leave day ?')){
         AjaxPostRedirection(ajaxurl, postdata,redirectionurl);
        }

    })
    $(document).on('click', '.deleteposition', function(){

        var  posid =  $(this).attr('posid');

        var postdata = {posid:posid};
        var ajaxurl =  urlroot + '/ajax/deleteposition';
        var redirectionurl =  urlroot + '/pages/positions';

        if(confirm('Do you want to delete positions ?')){
         AjaxPostRedirection(ajaxurl, postdata,redirectionurl);
        }

    })


    $(document).on('click', '.deletebranch', function(){

        var  branchid =  $(this).attr('branchid');

        var postdata = {branchid:branchid};
        var ajaxurl =  urlroot + '/ajax/deletebranch';
        var redirectionurl =  urlroot + '/pages/branches';

        if(confirm('Do you want to delete branch ?')){
         AjaxPostRedirection(ajaxurl, postdata,redirectionurl);
        }

    })

    $(document).on('click', '.deleteperiod', function(){

        var  periodid =  $(this).attr('periodid');


        var postdata = {periodid:periodid};
        var ajaxurl =  urlroot + '/ajax/deleteperiod';
        var redirectionurl =  urlroot + '/pages/payperiod';

        if(confirm('Do you want to delete period ?')){
         AjaxPostRedirection(ajaxurl, postdata,redirectionurl);
        }

    })
    $(document).on('click', '.deleteasset', function(){
        
                var  assetid =  $(this).attr('assetid');
    
                var postdata = {assetid:assetid};
                var ajaxurl =  urlroot + '/ajax/deleteasset';        
                if(confirm('Do you want to delete ?')){
                    AjaxPostRequest(ajaxurl, postdata);
                }
                window.location.href='';
        
            })

    $(document).on('click', '.deleteemployee', function(){

        var  employeeid =  $(this).attr('employeeid');


        var postdata = {employeeid:employeeid};
        var ajaxurl =  urlroot + '/ajax/deleteemployee';
        var redirectionurl =  urlroot + '/pages/employees';

        if(confirm('Do you want to delete employee ?')){
         AjaxPostRedirection(ajaxurl, postdata,redirectionurl);
        }

    })

    $(document).on('click', '.deletevisaemployee', function(){

        var  employeeid =  $(this).attr('employeeid');

        var postdata = {employeeid:employeeid};
        var ajaxurl =  urlroot + '/ajax/deleteemployee';
        var redirectionurl =  urlroot + '/pages/visaemployees';

        if(confirm('Do you want to delete employee ?')){
         AjaxPostRedirection(ajaxurl, postdata,redirectionurl);
        }

    })


    $(document).on('click', '.configurefixed', function(){

      $('#viewmodal').modal('show');
      var posid = $(this).attr('posid');
      var postdata = {posid:posid};
      var ajaxurl =  urlroot + '/payrollconfig/fixedconfig';
      AjaxPostRequest(ajaxurl, postdata)

    })

    $(document).on('click', '.configureofficer', function(){

      $('#viewmodal').modal('show');
      var posid = $(this).attr('posid');
      var postdata = {posid:posid};
      var ajaxurl =  urlroot + '/payrollconfig/officerconfig';
      AjaxPostRequest(ajaxurl, postdata)

    })

    $(document).on('click', '.editemployee', function(){


          $('#empmodal').modal('show');
          var employeeid = $(this).attr('employeeid');


          var postdata = {employeeid:employeeid};
          var ajaxurl =  urlroot + '/pages/editemployee';
          AjaxPostRequest(ajaxurl, postdata)

   })


    $('#compval, #company').change(function(){

        var compvalue  =  $(this).val();
        var postdata = {compvalue:compvalue};
        var ajaxurl =  urlroot + '/ajax/departmentdata';

        $('#department').html('');

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data : postdata,
            beforeSend: function () {
                $.blockUI();
            },
            success: function (json) {

                var data = JSON.parse(json);
                $('#department').append('<option>' + 'Select Department' + '</option>');
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                      $('#department').append('<option>' + data[key].departmentname + '</option>');
                    }
                }

            },
            complete: function () {
                $.unblockUI();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }
        });
    })


    $('#department').change(function(){

          var compvalue  = $('#compval').val();
          var department = $(this).val();
          var postdata = {compvalue:compvalue, department:department};
          var ajaxurl =  urlroot + '/ajax/positiondata';

          $('#position').html('');

          $.ajax({
              type: "POST",
              url: ajaxurl,
              data : postdata,
              beforeSend: function () {
                  $.blockUI();
              },
              success: function (json) {

                  var data = JSON.parse(json);
                  $('#position').append('<option>' + 'Select Position' + '</option>');
                  for (var key in data) {
                      if (data.hasOwnProperty(key)) {

                        $('#position').append('<option>' + data[key].positionname + '</option>');
                      }
                  }

              },
              complete: function () {
                  $.unblockUI();
              },
              error: function (xhr, ajaxOptions, thrownError) {
                  alert(xhr.status + " " + thrownError);
              }
          });
      })





      $('#bankname').change(function(){

          var bankname = $(this).val();
          var postdata = {bankname:bankname};
          var ajaxurl =  urlroot + '/ajax/branchdata';

          $('#branch').html('');

          $.ajax({
              type: "POST",
              url: ajaxurl,
              data : postdata,
              beforeSend: function () {
                  $.blockUI();
              },
              success: function (json) {
                  var data = JSON.parse(json);

                  for (var key in data) {
                      if (data.hasOwnProperty(key)) {
                        $('#branch').append('<option>' + data[key].branch + '</option>');
                      }
                  }

              },
              complete: function () {
                  $.unblockUI();
              },
              error: function (xhr, ajaxOptions, thrownError) {
                  alert(xhr.status + " " + thrownError);
              }
          });
      })





    $(document).on('click', '#updatepositionbtn', function(){


      var posid = $('#posid').val();
      var totalfullpresent = $('#totalfullpresent').val();
      var basicsalary = $('#basicsalary').val();
      var transportallowance = $('#transportallowance').val();
      var gross = $('#gross').val();
      var weekdayhourlyrate = $('#weekdayhourlyrate').val();
      var weekdayovertimerate = $('#weekdayovertimerate').val();
      var holidayovertimerate = $('#holidayovertimerate').val();
      var nightshiftallowance = $('#nightshiftallowance').val();

      var company = $(this).attr('company');
      var department = $(this).attr('department');
      var position = $(this).attr('position');


      var postdata = {totalfullpresent:totalfullpresent, basicsalary:basicsalary, transportallowance:transportallowance,
                      weekdayhourlyrate:weekdayhourlyrate, weekdayovertimerate:weekdayovertimerate,
                      holidayovertimerate:holidayovertimerate, nightshiftallowance:nightshiftallowance, gross:gross,
                      posid:posid, company:company, department:department, position:position};

      var ajaxurl =  urlroot + '/payrollconfig/updatefixedconfig';
      var  redirectionurl =  urlroot + '/pages/positions';
      AjaxPostRedirection(ajaxurl, postdata,redirectionurl);

    })


    $(document).on('click', '#updateofficerbtn', function(){


      var posid = $('#posid').val();
      var basicsalary = $('#basicsalary').val();

      var company = $(this).attr('company');
      var department = $(this).attr('department');
      var position = $(this).attr('position');


      var postdata = {basicsalary:basicsalary,
                      posid:posid, company:company, department:department, position:position};

      var ajaxurl =  urlroot + '/payrollconfig/updateofficerconfig';
      var  redirectionurl =  urlroot + '/pages/positions';
      AjaxPostRedirection(ajaxurl, postdata,redirectionurl);

    })


    // $(document).on('click', '.featured', function(){

    //     var propertyid = $(this).attr('propertyid');


    //     if($(this).is(':checked') == true){

    //         var  fvalue = 'Yes';
    //         var postdata = {fvalue:fvalue, propertyid:propertyid};
    //         var ajaxurl =  urlroot + '/ajax/featured';
    //         alert('Featured Successfully');
    //         var  redirectionurl =  urlroot + '/pages/property';
    //         AjaxPostRedirection(ajaxurl, postdata,redirectionurl);


    //     }else{
    //         var  fvalue = 'No';
    //         var postdata = {fvalue:fvalue, propertyid:propertyid};
    //         var ajaxurl =  urlroot + '/ajax/featured';
    //         var  redirectionurl =  urlroot + '/pages/property';
    //          AjaxPostRedirection(ajaxurl, postdata,redirectionurl);


    //     }

    // })

    $(document).on('click', '#addemployeebtn', function(){

        var  firstname = $('#firstname').val();
        var  lastname = $('#lastname').val();
        var  othernames = $('#othernames').val();
        var  dob = $('#dob').val();
        var  telephone = $('#telephone').val();
        var  email = $('#email').val();
        var  location = $('#location').val();
        var  idtype = $('#idtype').val();
        var  idnumber = $('#idnumber').val();
        var  bankname = $('#bankname').val();
        var  accountnumber = $('#accountno').val();
        var  branch = $('#branch').val();
        var  ssnitnumber = $('#ssnit').val();
        var  gname = $('#gname').val();
        var  gtelephone = $('#gtelephone').val();
        var  dateofbirth = $('#dob').val();
        var  department = $('#department').val();
        var  position = $('#position').val();
        var  staffid = $('#staffid').val();
        var  hiredate = $('#hiredate').val();
        var  probationstart = $('#prostart').val();
        var  probationend = $('#proend').val();
        var  company = $('#compval').val();
        var  tinnumber = $('#tinnumber').val();
        var  tierno = $('#tierno').val();

        var  nationality = $('#nationality').val();
        var  academictitle = $('#academictitle').val();
        var  contractallocation = $('#contractallocation').val();
        var  contractstart = $('#contractstart').val();
        var  contractend = $('#contractend').val();
        var  entrydate = $('#entrydate').val();
        var  exitdate = $('#exitdate').val();
        var  gender = $('#gender').val();
        var  category = $('#category').val();
        var  basicsalary = $('#basicsalary').val();
        var  randomnumber = $('#randomnumber').val();
        var  maritalstatus = $('#maritalstatus').val();



        var  addemployee = 'Add';


        var postdata = {firstname:firstname, lastname:lastname, othernames:othernames, telephone:telephone,
        email:email,  location: location, idtype:idtype, idnumber:idnumber, bankname:bankname, accountnumber:accountnumber,
        branch:branch, ssnitnumber:ssnitnumber,  gname:gname, gtelephone:gtelephone, dateofbirth:dateofbirth,
        department:department, position:position, staffid:staffid, hiredate:hiredate, probationstart:probationstart,
        probationend:probationend,randomnumber:randomnumber,maritalstatus:maritalstatus, company:company, addemployee:addemployee, dob:dob, tinnumber:tinnumber, tierno:tierno,nationality:nationality,academictitle:academictitle,contractallocation:contractallocation,contractstart:contractstart,contractend:contractend,entrydate:entrydate,exitdate:exitdate,gender:gender,category:category,basicsalary:basicsalary};

        var  ajaxurl =  urlroot + '/pages/employees';
        var  redirectionurl =  urlroot + '/pages/employees';
        AjaxPostRedirection(ajaxurl, postdata,redirectionurl);

    })

    function visacontinue(basicid){
        //$('#viewmodal').modal('show');
        var postdata = {};
        var ajaxurl =  urlroot + '/ajax/visacontinue/'+basicid;

        $('#visarea').hide();
        $('#visacont').show();

         $.ajax({
            type: "GET",
            url: ajaxurl,
            data : postdata,
            success: function (text) {
              $('#visacont').html(text);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }
          });;
    }

    $(document).on('click', '#addvisaemployeebtn', function(){

      var firstname = $('#firstname').val();
			var lastname = $('#lastname').val();
			var telephone = $('#telephone').val();

			var dob = $('#dob').val();
		  var yearofbirth = $('#yearofbirth').val();
			var profession = $('#profession').val();
			var intendedprofession = $('#intendedprofession').val();
			var passportnumber = $('#passportnumber').val();
			var dateofpassportexpiry = $('#dateofpassportexpiry').val();
			var dateofpassportissue = $('#dateofpassportissue').val();
			var gender = $('#gender').val();
			var fathersname = $('#fathersname').val();
			var mothersname = $('#mothersname').val();
			var spousename = $('#spousename').val();
			var spousedob = $('#spousedob').val();
			var spouseplaceofbirth = $('#spouseplaceofbirth').val();
			var spousetelephone = $('#spousetelephone').val();

			var familyaddress = $('#familyaddress').val();
			var numberofchildren = $('#numberofchildren').val();
			var company = $('#company').val();

      var height = $('#height').val();

      var error = '';

      if(company == '') { error = 'Company Required ! \n'; }
      if(firstname == '') { error += 'Firstname Required ! \n'; }
      if(lastname == '') { error += 'Family name Required ! \n'; }

      if(error !== ''){ alert(error); return false;  }

      var postdata =   {
                        firstname:firstname, lastname:lastname, telephone:telephone, dob:dob,
                        yearofbirth:yearofbirth, profession:profession, intendedprofession:intendedprofession,
                        passportnumber:passportnumber, dateofpassportexpiry:dateofpassportexpiry,
                        dateofpassportissue:dateofpassportissue, gender:gender, fathersname:fathersname,
                        mothersname:mothersname, spousename:spousename, spousedob:spousedob,
                        spouseplaceofbirth:spouseplaceofbirth, spousetelephone:spousetelephone,
                        familyaddress:familyaddress, numberofchildren:numberofchildren, company:company,
                        height:height
                       };

      var  ajaxurl =  urlroot + '/ajax/savevisaemploye';

             $.ajax({
                 type: "POST",
                 url: ajaxurl,
                 data : postdata,
                 success: function (basicid) {
                   $('#visarea').hide();
                   $('#visacont').show();
                   visacontinue(basicid)
                 },
                 error: function (xhr, ajaxOptions, thrownError) {
                     alert(xhr.status + " " + thrownError);
                 }
               });


    })




   $(document).on('click', '#updateemployeebtn', function(){
       // $('#updateemployeebtn').on('click', function(){

                var  firstname = $('#firstname').val();
                var  lastname = $('#lastname').val();
                var  othernames = $('#othernames').val();
                var  dob = $('#dob').val();
                var  telephone = $('#telephone').val();
                var  email = $('#email').val();
                var  location = $('#location').val();
                var  idtype = $('#idtype').val();
                var  idnumber = $('#idnumber').val();
                var  bankname = $('#bankname').val();
                var  accountnumber = $('#accountno').val();
                var  branch = $('#branch').val();
                var  ssnitnumber = $('#ssnit').val();
                var  gname = $('#gname').val();
                var  gtelephone = $('#gtelephone').val();
                var  dateofbirth = $('#dob').val();
                var  department = $('#department').val();
                var  position = $('#position').val();
                var  staffid = $('#staffid').val();
                var  hiredate = $('#hiredate').val();
                var  probationstart = $('#prostart').val();
                var  probationend = $('#proend').val();
                var  company = $('#compval').val();
                var  tinnumber = $('#tinnumber').val();
                var  tierno = $('#tierno').val();
                var  employeeid = $('#employeeid').val();

                var  nationality = $('#nationality').val();
                var  academictitle = $('#academictitle').val();
                var  contractallocation = $('#contractallocation').val();
                var  contractstart = $('#contractstart').val();
                var  contractend = $('#contractend').val();
                var  entrydate = $('#entrydate').val();
                var  exitdate = $('#exitdate').val();
                var  gender = $('#gender').val();
                var  category = $('#category').val();
                var  basicsalary = $('#basicsalary').val();

                var  updateemployee = 'Update';


                var postdata = {firstname:firstname, lastname:lastname, othernames:othernames, telephone:telephone,
                email:email,  location: location, idtype:idtype, idnumber:idnumber, bankname:bankname, accountnumber:accountnumber,
                branch:branch, ssnitnumber:ssnitnumber,  gname:gname, gtelephone:gtelephone, dateofbirth:dateofbirth,
                department:department, position:position, staffid:staffid, hiredate:hiredate, probationstart:probationstart,
                probationend:probationend, company:company, updateemployee:updateemployee, dob:dob, tinnumber:tinnumber, tierno:tierno,
                employeeid:employeeid,nationality:nationality,academictitle:academictitle,contractallocation:contractallocation,contractstart:contractstart,contractend:contractend,entrydate:entrydate,exitdate:exitdate,gender:gender,category:category,basicsalary:basicsalary};

                console.log(postdata);
                var  ajaxurl =  urlroot + '/pages/updateemployee';
                var  redirectionurl =  urlroot + '/pages/employees';
               // AjaxPostRedirection(ajaxurl, postdata,redirectionurl);
                //AjaxPostRequest(ajaxurl, postdata);


            })


    $('.pay').focusin(function(){


            var field = $(this).attr('field');
            var recurrentid = $(this).attr('recurrentid');

            var  ajaxurl =  urlroot + '/payrollconfig/updaterecurrent';

            $(this).focusout(function(){
                var value =$(this).val();

                var postdata = {field:field, recurrentid:recurrentid, value:value};
                 $.ajax({
                    type: "POST",
                    url:  ajaxurl,
                    data: postdata,
                    dataType: "html",
                    beforeSend: function () {},
                    success: function (text) {
                     $('#ajaxcontainer').html(text);
                    },
                    complete: function () {},
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + " " + thrownError);

                    }
                    })
            })
            return false;
        });


         $(document).on('click', '.deletetask', function(){
            var taskid  = $(this).attr('taskid');

            var postdata = {taskid:taskid};
            var ajaxurl =  urlroot + '/ajax/deletetask';
            var redirectionurl =  urlroot + '/task/create';
             if(confirm('Do you want to delete task ?')){
             AjaxPostRedirection(ajaxurl, postdata, redirectionurl);
            }
         })

         $(document).on('click', '.morefeedback', function(){
            var fid  = $(this).attr('fid');
            $('.ui.modal').modal('destroy');
            $('#viewmodal').modal('show');
            var postdata = {fid:fid};
            var ajaxurl =  urlroot + '/ajax/feedbackresponse';
            AjaxPostRequest(ajaxurl, postdata);

         })


         $(document).on('click', '#updatepassword', function(){

            var uid  = $(this).attr('uid');

            var password  = $('#password').val();
            var confirmpassword  = $('#confirmpassword').val();

            if(password == '') { alert('Password required'); return false; }
            if(password !== confirmpassword) { alert('Both passwords must match'); return false; }

            var postdata = {password:password, uid:uid };
            var ajaxurl =  urlroot + '/ajax/updatepassword';
            $.ajax({
               type: "POST",
               url:  ajaxurl,
               data: postdata,
               dataType: "html",
               beforeSend: function () {},
               success: function (text) {

                alert('Password Successfully changed');
               },
               complete: function () {},
               error: function (xhr, ajaxOptions, thrownError) {
                   alert(xhr.status + " " + thrownError);
               }
               })

         })



         $(document).on('click', '#updatevisaemployeebtn', function(){

          var firstname = $('#firstname').val();
     			var lastname = $('#lastname').val();
     			var telephone = $('#telephone').val();

     			var dob = $('#dob').val();
     		  var yearofbirth = $('#yearofbirth').val();
     			var profession = $('#profession').val();
     			var intendedprofession = $('#intendedprofession').val();
     			var passportnumber = $('#passportnumber').val();
     			var dateofpassportexpiry = $('#dateofpassportexpiry').val();
     			var dateofpassportissue = $('#dateofpassportissue').val();
     			var gender = $('#gender').val();
     			var fathersname = $('#fathersname').val();
     			var mothersname = $('#mothersname').val();
     			var spousename = $('#spousename').val();
     			var spousedob = $('#spousedob').val();
     			var spouseplaceofbirth = $('#spouseplaceofbirth').val();
     			var spousetelephone = $('#spousetelephone').val();

     			var familyaddress = $('#familyaddress').val();
     			var numberofchildren = $('#numberofchildren').val();
     			var company = $('#company').val();
          var height = $('#height').val();
          var basicid  = $('#basicid').val();

           var error = '';

           if(company == '') { error = 'Company Required ! \n'; }
           if(firstname == '') { error += 'Firstname Required ! \n'; }
           if(lastname == '') { error += 'Family name Required ! \n'; }

           if(error !== ''){ alert(error); return false;  }

           var postdata =   {
                             firstname:firstname, lastname:lastname, telephone:telephone, dob:dob,
                             yearofbirth:yearofbirth, profession:profession, intendedprofession:intendedprofession,
                             passportnumber:passportnumber, dateofpassportexpiry:dateofpassportexpiry,
                             dateofpassportissue:dateofpassportissue, gender:gender, fathersname:fathersname,
                             mothersname:mothersname, spousename:spousename, spousedob:spousedob,
                             spouseplaceofbirth:spouseplaceofbirth, spousetelephone:spousetelephone,
                             familyaddress:familyaddress, numberofchildren:numberofchildren, company:company,
                             height:height
                            };

          var  ajaxurl =  urlroot + '/ajax/savevisaemploye/'+basicid;
          var  redirectionurl =  urlroot + '/pages/visaemployeeedit/'+basicid;
          AjaxPostRedirection(ajaxurl, postdata,redirectionurl);

         })

          $(document).on('click', '#recruitbtn', function(){

            var basicid = $(this).attr('basicid');

             if(confirm('Do you want to recruit ?')){

               var  ajaxurl =  urlroot + '/ajax/recruit/'+basicid;


               $.ajax({
                  type: "POST",
                  url:  ajaxurl,
                  data: {},
                  dataType: "html",
                  beforeSend: function () {
                    $.blockUI();
                  },
                  success: function (text) {
                    alert(text)
                   alert('Employee successfully recruited');
                  },
                  complete: function () {
                    $.unblockUI();
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                      alert(xhr.status + " " + thrownError);
                  }
                })

             }

          })


          $(document).on('click', '#grievancebtn', function(){
            var employeeid   = $('#employeeid').val();
            if (employeeid=='')return;
            var postdata = {employeeid:employeeid};
             var ajaxurl =  urlroot + '/operations/grievanceform';
             $.ajax({
                type: "POST",
                url:  ajaxurl,
                data: postdata,
                dataType: "html",
                beforeSend: function () {
                  $.blockUI();
                },
                success: function (text) {
                  $('#searchcontainer').html(text)
                },
                complete: function () {
                  $.unblockUI();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                }
              })

          })


          $(document).on('click', '#disciplinarybtn', function(){
            var employeeid   = $('#employeeid').val();
            if (employeeid=='')return;
            var postdata = {employeeid:employeeid};
             var ajaxurl =  urlroot + '/operations/disciplineform';
             $.ajax({
                type: "POST",
                url:  ajaxurl,
                data: postdata,
                dataType: "html",
                beforeSend: function () {
                  $.blockUI();
                },
                success: function (text) {
                  $('#searchcontainer').html(text)
                },
                complete: function () {
                  $.unblockUI();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                }
              })

          })

          $(document).on('click', '#transferbtn', function(){
            var employeeid   = $('#employeeid').val();
            if (employeeid=='')return;
            var postdata = {employeeid:employeeid};
             var ajaxurl =  urlroot + '/operations/transferform';
             $.ajax({
                type: "POST",
                url:  ajaxurl,
                data: postdata,
                dataType: "html",
                beforeSend: function () {
                  $.blockUI();
                },
                success: function (text) {
                  $('#searchcontainer').html(text)
                },
                complete: function () {
                  $.unblockUI();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                }
              })

          })


          $(document).on('click', '#promotionbtn', function(){
            var employeeid   = $('#employeeid').val();
            if (employeeid=='')return;
            var postdata = {employeeid:employeeid};
               var ajaxurl =  urlroot + '/operations/promotionform';
               $.ajax({
                  type: "POST",
                  url:  ajaxurl,
                  data: postdata,
                  dataType: "html",
                  beforeSend: function () {
                    $.blockUI();
                  },
                  success: function (text) {
                    $('#searchcontainer').html(text)
                  },
                  complete: function () {
                    $.unblockUI();
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                      alert(xhr.status + " " + thrownError);
                  }
                })

          })

          $(document).on('click', '#assetsbtn', function(){
            var employeeid   = $('#employeeid').val();
            if (employeeid=='')return;
            var postdata = {employeeid:employeeid};
               var ajaxurl =  urlroot + '/operations/assetsform';
               $.ajax({
                  type: "POST",
                  url:  ajaxurl,
                  data: postdata,
                  dataType: "html",
                  beforeSend: function () {
                    $.blockUI();
                  },
                  success: function (text) {
                    $('#searchcontainer').html(text)
                  },
                  complete: function () {
                    $.unblockUI();
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                      alert(xhr.status + " " + thrownError);
                  }
                })

          })

          $(document).on('click', '#appraisalbtn', function(){
            var employeeid   = $('#employeeid').val();
            if (employeeid=='')return;
            var postdata = {employeeid:employeeid};
               var ajaxurl =  urlroot + '/operations/appraisalform';
               $.ajax({
                  type: "POST",
                  url:  ajaxurl,
                  data: postdata,
                  dataType: "html",
                  beforeSend: function () {
                    $.blockUI();
                  },
                  success: function (text) {
                    $('#searchcontainer').html(text)
                  },
                  complete: function () {
                    $.unblockUI();
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                      alert(xhr.status + " " + thrownError);
                  }
                })

          })

          $(document).on('click', '#leavebtn', function(){
               var employeeid   = $('#employeeid').val();
               if (employeeid=='')return;
               var postdata = {employeeid:employeeid};
               var ajaxurl =  urlroot + '/operations/leaveform';
               $.ajax({
                  type: "POST",
                  url:  ajaxurl,
                  data: postdata,
                  dataType: "html",
                  beforeSend: function () {
                    $.blockUI();
                  },
                  success: function (text) {
                    $('#searchcontainer').html(text)
                  },
                  complete: function () {
                    $.unblockUI();
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                      alert(xhr.status + " " + thrownError);
                  }
                })

          })


      $(document).on('click', '.promoactionmodule', function(){

        $('#viewmodal').modal('show');
        var status = $(this).attr('status');
        var actionid = $(this).attr('actionid');
        var postdata = {status:status, actionid:actionid};
        var ajaxurl =  urlroot + '/ajax/actiontransferpromo';
        AjaxPostRequest(ajaxurl, postdata)
      })

      $(document).on('click', '.operationnmodule', function(){
        $('#viewmodal').modal('show');
        var status = $(this).attr('status');
        var actionid = $(this).attr('actionid');
        var postdata = {status:status, actionid:actionid};
        var ajaxurl =  urlroot + '/ajax/actiongrievedis';
        AjaxPostRequest(ajaxurl, postdata)
      })


      $(document).on('click', '.actionleave', function(){
          $('#viewmodal').modal('show');
          var actionid = $(this).attr('actionid');
          var postdata = {actionid:actionid};
          var ajaxurl =  urlroot + '/ajax/actionleave';
          AjaxPostRequest(ajaxurl, postdata)
        })

        $(document).on('click', '.promoteaction', function(){

          var status = $(this).attr('status');
          var actionid = $(this).attr('actionid');
          var employeeid = $(this).attr('employeeid');
          var department = $(this).attr('department');
          var position = $(this).attr('position');
          var action = $('#action').val();
          var postdata = {status:status, actionid:actionid, employeeid:employeeid, action:action,
                          department:department, position:position};

          var ajaxurl =  urlroot + '/ajax/promoupdate';
          var redirectionurl =  urlroot + '/operations/operationsview/'+ status;
          $('#viewmodal').modal('hide');
          AjaxPostRedirection(ajaxurl, postdata, redirectionurl)

        })

        $(document).on('click', '.updateleave', function(){
          var actionid = $(this).attr('actionid');
          var action = $('#action').val();
          var postdata = {actionid:actionid, action:action};
          var ajaxurl =  urlroot + '/ajax/updateleave';
          var redirectionurl =  urlroot + '/operations/operationsview/Leave';
          $('#viewmodal').modal('hide');
          AjaxPostRedirection(ajaxurl, postdata, redirectionurl)

        })

        $(document).on('click', '.updategrievedis', function(){

          var status = $(this).attr('status');
          var actionid = $(this).attr('actionid');
          var position = $(this).attr('position');
          var action = $('#action').val();

          var postdata = {status:status, action:action, actionid:actionid };

          var ajaxurl =  urlroot + '/ajax/updategrievedis';
          var redirectionurl =  urlroot + '/operations/operationsview/'+ status;
          $('#viewmodal').modal('hide');
          AjaxPostRedirection(ajaxurl, postdata, redirectionurl)

        })



        $(document).on('click', '#approvecompany', function(){

          var companyid = $(this).attr('companyid');

          var postdata = { companyid:companyid };

          var ajaxurl =  urlroot + '/ajax/approvecompany';
          var redirectionurl =  urlroot + '/pages/companyprofile/'+companyid;

            if(confirm('Do you want approve this company ?')){
            AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
            }

        })

        $(document).on('change', '.designation', function(){
            var employeeid = $(this).attr('employeeid');
            var designation  = $(this).val();

            var postdata = {employeeid:employeeid, designation:designation };
            var ajaxurl =  urlroot + '/ajax/updatedesignation';
            var redirectionurl =  urlroot + '/pages/designation';
            AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
        })


        // full calendar scripts

         //calendar view called in dashboard by id given
    $('#calendar').fullCalendar({
        header: {
            left:   'today',
            center: 'title',
            right:  'month agendaWeek prev,next'
          },
        fixedWeekCount: false,
        height: 660,



        eventClick: function(calEvent, jsEvent, view) {
            var utitle = calEvent.title;
            var udate = moment(calEvent.start).format();
            var eventid = calEvent.id;

            window.location.href= urlroot+'/Operations/operationprofile/Leave/'+eventid;
           // $('#myCalendarModal').modal('show');
          //  viewevent(eventid);
            //$("#bookingModal").modal('hide');
        },

        dayClick: function(date, jsEvent, view) {

            var selectedday = date.format("YYYY-MM-DD"); //selected date from the calendar
            var tday = new Date();
            var todaydate = moment(tday).format("YYYY-MM-DD");
            var formatdate = date.format("YYYY-MM-DD");
         //   $('#eventdate').val(selectedday);
            if (todaydate === selectedday || date.isAfter(todaydate)) {
           //     $('#myCalendarModal').modal('show');
             //   callbookingform(formatdate);

            } else {
                //    Nothing happens
            }


        },
        //events: eventjson,
        eventSources: [

            // your event source
            {
              url: urlroot+'/operations/holidaylist', // use the `url` property
              color: 'green',    // an option!
              textColor: 'white'  // an option!
            },
            {
                url: urlroot+'/operations/leavelist', // use the `url` property
                color: '#00ACE5',    // an option!
                textColor: 'white'  // an option!
              }
        
            // any other sources...
        
          ],
        displayEventTime: false,
        eventRender: function(event, element) {
            var today = new Date();
            var old = new Date(event.start);
            var mtoday = moment(today).format("YYYY-MM-DD");
            var mold = moment(old).format("YYYY-MM-DD");
            if (event.icon) {
                element.find(".fc-title").prepend("<i style='color:white;padding-left:3%;padding-right:5px' class='fa fa-" + event.icon + "'></i>");
                element.css('border-radius', '2px')
            }

           /* if (moment(mold).isBefore(mtoday, 'day')) {
                element.css({ 'background': '#A1565F', 'border': 'none', 'border-radius': '2px' })
            }*/
        }
    });


    //autocomplete for employees
    $('.employeename').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: urlroot + "/pages/searchemployee",
                type: 'GET',
                dataType: "json",
                data: {
                    term: request.term,
                    request: 'search'
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.name,
                            value: item.id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label); // display the selected text
            var employeeid = ui.item.value; // selected value
            console.log(employeeid);
            $("#employeeid").val(employeeid);
            return false;
        },
        minLength: 2
    });
    $('.accumulated').focusin(function(){


        var field = $(this).attr('field');
        var employeeid = $(this).attr('employeeid');

        var  ajaxurl =  urlroot + '/operations/leaveconfig';

        $(this).focusout(function(){
            var value =$(this).val();

            var postdata = {field:field, employeeid:employeeid, value:value};
             $.ajax({
                type: "POST",
                url:  ajaxurl,
                data: postdata,
                dataType: "html",
                beforeSend: function () {},
                success: function (text) {
               //  $('#ajaxcontainer').html(text);
                },
                complete: function () {},
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);

                }
                })
        })
        return false;
    });

    $("#maritalstatus").change(function (e) { 
        e.preventDefault();
        var x = $(this).val();
        var randomnumber = $("#randomnumber").val();
        ajaxurl = urlroot + "/pages/marital";
        postdata = {randomnumber:randomnumber};
        if (x == "Married"){
            $("#maritalmodal").modal('show');
            AjaxPostContainer(ajaxurl,postdata,'mform');

        }
    });
    $("#viewmarital").click(function (e) { 
        e.preventDefault();
        var randomnumber = $("#randomnumber").val();
        ajaxurl = urlroot + "/pages/marital";
        postdata = {randomnumber:randomnumber};
            $("#maritalmodal").modal('show');
            AjaxPostContainer(ajaxurl,postdata,'mform');

        
    });
     $("#employeefolder").click(function (e) { 
        e.preventDefault();
        var randomnumber = $("#randomnumber").val();
        ajaxurl = urlroot + "/pages/folder";
        postdata = {randomnumber:randomnumber};
            $("#foldermodal").modal('show');
            AjaxPostContainer(ajaxurl,postdata,'folderform');

        
    });

    $(document).on('click', '.editdepartment', function(){

        $('#viewmodal').modal('show');
        var departmentid = $(this).attr('departmentid');
        var postdata = {departmentid:departmentid};
        var ajaxurl =  urlroot + '/pages/editdepartment';
        AjaxPostRequest(ajaxurl, postdata)

    })

    $(document).on('click', '.updatedepartment', function(){

        $('#viewmodal').modal('hide');
        var departmentid = $(this).attr('departmentid');
        var departmentname = $('#departmentname').val();
        var departmentcode = $('#departmentcode').val();
        var postdata = {departmentid:departmentid, departmentname:departmentname, departmentcode:departmentcode};
        var ajaxurl =  urlroot + '/ajax/updatedepartment';
        var redirectionurl  = urlroot + '/pages/departments';
        AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
    })

    $(document).on('click', '.editposition', function(){

        $('#viewmodal').modal('show');
        var positionid = $(this).attr('positionid');
        var postdata = {positionid:positionid };
        var ajaxurl =  urlroot + '/pages/editposition';
        AjaxPostRequest(ajaxurl, postdata)

    })


    $(document).on('click', '.editbank', function(){

        $('#viewmodal').modal('show');
        var bankid = $(this).attr('bankid');
        var postdata = {bankid:bankid};
        var ajaxurl =  urlroot + '/pages/editbank';
        AjaxPostRequest(ajaxurl, postdata)

    })

    $(document).on('click', '.updateposition', function(){

        $('#viewmodal').modal('hide');
        var positionid = $(this).attr('positionid');
        var departmentname = $('#departmentname').val();
        var positionname  = $('#positionname').val();
        var postdata = {positionid:positionid , departmentname:departmentname, positionname:positionname};
        var ajaxurl =  urlroot + '/ajax/updateposition';
        var redirectionurl  = urlroot + '/pages/positions';
        AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
    })


    $(document).on('click', '.updatebank', function(){

        $('#viewmodal').modal('hide');
        var bankid = $(this).attr('bankid');
        var bankname = $('#bankname').val();
        var bankcode  = $('#bankcode').val();
        var branchname  = $('#branchname').val();
        var branchcode  = $('#branchcode').val();
        var postdata = {bankid:bankid, bankname:bankname, bankcode:bankcode, branchname:branchname, branchcode:branchcode   };
        var ajaxurl =  urlroot + '/ajax/updatebank';
        var redirectionurl  = urlroot + '/pages/bankcodes';

        alert('Updates successfully done !!! ')
        AjaxPostRedirection(ajaxurl, postdata, redirectionurl)
    })

})
