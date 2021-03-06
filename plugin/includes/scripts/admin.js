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
	
	
	jQuery(document).on('change', '.cb_p2_select_option', function(e) {
		
		var cb_p2_input_target = document.getElementById(jQuery(this).attr('id')+'_messages');
		var cb_p2_option = jQuery(this).attr('name');
		var cb_p2_option_value = jQuery(this).val();
		
		
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('Processing...');	
		
		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_change_option_from_ajax',
				cb_p2_option: cb_p2_option,
				cb_p2_option_value: cb_p2_option_value,
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
				setTimeout(function(){
					location.reload();
				},5000);
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
	
	jQuery(document).on('change', '#cb_p2_set_selector', function(e) {
		
		var cb_p2_input_target = jQuery('#cb_p2_selector_messages');
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Refreshing preview...</div>');	
		
		jQuery('#cb_p2_style_preview_form').submit();
	});
	
	
	jQuery(document).on( 'click', "#cb_p2_select_style_and_move_to_next_step_button", function (e) {
		
		e.preventDefault();
		var cb_p2_selected_style = jQuery('#cb_p2_set_selector').val();
		
		jQuery('#cb_p2_selected_style_at_setup').val(cb_p2_selected_style);
		
		jQuery('#cb_p2_move_to_setup_2_id').submit();
		
	});	
	
	jQuery(document).on( 'click', "#cb_p2_select_style_button", function (e) {
		
		e.preventDefault();
		var cb_p2_selected_style = jQuery('#cb_p2_set_selector').val();
		var cb_p2_input_target = document.getElementById(jQuery(this).attr('target'));
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Processing...</div>');	
		
		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_activate_style',
				cb_p2_selected_style: cb_p2_selected_style,
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
				setTimeout(function(){
					location.reload();
				},5000);
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
	jQuery(document).on( 'click', "#cb_p2_customize_style_button", function (e) {
		e.preventDefault();
		
        var target = document.getElementById('cb_p2_customize_style_info');
		var current_state = jQuery(target).css('display');
		
		jQuery('#cb_p2_customize_style_info').slideToggle('slow');
		jQuery('#cb_p2_style_editor_items').slideToggle('slow');

        if (target) {
			if ( current_state == 'block' ) {
				return;
			}
            jQuery('html, body').animate({
                scrollTop: (jQuery(target).offset().top - 50)
            }, 1000);
        }
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

	jQuery(document).on( 'submit', '#cb_p2_assign_style_to_post_type_form', function(e) {
		
		
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
				action: 'cb_p2_assign_style_to_post_type',
				data: data,
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				if( response == '' ) {
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				
				jQuery(cb_p2_input_target).html(response);
				cb_p2_refresh_post_to_style_assignments_div();
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
	
	function cb_p2_refresh_post_to_style_assignments_div(){
		
		cb_p2_input_target = jQuery('#cb_p2_style_assignment_div');
		
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Refreshing assignments...</div>');	

		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_refresh_post_to_style_assignments_div',
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

	 jQuery('#cb_p2_new_style_dialog').dialog({
           autoOpen: false, //FALSE if you open the dialog with, for example, a button click
           title: 'Saving as new style',
           modal: true
		});

	jQuery(document).on( 'click', '#cb_p2_customize_style_save_button2', function(e) {
		
        e.preventDefault();
		
		jQuery('#cb_p2_new_style_dialog').dialog('open');
        return false;
		
	});
	
	jQuery(document).on( 'click', '#cb_p2_new_style_dialog_form_submit', function(e) {
	
	
        e.preventDefault();
		
		jQuery('#cb_p2_new_style_dialog').dialog('close');
		
		var style_name = jQuery('#cb_p2_new_style_name').val();
		
		var cb_p2_input_target = jQuery('#cb_p2_style_editor_messages');
		
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Processing...</div>');	

		var cb_p2_general_error = '<div class="cb_p2_processing_message">Sorry - could not update the social network...</div>';

		var data = jQuery('#cb_p2_style_editor_form').serialize();
		jQuery('#cb_p2_style_editor_items').toggle();
		
		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_save_style',
				cb_p2_save_type: 'new_style',
				cb_p2_style_name: style_name,
				data: data,
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				if( response == '' ) {
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				
				jQuery(cb_p2_input_target).html(response);
				jQuery('#cb_p2_style_editor_items').toggle();
			},
			error: function( response ) {
				if( response == '' ) {
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
				jQuery('#cb_p2_style_editor_items').toggle();
			},
			statusCode: {
				500: function(error) {
					response = cb_p2_general_error;
					jQuery(cb_p2_input_target).empty();
					jQuery(cb_p2_input_target).html(response);
					jQuery('#cb_p2_style_editor_items').toggle();
				}
			}
		});
		
	});
	
	
	jQuery(document).on( 'click', '#cb_p2_customize_style_save_button3', function(e) {
		
        e.preventDefault();
	
		var cb_p2_input_target = jQuery('#cb_p2_style_editor_messages');
		
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Processing...</div>');	

		var cb_p2_general_error = '<div class="cb_p2_processing_message">Sorry - could not update the social network...</div>';
		
		var data = jQuery('#cb_p2_style_editor_form').serialize();
		jQuery('#cb_p2_style_editor_items').toggle();
		
		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_save_style',
				cb_p2_save_type: 'delete_style',
				data: data,
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				if( response == '' ) {
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				
				jQuery(cb_p2_input_target).html(response);
				jQuery('#cb_p2_style_editor_items').toggle();
			},
			error: function( response ) {
				if( response == '' ) {
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
				jQuery('#cb_p2_style_editor_items').toggle();
			},
			statusCode: {
				500: function(error) {
					response = cb_p2_general_error;
					jQuery(cb_p2_input_target).empty();
					jQuery(cb_p2_input_target).html(response);
					jQuery('#cb_p2_style_editor_items').toggle();
				}
			}
		});
		
	});
	
	jQuery(document).on( 'click', '#cb_p2_customize_style_save_button1', function(e) {
		
        e.preventDefault();
	
		var cb_p2_input_target = jQuery('#cb_p2_style_editor_messages');
		
		jQuery(cb_p2_input_target).empty();
		jQuery(cb_p2_input_target).html('<div class="cb_p2_processing_message">Processing...</div>');	

		var cb_p2_general_error = '<div class="cb_p2_processing_message">Sorry - could not update the social network...</div>';
		
		var data = jQuery('#cb_p2_style_editor_form').serialize();
		jQuery('#cb_p2_style_editor_items').toggle();
		
		jQuery.ajax({
			url: ajaxurl,
			type:"POST",
			dataType : 'html',
			data: {
				action: 'cb_p2_save_style',
				cb_p2_save_type: 'same_style',
				data: data,
			},
			success: function( response ) {
				jQuery(cb_p2_input_target).empty();
				if( response == '' ) {
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				
				jQuery(cb_p2_input_target).html(response);
				jQuery('#cb_p2_style_editor_items').toggle();
			},
			error: function( response ) {
				if( response == '' ) {
					//White page - possibly an issue with the server/site caused an error during updates
					response = cb_p2_general_error;
				}
				jQuery(cb_p2_input_target).empty();
				jQuery(cb_p2_input_target).html(response);
				jQuery('#cb_p2_style_editor_items').toggle();
			},
			statusCode: {
				500: function(error) {
					response = cb_p2_general_error;
					jQuery(cb_p2_input_target).empty();
					jQuery(cb_p2_input_target).html(response);
					jQuery('#cb_p2_style_editor_items').toggle();
				}
			}
		});
		
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
			

			// Exception for button width via padding left and right
			
			if(jQuery(cb_p2_slider_value_target).attr('id') == 'cb_p2_style_editor_button_extra_padding') {
			
				jQuery(jQuery(cb_p2_slider_value_target).attr('css_target_element')).css('padding-right',jQuery(cb_p2_slider_value_target).val()+jQuery(cb_p2_slider_value_target).attr('css_suffix'));
				jQuery(jQuery(cb_p2_slider_value_target).attr('css_target_element')).css('padding-left',jQuery(cb_p2_slider_value_target).val()+jQuery(cb_p2_slider_value_target).attr('css_suffix'));
				
				return;
			}			
				
			jQuery(jQuery(cb_p2_slider_value_target).attr('css_target_element')).css(jQuery(cb_p2_slider_value_target).attr('css_rule'),jQuery(cb_p2_slider_value_target).val()+jQuery(cb_p2_slider_value_target).attr('css_suffix'));
			
		}
    });
	
	
	jQuery(document).on('input', '.cb_p2_slider_input_value', function(e) {
		
		jQuery(document.getElementById(jQuery(this).attr('parent_slider'))).slider( "value", jQuery(this).val());
		
		// Exception for button width via padding left and right
		
		if(jQuery(this).attr('id') == 'cb_p2_style_editor_button_extra_padding') {
		
			jQuery(jQuery(this).attr('css_target_element')).css('padding-right',jQuery(this).val()+jQuery(this).attr('css_suffix'));
			jQuery(jQuery(this).attr('css_target_element')).css('padding-left',jQuery(this).val()+jQuery(this).attr('css_suffix'));
			
			return;
		}
		
		jQuery(jQuery(this).attr('css_target_element')).css(jQuery(this).attr('css_rule'),jQuery(this).val()+jQuery(this).attr('css_suffix'));
 
		
	
		
	});
	
	jQuery(document).on('change', '.cb_p2_select_input', function(e) {
		jQuery(jQuery(this).attr('css_target_element')).css(jQuery(this).attr('css_rule'),jQuery(this).val()+jQuery(this).attr('css_suffix'));
	});

	jQuery('.cb_p2_color_picker').each(function(){
		
		var current_element = jQuery(this);
		
		jQuery(this).wpColorPicker({
			hide: true,
			clear: function(event, ui) {
				
				// Set value to transparent if it was erased:
				
				var color_picker_element = jQuery(this).parent().find( ".cb_p2_color_picker" )
				var set_value = 'transparent';
		
				
				if(color_picker_element.attr('id') == 'cb_p2_style_editor_button_hover_color') {
					// If we dont 'important' these rules, they get overridden if the non-hover rules are changed in style editor
					jQuery('head').append('<style type="text/css">.cb_p2_social_share_link:hover {background-color:'+set_value+' !important;} </style>');
					return;
				}
				if(color_picker_element.attr('id') == 'cb_p2_style_editor_button_link_hover_color') {
					jQuery('head').append('<style type="text/css">.cb_p2_social_share_link:hover, .cb_p2_social_share_link:hover .cb_p2_social_share_link_text {color:'+set_value+' !important;}</style>');
					return;
				}
				
				color_picker_element.val('transparent');
				
				jQuery(color_picker_element.attr('css_target_element')).css(color_picker_element.attr('css_rule'),set_value+color_picker_element.attr('css_suffix'));
				
				
			},
			change: function(event, ui){
				
				
				// Set value to transparent if it was erased:
				
				var set_value = jQuery(this).val();
				
				if ( set_value == '' ) {
					set_value = 'transparent';
				}
				
				
				// Exception for hover color change
		
				if(jQuery(this).attr('id') == 'cb_p2_style_editor_button_hover_color') {
					// If we dont 'important' these rules, they get overridden if the non-hover rules are changed in style editor
					jQuery('head').append('<style type="text/css">.cb_p2_social_share_link:hover {background-color:'+set_value+' !important;} </style>');
					return;
				}
				if(jQuery(this).attr('id') == 'cb_p2_style_editor_button_link_hover_color') {
					jQuery('head').append('<style type="text/css">.cb_p2_social_share_link:hover, .cb_p2_social_share_link:hover .cb_p2_social_share_link_text {color:'+set_value+' !important;}</style>');
					return;
				}
				
				
				jQuery(jQuery(this).attr('css_target_element')).css(jQuery(this).attr('css_rule'),set_value+jQuery(this).attr('css_suffix'));
				
			}
			
		});
	});

	jQuery(document).on('change', '#cb_p2_button_icon_size_selector', function(e) {
		
		var extra_info = JSON.parse(window.atob(jQuery(this).attr('extra_info')));
		var set = jQuery('#cb_p2_icon_set_selector').val();
		var button_size = jQuery('#cb_p2_button_icon_size_selector').val();
		
		
		for (var key in extra_info['social_networks']) {
			
			jQuery('.cb_p2_icon_'+key).each(function() {
				
				jQuery(this).attr('src', extra_info['plugin_url']+'plugin/images/'+set+'/'+key+'/'+button_size+'.png');
				jQuery(this).css('width',button_size);
				jQuery(this).css('height',button_size);
			});			
		
		}		
	
	});
	
	jQuery(document).on('change', '#cb_p2_icon_set_selector', function(e) {
		
		var extra_info = JSON.parse(window.atob(jQuery(this).attr('extra_info')));
		var set = jQuery(this).val();
		var button_size = jQuery(document.getElementById('cb_p2_button_icon_size_selector')).val();
			
		for (var key in extra_info['social_networks']) {
	
			jQuery('.cb_p2_icon_'+key).each(function() {
				
				jQuery(this).attr('src', extra_info['plugin_url']+'plugin/images/'+set+'/'+key+'/'+button_size+'.png');
				jQuery(this).css('width',button_size);
				jQuery(this).css('height',button_size);
			});
		
		}
		
	});

	
	
	jQuery(document).on('change', '#cb_p2_style_editor_button_hover_text_decoration', function(e) {
		
		jQuery('head').append('<style type="text/css">.cb_p2_social_share_link:hover, .cb_p2_social_share_link:hover .cb_p2_social_share_link_text  {text-decoration:'+jQuery(this).val()+'; !important}</style>');
	
	});	
	
	
});


