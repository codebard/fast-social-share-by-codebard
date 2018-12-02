jQuery.noConflict(); // Reverts '$' variable back to other JS libraries

jQuery(document).ready(function($) {

	jQuery('body').on("click",'.cb_p2_admin_toggle_button',function(e) {
		target_div = document.getElementById(jQuery(this).attr( 'target' ));
		jQuery(target_div).fadeToggle(1800);
	});
	

	jQuery(".cb_p2_toggle").click(function (e) {
		e.preventDefault();
		var cb_p2_input_target = document.getElementById(jQuery(this).attr('target'));
		jQuery(cb_p2_input_target).toggle('slow');
		
	});
	jQuery(document).on( 'click', ".cb_p2_social_network_edit", function (e) {
		e.preventDefault();
		var cb_p2_input_target = document.getElementById(jQuery(this).attr('target'));
		var cb_p2_network = jQuery(this).attr('network');
		
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Processing...</div>');	

		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_social_network_edit',
				cb_p2_network: cb_p2_network,
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
			},
			error: function( response ) {
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
			},
			statusCode: {
				500: function(error) {
					jQuery(cb_p2_input_target).empty();
					jQuery(cb_p2_input_target).html(error);
				}
			}
		});
		
	});
	jQuery(document).on( 'click', "#cb_p2_customize_set_button", function (e) {
		e.preventDefault();
		var cb_p2_input_target = document.getElementById(jQuery(this).attr('target'));
		var cb_p2_selected_set = jQuery('#cb_p2_set_selector').val();
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Processing...</div>');	

		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_load_set_to_edit',
				cb_p2_selected_set: cb_p2_selected_set,
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
			},
			error: function( response ) {
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
			},
			statusCode: {
				500: function(error) {
					jQuery(cb_p2_input_target).empty();
					jQuery(cb_p2_input_target).html(error);
				}
			}
		});
		
	});
	jQuery(document).on( 'click', "#cb_p2_delete_network_button", function (e) {
		e.preventDefault();
		var cb_p2_input_target = document.getElementById(jQuery(this).attr('ajax_target_div'));
		var cb_p2_network = jQuery(this).attr('network');
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Processing...</div>');	

		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_delete_social_network',
				cb_p2_network: cb_p2_network,
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				
				cb_p2_refresh_social_network_div();
				
				jQuery(cb_p2_input_target).html(response);
			},
			error: function( response ) {
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
			},
			statusCode: {
				500: function(error) {
					jQuery(cb_p2_input_target).empty();
					jQuery(cb_p2_input_target).html(error);
				}
			}
		});
		
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
	

	jQuery(document).on( 'submit', '#cb_p2_social_network_edit_form', function(e) {
		
        e.preventDefault();
	
		var cb_p2_input_target = document.getElementById(jQuery(this).attr('ajax_target_div'));
		
		jQuery('#cb_p2_social_network_edit_form').remove();

		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Processing...</div>');	

		var cb_p2_general_error = '<div class="cb_p2_processing_message">Sorry - could not update the social network...</div>';		
		
		var data = jQuery(this).serialize();
		var social_network = jQuery(this).find('input[name^="cb_p2_existing_network_id"]').val();
		
		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_update_social_network',
				data: data,
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				if( response == '' ) {
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				
				cb_p2_refresh_social_network_div();
				
				jQuery(cb_p2_input_target).html(response);
			},
			error: function( response ) {
				if( response == '' ) {
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
	
	function cb_p2_refresh_social_network_div(){
		
		cb_p2_input_target = jQuery('#cb_p2_social_network_list_insert');
		
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Loading social networks...</div>');	

		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_make_social_network_list',
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).hide().html(response).fadeIn();
			},
			error: function( response ) {
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
			},
			statusCode: {
				500: function(error) {
					jQuery(cb_p2_input_target).empty();
					jQuery(cb_p2_input_target).html(error);
				}
			}
		});		
		
		
	}
	
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
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				jQuery(cb_p2_input_target).html(response);
			},
			error: function( response ) {
				if( response == '' ) {
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
	
    jQuery(".cb_p2_value_slider").slider({
		value: 1,
		min: 1,
		max: 1,
		step: 1,
		create: function( event, ui ) {
			
			// Get slider target input element
			cb_p2_slider_value_target = document.getElementById(jQuery(this).attr('slider_value_target'));
					
			// Set the values of the slider with the values determined in target input
			
			jQuery(this).slider( "option", "max", parseInt(jQuery(cb_p2_slider_value_target).attr('max')));
			jQuery(this).slider( "option", "min", parseInt(jQuery(cb_p2_slider_value_target).attr('min')));
			jQuery(this).slider( "option", "step", parseInt(jQuery(cb_p2_slider_value_target).attr('step')));
			jQuery(this).slider( "value", jQuery(cb_p2_slider_value_target).val());
			
			
		},
		slide: function(event, ui) {
			
			var cb_p2_slider_value_target = document.getElementById(jQuery(this).attr('slider_value_target'));
			jQuery(cb_p2_slider_value_target).val(ui.value);
			jQuery(jQuery(cb_p2_slider_value_target).attr('css_target_element')).css(jQuery(cb_p2_slider_value_target).attr('css_rule'),jQuery(cb_p2_slider_value_target).val()+jQuery(cb_p2_slider_value_target).attr('css_suffix'));
			
		}
    });
	
	
	jQuery(document).on('input', '.cb_p2_slider_input_value', function(e) {
		
		
		jQuery(jQuery(this).attr('css_target_element')).css(jQuery(this).attr('css_rule'),jQuery(this).val()+jQuery(this).attr('css_suffix'));
 
		jQuery(document.getElementById(jQuery(this).attr('parent_slider'))).slider( "value", jQuery(this).val());
	
		
	});
	
	jQuery(document).on('change', '.cb_p2_select_input', function(e) {
		console.log(jQuery(this).attr('css_target_element'));
		console.log(jQuery(this).attr('css_rule'));
		console.log(jQuery(this).val());
		jQuery(jQuery(this).attr('css_target_element')).css(jQuery(this).attr('css_rule'),jQuery(this).val()+jQuery(this).attr('css_suffix'));
	});
	

	jQuery('.cb_p2_color_picker').each(function(){
		jQuery(this).wpColorPicker({
			hide: true,
			change: function(event, ui){
				
				// Exception for hover color change
		
				if(jQuery(this).attr('id') == 'cb_p2_style_editor_button_hover_color') {

					jQuery('head').append('<style type="text/css">.cb_p2_social_share_link:hover, .cb_p2_social_share_link:hover > * {background-color:'+jQuery(this).val()+';} </style>');
					return;
				}
				if(jQuery(this).attr('id') == 'cb_p2_style_editor_button_link_hover_color') {
					jQuery('head').append('<style type="text/css">.cb_p2_social_share_link:hover, .cb_p2_social_share_link:hover > * {color:'+jQuery(this).val()+';}</style>');
					return;
				}
				
				
				jQuery(jQuery(this).attr('css_target_element')).css(jQuery(this).attr('css_rule'),jQuery(this).val()+jQuery(this).attr('css_suffix'));
				
			}
			
		});
	});

	jQuery(document).on('change', '#cb_p2_button_icon_size_selector', function(e) {
		
		var extra_info = JSON.parse(window.atob(jQuery(this).attr('extra_info')));
		var set = jQuery('#cb_p2_icon_set_selector').val();
		var button_size = jQuery('#cb_p2_button_icon_size_selector').val();
		console.log(set);
		console.log(button_size);
		for (var key in extra_info['social_networks']) {
			
			var button = jQuery(document.getElementById('cb_p2_icon_'+key));
			
			jQuery(button).attr('src',extra_info['plugin_url']+'plugin/images/'+set+'/'+key+'/'+button_size+'.png');
			
			jQuery(button).css('width',button_size);
			jQuery(button).css('height',button_size);
		
		}		
	
	});
	
	jQuery(document).on('change', '#cb_p2_icon_set_selector', function(e) {
		
		var extra_info = JSON.parse(window.atob(jQuery(this).attr('extra_info')));
		var set = jQuery(this).val();
		
		// cb_p2_social_share_button_
		
		for (var key in extra_info['social_networks']) {
			
			var button = jQuery(document.getElementById('cb_p2_icon_'+key));
			var button_size = jQuery(document.getElementById('cb_p2_button_icon_size_selector')).val();
			
			jQuery(button).attr('src',extra_info['plugin_url']+'plugin/images/'+set+'/'+key+'/'+button_size+'.png');
			
			
			jQuery(button).css('width',button_size);
			jQuery(button).css('height',button_size);
		
		}
		
	});

	
	
	jQuery(document).on('change', '#cb_p2_style_editor_button_hover_text_decoration', function(e) {
		
		jQuery('head').append('<style type="text/css">.cb_p2_social_share_link:hover > * {text-decoration:'+jQuery(this).val()+';}</style>');
		console.log('a');
		console.log(jQuery(this).val());
	
	});	
	
	
});


