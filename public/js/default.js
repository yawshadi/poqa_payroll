

initialize();

function initialize(){
	
  var mq = window.matchMedia("(min-width: 1230px)");

    if (mq.matches) {
     
	$('.toplogo').css('font-size','30px');
	$('.toplogo').css('width','15%');
	
	$('.mlogo').css('width','8%');
    $('#content1').css('margin-top','10%');
	$('.login-box').css('margin-top','10%');
	$('.tile1').css('width','44%');
	
	} else {
   		
	$('.toplogo').css('font-size','24px');
	$('.toplogo').css('width','30%');
	
	$('.mlogo').css('width','30%');
   $('.login-box').css('margin-top','30%');
   
   $('#content1').css('margin-top','30%');
	$('.tile1').css('width','42%');
	}
	
}

$(window).resize(function () {

    var mq = window.matchMedia("(min-width: 1230px)");

    if (mq.matches) {
     
	$('.toplogo').css('font-size','30px');
	$('.toplogo').css('width','15%');
	$('.mlogo').css('width','8%');
	$('.login-box').css('margin-top','10%');
	$('#content1').css('margin-top','10%');
	$('.tile1').css('width','44%');
    
	} else {
   		
	$('.toplogo').css('font-size','24px');
	$('.toplogo').css('width','30%');
	$('.mlogo').css('width','30%');
	$('.login-box').css('margin-top','30%');
	
	//Account
	$('#content1').css('margin-top','30%');
	$('.tile1').css('width','40%');
    }
});

