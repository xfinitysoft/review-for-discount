(function( $ ) {
	'use strict';
	$('#xswcrd-trigger-product').select2({ 
		placeholder: "Search for a product...",
	 	width: 'resolve' 
	});
	$('#xsrl-products').select2({
		placeholder: "Search for a product...",
	 	width: 'resolve' 
	});
	$('#xsrl-ex-products').select2({
		placeholder: "Search for a product...",
	 	width: 'resolve' 
	});
	$('#xsrl-category').select2({
		placeholder:"Any category",
		width: 'resolve'
	});
	$('#xsrl-ex-category').select2({
		placeholder:"Any category",
		width: 'resolve'
	});
	$('#xsrl-send-notice').on('click',function(e){
		if($(this).prop('checked') == true){
			$('.xsrl-initial-qty').removeClass('xsrl-hidden');
			$('#xsrl-initial-qty').removeAttr('required');
			$('##xsrl-initial-qty').removeAttr('min');
		}else{
			$('.xsrl-initial-qty').addClass('xsrl-hidden');
			$('#xsrl-initial-qty').attr('required','required');
			$('#xsrl-initial-qty').attr('min','1');
		}
	});
	$('input[data-class="email_test"]').on('click',function(e){
		e.preventDefault();
		var data = $(this).data('id');
		var email = $('#xsrl_'+data+'_email_test').val();
		if(email){
			$.ajax({
				url:ajaxurl, 
				type:'post',
				data:{'action':'send_test_email','email':email,'id':data},
				success: function(res){
					$('.xsrl-'+data+'-email-notice').find('.xsrl-notice-dismiss').show();
					if(res.status == true){
						$('.xsrl-'+data+'-email-notice').removeClass('error');
						$('.xsrl-'+data+'-email-notice').addClass('notice');
						$('.xsrl-'+data+'-email-notice').addClass('notice-success');
						$('.xsrl-'+data+'-email-notice').addClass('is-dismissible');
						$('.xsrl-'+data+'-email-notice p').html(res.message);
						$('.xsrl-'+data+'-email-notice').show();
					}else{
						$('.xsrl-'+data+'-email-notice').removeClass('notice-success');
						$('.xsrl-'+data+'-email-notice').addClass('notice');
						$('.xsrl-'+data+'-email-notice').addClass('error');
						$('.xsrl-'+data+'-email-notice').addClass('is-dismissible');
						$('.xsrl-'+data+'-email-notice p').html(res.message);
						$('.xsrl-'+data+'-email-notice').show();
					}
					
				},
			});
		}else{
			$('.xsrl-'+data+'-email-notice').find('.xsrl-notice-dismiss').show();
			$('.xsrl-'+data+'-email-notice').addClass('notice');
			$('.xsrl-'+data+'-email-notice').addClass('error');
			$('.xsrl-'+data+'-email-notice').addClass('is-dismissible');
			$('.xsrl-'+data+'-email-notice p').html('Please enter the email');
			$('.xsrl-'+data+'-email-notice').show();
		}
	});
	    
	$('#xs_name , #xs_email , #xs_message').on('change',function(e){
        if(!$(this).val()){
            $(this).addClass("error");
        }else{
            $(this).removeClass("error");
        }
    });
    $('.xs_support_form').on('submit' , function(e){ 
        e.preventDefault();
        $('.xs-send-email-notice').hide();
        $('.xs-mail-spinner').addClass('xs_is_active');
        $('#xs_name').removeClass("error");
        $('#xs_email').removeClass("error");
        $('#xs_message').removeClass("error"); 
        
        $.ajax({ 
            url:ajaxurl,
            type:'post',
            data:{'action':'xs_send_mail','data':$(this).serialize()},
            beforeSend: function(){
                if(!$('#xs_name').val()){
                    $('#xs_name').addClass("error");
                    $('.xs-send-email-notice').removeClass('notice-success');
                    $('.xs-send-email-notice').addClass('notice');
                    $('.xs-send-email-notice').addClass('error');
                    $('.xs-send-email-notice').addClass('is-dismissible');
                    $('.xs-send-email-notice p').html('Please fill all the fields');
                    $('.xs-send-email-notice').show();
                    $('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    $('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                 if(!$('#xs_email').val()){
                    $('#xs_email').addClass("error");
                    $('.xs-send-email-notice').removeClass('notice-success');
                    $('.xs-send-email-notice').addClass('notice');
                    $('.xs-send-email-notice').addClass('error');
                    $('.xs-send-email-notice').addClass('is-dismissible');
                    $('.xs-send-email-notice p').html('Please fill all the fields');
                    $('.xs-send-email-notice').show();
                    $('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    $('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                 if(!$('#xs_message').val()){
                    $('#xs_message').addClass("error");
                    $('.xs-send-email-notice').removeClass('notice-success');
                    $('.xs-send-email-notice').addClass('notice');
                    $('.xs-send-email-notice').addClass('error');
                    $('.xs-send-email-notice').addClass('is-dismissible');
                    $('.xs-send-email-notice p').html('Please fill all the fields');
                    $('.xs-send-email-notice').show();
                    $('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    $('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                $('.xs-send-mail').prop('disabled',true);
                $(".xs_support_form :input").prop("disabled", true);
                $("#xs_message").prop("disabled", true);
                
            },
            success: function(res){
                $('.xs-send-email-notice').find('.xs-notice-dismiss').show();
                $('.xs-send-mail').prop('disabled',false);
                $(".xs_support_form :input").prop("disabled", false);
                $("#xs_message").prop("disabled", false);
                if(res.status == true){
                    $('.xs-send-email-notice').removeClass('error');
                    $('.xs-send-email-notice').addClass('notice');
                    $('.xs-send-email-notice').addClass('notice-success');
                    $('.xs-send-email-notice').addClass('is-dismissible');
                    $('.xs-send-email-notice p').html('Successfully sent');
                    $('.xs-send-email-notice').show();
                    $('.xs-notice-dismiss').show();
                    $('.xs_support_form')[0].reset();
                }else{
                    $('.xs-send-email-notice').removeClass('notice-success');
                    $('.xs-send-email-notice').addClass('notice');
                    $('.xs-send-email-notice').addClass('error');
                    $('.xs-send-email-notice').addClass('is-dismissible');
                    $('.xs-send-email-notice p').html('Sent Failed');
                    $('.xs-send-email-notice').show();
                    $('.xs-notice-dismiss').show();
                }
                $('.xs-mail-spinner').removeClass('xs_is_active');
            }

        });
    });
	$('.xsrl-notice-dismiss,.xs-notice-dismiss').on('click',function(e){
		e.preventDefault();
		$(this).parent().hide();
		$(this).hide();
	});
})( jQuery );
