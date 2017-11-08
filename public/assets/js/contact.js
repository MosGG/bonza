$(document).ready(function() {

	$(".input").focus(function(){
		$(this).siblings('.form-message').css('visibility','hidden');
	});
});

$.ajaxSetup({
    
});

function submit(){
	if (validator()) {
		var formData = {
          	'name' : $('#name').val(),
            'email' : $('#email').val(),
            'phone' : $('#phone').val(),
            'message' : $('#message').val(),
            // '_token' : $('meta[name="csrf-token"]').attr('content'),
        };
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
          	type: 'POST', 
          	url: 'email-sending', 
          	data: formData, 
          	dataType: 'json',
          	encode: true,
          	timeout: 10000,
          	cache: false,
          	beforeSend: function(result) {
				$(".form-submit span").fadeOut();
				$(".fa-paper-plane").addClass("plane-takeoff");
	        },
          	success     : function(result) {
                if(result.sendstatus == 1) {
               		$(".form-submit span").html("SENT");
              	} else {
                    $(".form-submit span").html("Please try again");
                }
            },
          	error: function(request, status, err) {
                request.abort();
                $(".form-submit span").html("Please try again");
            },
            complete:function(){
	        	$(".fa-paper-plane").removeClass("plane-takeoff");
	        	$(".form-submit span").fadeIn();
	        }
    	});
	}
}

function validator(){
	var flag = 0;
	if (!$("#name").val()) {
		$("#name").siblings('.form-message').css('visibility','visible');
		flag = 1;
	}
	if (!$("#phone").val()) {
		$("#phone").siblings('.form-message').css('visibility','visible');
		flag = 1;
	}
	var x = $("#email").val();
  	var atpos = x.indexOf("@");
  	var dotpos = x.lastIndexOf(".");
  	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        $("#email").siblings('.form-message').css('visibility','visible');
        flag = 1;
  	}
	// if (!$("#message").val()) {
	// 	$("#message").siblings('.form-message').css('visibility','visible');
	// 	flag = 1;
	// }
	if (flag == 0){
		return true;
	} else {
		return false;
	}
}