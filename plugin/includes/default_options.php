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
				'post' => 'default',
				'page' => 'none',
			),
			
			'content_buttons_placement' => 'bottom',
			
			'styles' => array(
				'set_1' => array(
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
					'follow'=>'https://www.facebook.com/CodeBard',
					'sort'=>0,
				),
				'twitter'=> array(
					'name'=> 'Twitter',
					'id'=> 'Twitter', 
					'text_before'=> '',
					'text_after'=> 'Share on Twitter', 
					'icon'=> 'default', 
					'url'=> 'http://twitter.com/share?text={CONTENTTITLE}&amp;url={CONTENTURL}&amp;via={FOLLOWACCOUNT}',
					'active'=> 'yes',
					'follow'=>'codebardcom',
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
					'follow'=>'https://plus.google.com/b/104449064740473612803/104449064740473612803/',
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