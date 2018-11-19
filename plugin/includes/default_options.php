<?php


$this->opt = array_replace_recursive(

	$this->opt,

	array(
	
			'template'=> 'default',
			'setup_done'=> false,
			'license'=> '',
			'dashboard'=> array(
			
				'custom_button'=> '',
			
			
			),
			
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
			),
			

			'social_networks'=>array(
			
				'facebook'=> array(
					'text'=> 'Share on Facebook', 
					'url'=> 'http://www.facebook.com/sharer.php?u={CONTENTURL}&amp;t={CONTENTTITLE}',
					'active'=> 1,
					'follow'=>'https://www.facebook.com/CodeBard',
					'sort'=>0,
				),
				'twitter'=> array(
					'text'=> 'Share on Twitter', 
					'url'=> 'http://twitter.com/share?text={CONTENTTITLE}&amp;url={CONTENTURL}&amp;via={FOLLOWACCOUNT}',
					'active'=> 1,
					'follow'=>'codebardcom',
					'sort'=>0,
				),
				'googleplus'=> array(
					'text'=> 'Share on Google+', 
					'url'=> 'http://plus.google.com/share?url={CONTENTURL}',
					'active'=> 1,
					'follow'=>'https://plus.google.com/b/104449064740473612803/104449064740473612803/',
					'sort'=>0,
				),
				'reddit'=> array(
					'text'=> 'Share on Reddit', 
					'url'=> 'http://reddit.com/submit?url={CONTENTURL}&title={CONTENTTITLE}',
					'active'=> 1,
					'follow'=>'',
					'sort'=>0,
				),
				'linkedin'=> array(
					'text'=> 'Share on LinkedIn', 
					'url'=> 'http://www.linkedin.com/shareArticle?mini=true&url={CONTENTTITLE}',
					'active'=> 1,
					'follow'=>'',
					'sort'=>0,
				),
				'digg'=> array(
					'text'=> 'Share on Digg', 
					'url'=> 'http://www.digg.com/submit?url={CONTENTURL}',
					'active'=> 0,
					'follow'=>'',
					'sort'=>0,
				),
				'pinterest'=> array(
					'text'=> 'Share on Pinterest', 
					'url'=> 'http://pinterest.com/pin/create/button/?url={CONTENTURL}&description={CONTENTTITLE}&media={CONTENTIMAGE}',
					'active'=> 0,
					'follow'=>'',
					'sort'=>0,
				),
				'tumblr'=> array(
					'text'=> 'Share on Tumblr', 
					'url'=> 'http://www.tumblr.com/share/link?url={CONTENTURL}&name={CONTENTTITLE}',
					'active'=> 1,
					'follow'=>'',
					'sort'=>0,
				),
				'delicious'=> array(
					'text'=> 'Share on Delicious', 
					'url'=> 'http://del.icio.us/save?v=5&noui&jump=close&url={CONTENTURL}&title={CONTENTTITLE}',
					'active'=> 0,
					'follow'=>'',
					'sort'=>0,
				),
				'email'=> array(
					'text'=> 'Share by Email', 
					'url'=> 'mailto:?Subject={CONTENTTITLE}&Body={CONTENTURL}',
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