<?php


$this->opt = array_replace_recursive(

	$this->opt,

	array(
	
			'template'=> 'default',
			'setup_done'=> false,
			'license'=> '',
			
			#MARKER
			
			'style' => array(
				'button_background_color'=>'#f5f5f5',
				'button_link_color'=>'#444',
				'button_border_color'=>'',
				'button_border_color'=>'#ccc',
				'button_border_thickness'=>'1',
				'button_border_style'=>'solid',
				'button_font_family'=>'',
				'button_font_weight'=>'bold',
				'button_font_size'=>'0.80',
				'button_margin'=>'0.4',
				'button_text_decoration'=>'none',		
				'button_icon_size'=>'24',		
				'follow_button_icon_size'=>'32',
				'icon_set'=>'set_2',
				'button_container_width'=>'100%',
				'button_container_margin_top'=>'20px',
				'button_container_text_align'=>'center',
				'button_container_padding_left'=>'0px',
				'button_padding'=>'5em',
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
					'active'=> 1,
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
					'active'=> 1,
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
					'active'=> 1,
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
					'active'=> 1,
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
					'active'=> 1,
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
					'active'=> 0,
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
					'active'=> 1,
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