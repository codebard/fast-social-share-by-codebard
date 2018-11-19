jQuery.noConflict(); // Reverts '$' variable back to other JS libraries

jQuery(document).ready(function($) {

	jQuery('body').on("click",'.cb_p2_admin_toggle_button',function(e) {
		target_div = document.getElementById($(this).attr( 'target' ));
		jQuery(target_div).fadeToggle(1800);
	});
	

	jQuery(".cb_p2_toggle").click(function (e) {
		var cb_p2_input_target = document.getElementById(jQuery(this).attr('target'));
        e.preventDefault();
		jQuery(cb_p2_input_target).toggle('slow');
		
	});
	
	jQuery("#cb_p2_post_locking_format_toggle").change(function (e) {
		var cb_p2_locking_format = jQuery(this).val();
        e.preventDefault();
		jQuery('.cb_p2_locking_format_selector').hide();
		jQuery('#cb_p2_post_locking_value').hide();
		if(cb_p2_locking_format!='none') {
			jQuery("#cb_p2_post_locking_format_" + cb_p2_locking_format).toggle('slow');
			jQuery('#cb_p2_post_locking_value').toggle('slow');
				
		}
	});
	
	jQuery(document).on( 'click', '.cb_p2_notice .notice-dismiss', function(e) {

	
		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_dismiss_admin_notice',
				notice_id: jQuery(this).parent().attr("id"),
				notice_type: jQuery(this).parent().attr("notice_type"),
			}
		});

	});
	
	jQuery(document).on('click', '.cb_p2_file_upload', function(e) {

		var cb_p2_input_target = jQuery(this);
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
             cb_p2_input_target.val(image_url);
			 
        });
    });
	
	jQuery(document).on('click', '.cb_p2_clear_prevfield', function(e) {
		e.preventDefault();
		
		jQuery(this).prev().val('');
	
	});

	jQuery(document).on( 'submit', '#cb_p2_ajax_plugin_install_form', function(e) {
		
        e.preventDefault();
		
		var cb_p2_input_target = document.getElementById(jQuery(this).attr('ajax_target_div'));
		
		jQuery('#cb_p2_ajax_plugin_install_form').remove();

		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('Processing...');	

		var cb_p2_general_error = '<h4>Sorry - something on your site or server is preventing automatic installation/update of the plugins. You may have to delete existing ones (if you have already installed them before), and upload/activate new ones from your <a href="https://codebard.com/your-codebard-account" target="_blank">CodeBard account</a>. You will not need to reconfigure your plugins and you will not lose your settings if you choose to do that..</h4>';		
		
		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_install_update_plugins',
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				if( response == '' ) {
					console.log('caught return');
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				jQuery(cb_p2_input_target).html(response);
			},
			error: function( response ) {
				if( response == '' ) {
					console.log('caught error');
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
			},
			statusCode: {
				500: function(error) {
					response = cb_p2_general_error;
					jQuery(cb_p2_input_target).empty();
					jQuery(cb_p2_input_target).html(response);
				}
			}
		});
		
	});
	
	
});