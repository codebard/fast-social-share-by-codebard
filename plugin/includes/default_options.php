<?php


$this->opt = array_replace_recursive(

	$this->opt,

	array(
	
			'template'=> 'default',
			'setup_done'=> false,
			'license'=> '',
			'lang' => 'en-US',
			
			#MARKER
			
			'style_set' => 'set_1',
	
			'icon_sets' => array(
				'set_1',
				'set_2',
				'set_3',
				'set_4',
				'set_5',
				'set_6',
			),
			
			'post_types' => array(
				'post' => 'set_1',
				'page' => 'none',
			),
			
			'content_buttons_placement' => 'bottom',
			
			'styles' => array(
				'set_1' => array(
					'icon_set' => 'set_1',
					'button_text_display' => 'none',
					'button_background_color' => 'transparent',
					'button_hover_color' => 'transparent',
					'button_margin' => '5',
					'button_icon_size' => '36',
					'button_icon_margin' => '0',
					'button_padding' => '0',
					'button_extra_padding' => '0',
					'button_border_color' => '#c0c0c0',
					'button_border_thickness' => '0',
					'button_border_style' => 'solid',
					'button_border_radius' => '0',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_family' => '',
					'button_font_weight' => '700',
					'button_font_size' => '1',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'follow_button_icon_size' => '32',
					'container_wrapper_width' => '100%',
					'button_container_margin_top' => '20px',
					'button_container_text_align' => 'center',
					'button_text_align' => 'center',
					'button_container_padding_left' => '0px',
					'container_background_color' => 'transparent',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_color' => '#c0c0c0',
					'container_border_thickness' => '0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',
					'container_max_width' => '2000',
					
				),
				'set_2' => array(
					'icon_set' => 'set_2',
					'button_icon_size' => '36',
					'button_icon_margin' => '0',
					'button_text_display' => 'none',
					'button_font_size' => '1',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '0',
					'button_border_color' => '#c0c0c0',
					'button_border_style' => 'solid',
					'button_border_radius' => '0',
					'button_background_color' => 'transparent',
					'button_hover_color' => 'transparent',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',
					
				),
				'set_3' => array(
					'icon_set' => 'set_3',
					'button_icon_size' => '36',
					'button_icon_margin' => '2',
					'button_text_display' => 'none',
					'button_font_size' => '1',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '1',
					'button_border_color' => '#c0c0c0',
					'button_border_style' => 'solid',
					'button_border_radius' => '0',
					'button_background_color' => '#ffffff',
					'button_hover_color' => '#ededed',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',
					
				),
				'set_4' => array(
					'icon_set' => 'set_4',
					'button_icon_size' => '36',
					'button_icon_margin' => '0',
					'button_text_display' => 'none',
					'button_font_size' => '1',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '0',
					'button_border_color' => '#c0c0c0',
					'button_border_style' => 'solid',
					'button_border_radius' => '0',
					'button_background_color' => 'transparent',
					'button_hover_color' => 'transparent',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',
				),
				'set_5' => array(
					'icon_set' => 'set_5',
					'button_icon_size' => '42',
					'button_icon_margin' => '0',
					'button_text_display' => 'none',
					'button_font_size' => '1',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '0',
					'button_border_color' => '#c0c0c0',
					'button_border_style' => 'solid',
					'button_border_radius' => '0',
					'button_background_color' => 'transparent',
					'button_hover_color' => 'transparent',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',
				),
				'set_6' => array(
					'icon_set' => 'set_6',
					'button_icon_size' => '48',
					'button_icon_margin' => '0',
					'button_text_display' => 'none',
					'button_font_size' => '1',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '0',
					'button_border_color' => '#c0c0c0',
					'button_border_style' => 'solid',
					'button_border_radius' => '0',
					'button_background_color' => 'transparent',
					'button_hover_color' => '',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',
				),
				'set_7' => array(
					'icon_set' => 'set_6',
					'button_icon_size' => '48',
					'button_icon_margin' => '5',
					'button_text_display' => 'none',
					'button_font_size' => '1',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '1',
					'button_border_color' => '#c0c0c0',
					'button_border_style' => 'solid',
					'button_border_radius' => '0',
					'button_background_color' => '#ffffff',
					'button_hover_color' => '#eaeaea',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',
				),
				'set_8' => array(
					'icon_set' => 'set_1',
					'button_icon_size' => '36',
					'button_icon_margin' => '0',
					'button_text_display' => 'none',
					'button_font_size' => '1',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '0',
					'button_border_color' => '#c0c0c0',
					'button_border_style' => 'solid',
					'button_border_radius' => '0',
					'button_background_color' => 'transparent',
					'button_hover_color' => 'transparent',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => '#ffffff',
					'container_max_width' => '373',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '1',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',				
				),
				'set_9' => array(
					'icon_set' => 'set_1',
					'button_icon_size' => '24',
					'button_icon_margin' => '5',
					'button_text_display' => 'inline',
					'button_font_size' => '14',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '600',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '1',
					'button_border_color' => '#686868',
					'button_border_style' => 'dotted',
					'button_border_radius' => '12',
					'button_background_color' => '#f9f9f9',
					'button_hover_color' => '#efefef',
					'button_margin' => '5',
					'button_extra_padding' => '12',
					'button_padding' => '4',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',					
				),
				'set_10' => array(
					'icon_set' => 'set_2',
					'button_icon_size' => '28',
					'button_icon_margin' => '5',
					'button_text_display' => 'inline',
					'button_font_size' => '14',
					'button_link_color' => '#ffffff',
					'button_link_hover_color' => '#ffffff',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '1',
					'button_border_color' => '#ffffff',
					'button_border_style' => 'solid',
					'button_border_radius' => '4',
					'button_background_color' => '#e23434',
					'button_hover_color' => '#f23232',
					'button_margin' => '5',
					'button_extra_padding' => '7',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',
				),
				'set_11' => array(
					'icon_set' => 'set_4',
					'button_icon_size' => '28',
					'button_icon_margin' => '5',
					'button_text_display' => 'inline',
					'button_font_size' => '16',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#2f8cce',
					'button_font_weight' => '600',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '0',
					'button_border_color' => '#c0c0c0',
					'button_border_style' => 'solid',
					'button_border_radius' => '0',
					'button_background_color' => 'transparent',
					'button_hover_color' => 'transparent',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',					
				),
				'set_12' => array(
					'icon_set' => 'set_4',
					'button_icon_size' => '42',
					'button_icon_margin' => '6',
					'button_text_display' => 'none',
					'button_font_size' => '1',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '1',
					'button_border_color' => '#c0c0c0',
					'button_border_style' => 'solid',
					'button_border_radius' => '4',
					'button_background_color' => '#ffffff',
					'button_hover_color' => '#f4f4f4',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',
				),
				'set_13' => array(
					'icon_set' => 'set_3',
					'button_icon_size' => '42',
					'button_icon_margin' => '0',
					'button_text_display' => 'none',
					'button_font_size' => '1',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '1',
					'button_border_color' => '#0c0c0c',
					'button_border_style' => 'solid',
					'button_border_radius' => '50',
					'button_background_color' => '#ffffff',
					'button_hover_color' => '#eaeaea',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',
					
				),
				'set_14' => array(
					'icon_set' => 'set_4',
					'button_icon_size' => '36',
					'button_icon_margin' => '5',
					'button_text_display' => 'none',
					'button_font_size' => '1',
					'button_link_color' => '#444',
					'button_link_hover_color' => '#444',
					'button_font_weight' => '700',
					'button_text_decoration' => 'none',
					'button_hover_text_decoration' => 'none',
					'button_border_thickness' => '2',
					'button_border_color' => '#212121',
					'button_border_style' => 'dotted',
					'button_border_radius' => '50',
					'button_background_color' => '#ffffff',
					'button_hover_color' => '#cce7ff',
					'button_margin' => '5',
					'button_extra_padding' => '0',
					'button_padding' => '0',
					'container_background_color' => 'transparent',
					'container_max_width' => '2000',
					'container_margin' => '0',
					'container_padding' => '10',
					'container_border_thickness' => '0',
					'container_border_color' => '#c0c0c0',
					'container_border_style' => 'solid',
					'container_border_radius' => '0',

				),
			
			),
		

			'style_defaults' => array(
				'icon_set' => 'set_1',
				'button_text_display' => 'inline',
				'button_background_color'=>'#f5f5f5',
				'button_hover_color'=>'transparent',
				'button_margin'=>'15',		
				'button_icon_size'=>'24',
				'button_icon_margin'=>'5',
				'button_padding'=>'15',
				'button_extra_padding'=>'15',
				'button_border_color'=>'#c0c0c0',
				'button_border_thickness'=>'1',
				'button_border_style'=>'solid',
				'button_border_radius'=>'0',
				'button_link_color'=>'#444',
				'button_link_hover_color'=>'#444',
				'button_font_family'=>'',
				'button_font_weight'=>'700',
				'button_font_size'=>'16',
				'button_text_decoration'=>'none',
				'button_hover_text_decoration'=>'none',		 
				'follow_button_icon_size'=>'32',
				'container_wrapper_width'=>'100%',
				'button_container_margin_top'=>'20px',
				'button_container_text_align'=>'center',
				'button_text_align'=>'center',
				'button_container_padding_left'=>'0px',
				'container_background_color'=>'transparent',
				'container_margin'=>'20',
				'container_padding'=>'20',
				'container_border_color'=>'#c0c0c0',
				'container_border_thickness'=>'1',
				'container_border_style'=>'solid',
				'container_border_radius'=>'0',
				'container_max_width' => '2000',
				
			),			
			
			'functionality' => array(
				'share_link_target'=>'_blank',
				'follow_link_target'=>'_blank',
			),
		
			'social_networks'=>array(
			
				'facebook'=> array(
					'name'=> 'Facebook',
					'id'=> 'facebook',
					'text_before'=> '', 
					'text_after'=> 'Share on Facebook',
					'icon'=> 'default', 
					'url'=> 'http://www.facebook.com/sharer.php?u={CONTENTURL}&amp;t={CONTENTTITLE}',
					'active'=> 'yes',
					'follow'=>'',
					'sort'=>0,
				),
				'twitter'=> array(
					'name'=> 'Twitter',
					'id'=> 'twitter', 
					'text_before'=> '',
					'text_after'=> 'Share on Twitter', 
					'icon'=> 'default', 
					'url'=> 'http://twitter.com/share?text={CONTENTTITLE}&amp;url={CONTENTURL}&amp;via={FOLLOWACCOUNT}',
					'active'=> 'yes',
					'follow'=>'',
					'sort'=>0,
				),
				'googleplus'=> array(
					'name'=> 'Google+',
					'id'=> 'googleplus', 
					'text_before'=> '', 
					'text_after'=> 'Share on Google+',
					'icon'=> 'default',  
					'url'=> 'http://plus.google.com/share?url={CONTENTURL}',
					'active'=> 'yes',
					'follow'=>'',
					'sort'=>0,
				),
				'reddit'=> array(
					'name'=> 'Reddit',
					'id'=> 'reddit', 
					'text_before'=> '', 
					'text_after'=> 'Share on Reddit',
					'icon'=> 'default',  
					'url'=> 'http://reddit.com/submit?url={CONTENTURL}&title={CONTENTTITLE}',
					'active'=> 'yes',
					'follow'=>'',
					'sort'=>0,
				),
				'linkedin'=> array(
					'name'=> 'LinkedIn',
					'id'=> 'linkedin', 
					'text_before'=> '', 
					'text_after'=> 'Share on LinkedIn',
					'icon'=> 'default',  
					'url'=> 'http://www.linkedin.com/shareArticle?mini=true&url={CONTENTURL}',
					'active'=> 'yes',
					'follow'=>'',
					'sort'=>0,
				),
				'pinterest'=> array(
					'name'=> 'Pinterest',
					'id'=> 'pinterest', 
					'text_before'=> '', 
					'text_after'=> 'Share on Pinterest',
					'icon'=> 'default',  
					'url'=> 'http://pinterest.com/pin/create/button/?url={CONTENTURL}&description={CONTENTTITLE}&media={CONTENTIMAGE}',
					'active'=> 'yes',
					'follow'=>'',
					'sort'=>0,
				),
				'tumblr'=> array(
					'name'=> 'Tumblr',
					'id'=> 'tumblr', 
					'text_before'=> '', 
					'text_after'=> 'Share on Tumblr', 
					'icon'=> 'default', 
					'url'=> 'http://www.tumblr.com/share/link?url={CONTENTURL}&name={CONTENTTITLE}',
					'active'=> 'yes',
					'follow'=>'',
					'sort'=>0,
				),

			
			),
			
			'accepted_post_types' => array(
				'post',
			),			
			
		)
	
);


?>