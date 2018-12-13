<?php

$this->internal = array_replace_recursive(
	
	
	$this->internal,
	
	array(
		
		'id' => 'cb_p2',
		'prefix' => 'cb_p2_',
		'version' => '1.0.0',
		'plugin_name' => 'Fast Custom Social Share by CodeBard',
		
		'callable_from_request' => array(
			 
		),
			
		
		'calllimits' => array(
		
			'add_admin_menu'=>1,
		),		
		
		'tables'=> array(


		),	
		'data'=> array(


		),	
		

		'meta_tables'=> array(

						
		),	
		
		'post_metas'=> array(
		),

		'required_plugins'=> array(
						
		),
		

		'admin_tabs' => array(
		
			'dashboard'=>array(
				
			),
			'social_networks'=>array(
				
				
			),
			'customize_design'=>array(
				
				
			),
			'general'=>array(
				
				
			),
			'languages'=>array(
				
				
			),
			'extras'=>array(
				
			
				
			),
			'support'=>array(
				
				
			),
		
		
		
		),
				

		'after_update_notice' => '<img src="'.$this->internal['plugin_url'].'images/New-Feature-Notice.png" style="float:left;margin-right: 10px; margin-bottom: 10px;" /> <h3>Patron Pro now has VIP users and Custom $ level users feature!</h3><b>The new ‘VIP user’ feature allows you to mark a user as a VIP, which will grant that user access to all content. And with the Custom Patreon Levels feature you can set a $ value for a user, which will entitle them to content that is locked at or lower than that $ value.<br><br><a href="https://codebard.com/codebard-news-updates/patron-pro-1-2-6-is-out-with-vip-user-and-custom-level-user-feature" target="_blank">Read details here!</a></b>',
		
		
	
	)
	
);


?>