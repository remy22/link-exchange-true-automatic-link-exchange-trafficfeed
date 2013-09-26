jQuery(document).ready(function(e) {
	jQuery('.tf_logout').click(function(e) {
   		jQuery.ajax({
	   		url:tf_ajax.ajaxurl,
			data:'action=tf_logout',
			beforeSend:function(){
				jQuery('#tf_logout').attr("disabled", true);
				
				jQuery('#tf_logout').html('Wait while processing...');
			},
			success: function(response){
				
				jQuery('#tf_logout').html('Wait while realoading...');
				jQuery('.result').html(response);
			},
			error:function(response){
			},
			complete:function(){
				
				jQuery('#tf_logout').html('LOGOUT FROM TRAFFICFEED');
				jQuery('#tf_logout').attr("disabled", false);
			}
		});
		return false; 
	});
	
	jQuery('.tf_reset').click(function(e) {
   		jQuery.ajax({
	   		url:tf_ajax.ajaxurl,
			data:'action=tf_reset',
			beforeSend:function(){
				jQuery('.tf_reset').attr("disabled", true);
				
				jQuery('.tf_reset').html('Processing...');
			},
			success: function(response){
				
				jQuery('.tf_reset').html('Wait while realoading...');
				jQuery('.result').html(response);
			},
			error:function(response){
			},
			complete:function(){
				
				jQuery('.tf_reset').html('RESET SETTINGS');
				jQuery('#tf_logout').attr("disabled", false);
			}
		});
		return false; 
	});
	
	jQuery('#tf_add_site').submit(function(e) {
	
   		jQuery.ajax({
	   		url:tf_ajax.ajaxurl,
			type:'POST',
			
			data:'action=tf_manage_domain&'+jQuery('#tf_add_site').serialize(),
			beforeSend:function(){
				jQuery('#tf_error').hide();
				jQuery('#tf_success').hide();
				jQuery('#btn_domain').attr("disabled", true);
				jQuery('#btn_domain').fadeTo('slow','0.4');
				jQuery('#btn_domain').attr('value','Wait...');
			},
			success: function(response){
				
				jQuery('.result').html(response);
			},
			error:function(response){
			},
			complete:function(){
				jQuery('#btn_domain').attr('value','ADD');
				jQuery('#btn_domain').fadeTo('slow','1');
				jQuery('#btn_domain').attr("disabled", false);
			}
		});
		return false;
	});
	
	jQuery('#frm_tf_login').submit(function(e) {
	
   		jQuery.ajax({
	   		url:tf_ajax.ajaxurl,
			type:'POST',
			
			data:'action=tf_login&'+jQuery('#frm_tf_login').serialize(),
			beforeSend:function(){
				jQuery('#tf_btn_login').attr("disabled", true);
				jQuery('#tf_btn_login').fadeTo('slow','0.4');
				jQuery('#tf_btn_login').attr('value','Wait...');
			},
			success: function(response){
				
				jQuery('.result').html(response);
			},
			error:function(response){
			},
			complete:function(){
				jQuery('#tf_btn_login').attr('value','Login');
				jQuery('#tf_btn_login').fadeTo('slow','1');
				jQuery('#tf_btn_login').attr("disabled", false);
			}
		});
		return false;
	});
	
	jQuery('#frm_tf_reg').submit(function(e) {
	
   		jQuery.ajax({
	   		url:tf_ajax.ajaxurl,
			type:'POST',
			data:'action=tf_register&'+jQuery('#frm_tf_reg').serialize(),
			beforeSend:function(){
				jQuery('#tf_btn_register').attr("disabled", true);
				jQuery('#tf_btn_register').fadeTo('slow','0.4');
				jQuery('#tf_btn_register').attr('value','Wait...');
			},
			success: function(response){
				
				jQuery('.result').html(response);
			},
			error:function(response){
			},
			complete:function(){
				jQuery('#tf_btn_register').attr('value','Sign Up');
				jQuery('#tf_btn_register').fadeTo('slow','1');
				jQuery('#tf_btn_register').attr("disabled", false);
			}
		});
		return false;
	});
	
	
	jQuery('.active_domain').click(function(e) {
		
   		jQuery.ajax({
	   		url:tf_ajax.ajaxurl,
			type:'POST',	
			data:'action=tf_domian_activate',
			beforeSend:function(){
				
				jQuery(this).attr("disabled", true);
				jQuery('#domain_act_response').html('Processing...');
			},
			success: function(response){
				
				jQuery('.result').html(response);
			},
			complete:function(){
				jQuery('.active_domain').attr("disabled", false);
			}
		});
		return false;
	});
});
// JavaScript Document