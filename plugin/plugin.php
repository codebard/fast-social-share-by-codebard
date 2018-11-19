<?php


class cb_p2_plugin extends cb_p2_core
{
	public function plugin_construct()
	{
		
		// If Patreon_WordPress class is not found, drop a notice and exit.

		add_action( 'plugins_loaded', array(&$this, 'init'),60);
		add_action('admin_init', array(&$this, 'admin_init'));
		// Below admin_menu hook can be removed when relevant issue in plugin engine is fixed: 
		/*
		[admin_init] mustn't be placed in an admin_init action function, because the admin_init action is called after admin_menu - plugins have admin_menu in admin_init, hence its not firing
		*/
		add_action('admin_menu', array(&$this,'add_admin_menus'));
		
		if( $this->required_plugins() AND ( !isset( $this->internal['setup_is_being_done'] ) OR !$this->internal['setup_is_being_done'] ) ) {
			return;
		}
		
		add_action( 'upgrader_process_complete', array(&$this, 'upgrade'),10,2);
		
		register_activation_hook( __FILE__, array(&$this,'activate' ));
		
		register_deactivation_hook(__FILE__, array(&$this,'deactivate'));
		
		if(is_admin()) {
		
			
		}
		else {
			add_action('init', array(&$this, 'frontend_init'),99);
		}
		
	}
	
	public function add_admin_menus_p() {
	
		add_menu_page( $this->lang['admin_menu_label'], $this->lang['admin_menu_label'], 'administrator', 'settings_'.$this->internal['id'], array(&$this,'do_settings_pages'), $this->internal['plugin_url'].'images/admin_menu_icon.png', 86 );

		add_submenu_page ( '', $this->lang['admin_menu_label'], $this->lang['admin_menu_label'], 'administrator', 'setup_wizard_'.$this->internal['id'], array(&$this,'do_setup_wizard'), $this->internal['plugin_url'].'images/admin_menu_icon.png', 86 );		
		
	}
	
	public function admin_init_p() {

		$this->check_redirect_to_setup_wizard();
		
		add_filter( 'pre_set_site_transient_update_plugins', array(&$this, 'check_for_update' ) );
		
		$this->internal['plugin_update_url'] =  wp_nonce_url(get_admin_url().'update.php?action=upgrade-plugin&plugin='.$this->internal['plugin_slug'],'upgrade-plugin_'.$this->internal['plugin_slug']);
		
		add_action( 'wp_ajax_'.$this->internal['prefix'].'install_update_plugins', array( &$this, 'install_update_plugins' ),10,1 );
				
	}
	public function init_p()
	{
		
		if( $this->required_plugins() OR !$this->opt['setup_done'] ) {
			return;
		}
		
		
	}
	public function load_options_p()
	{
		// Initialize and modify plugin related variables
		
		return $this->internal['core_return'];
		
	}
	
	// Plugin specific functions start

	public function setup_languages_p()
	{
		// Here we do plugin specific language procedures. 
		
		// Set up the custom post type and its taxonomy slug into options:
		
		$current_lang=get_option($this->internal['prefix'].'lang_'.$this->opt['lang']);
		
		// Get current options
		
		$current_options=get_option($this->internal['prefix'].'options');
		
		// Update options :
		
		update_option($this->internal['prefix'].'options',$current_options);
		
		// Set current options the same as well :
		
		$this->opt=$current_options;
		
	}
	public function activate_p() {
	
		if( ( !isset( $this->opt['setup_done']) OR !$this->opt['setup_done'] ) AND !$this->opt['setup_is_being_done'] ) {
			$this->opt['redirect_to_setup_wizard'] = true;
			$this->update_opt();
		}
	}
	public function check_redirect_to_setup_wizard_p()
	{
	
		if(is_admin() AND current_user_can('manage_options')) {
		
			// If setup was not done, redirect to wizard

			if( isset( $this->opt['redirect_to_setup_wizard'] ) AND $this->opt['redirect_to_setup_wizard'] ) {

				$this->opt['setup_is_being_done']=true;
				$this->opt['redirect_to_setup_wizard'] = false;
				$this->update_opt();
				// wp_redirect($this->internal['admin_url'].'admin.php?page=settings_cb_p6&cb_p6_tab=content_locking');
				wp_redirect($this->internal['admin_url'].'admin.php?page=setup_wizard_'.$this->internal['id'].'&setup_stage=0');
				exit;	
			}
		}
		
	}	
	public function enqueue_frontend_styles_p()
	{
		wp_enqueue_style( $this->internal['id'].'-css-main', $this->internal['template_url'].'/'.$this->opt['template'].'/style.css' );
	}
	public function enqueue_admin_styles_p()
	{
		$current_screen=get_current_screen();

		if(is_admin())
		{
			wp_enqueue_style( $this->internal['id'].'-css-admin', $this->internal['plugin_url'].'plugin/includes/css/admin.css' );
			
			
		}		
	}
	public function enqueue_frontend_scripts_p()
	{
	
	}	
	public function enqueue_admin_scripts_p()
	{
		// This will enqueue the Media Uploader script
		wp_enqueue_media();	
		wp_enqueue_script( $this->internal['id'].'-js-admin', $this->internal['plugin_url'].'plugin/includes/scripts/admin.js' );	
			
	}
	public function upgrade_p($v1,$v2=false)
	{
		$upgrader_object = $v1;
		$options = $v2;

		if(!$options OR !is_array($options)) {
			// Not an update.
			return;
		}
	
		if( $options['action'] == 'update' && $options['type'] == 'plugin') {
			
			if(isset( $options['plugins'] )) {
				// Multi plugin update. Iterate:
				// Iterate through the plugins being updated and check if ours is there
				foreach( $options['plugins'] as $plugin ) {
					
					if( $plugin == $this->internal['plugin_slug'] ) {
						$got_updated = true;
					}
				}	
			}
			if(isset( $options['plugin'] )) {
				// Single plugin update

				if( $options['plugin'] == $this->internal['plugin_slug'] ) {
					$got_updated = true;
				}
			
			}
			
			if($got_updated) {
				
				// Yep, this plugin was updated. Do whatever necessary post-update action:
						
				$this->dismiss_admin_notice(array('notice_id'=>'update_available','notice_type'=>'info'));
				
				$this->queue_notice( $this->internal['after_update_notice'],'info','after_update_notice','perma',true);		
			}
		}
	}
	public function do_setup_wizard_p()
	{
		// Here we do and process setup wizard if it is not done:
		
		
		// Set the setup stage if setup is not done, setup is reset or stage 0 is requested
		if(!isset($_REQUEST[$this->internal['prefix'].'setup_stage']) OR $_REQUEST[$this->internal['prefix'].'setup_stage'] == '0' OR isset( $_REQUEST[$this->internal['prefix'].'reset_setup_wizard'] ) ) {
			$_REQUEST[$this->internal['prefix'].'setup_stage'] = 0;
			$this->opt['setup_wizard_stage'] = 0;

		}
				
		if ( !$this->opt['setup_done'] ) {
			
			$this->internal['setup_is_being_done'] = true;
			$this->opt['setup_is_being_done']=true;
		}
		
		$this->opt['setup_wizard_stage'] = (int) $_REQUEST[$this->internal['prefix'].'setup_stage'];
		$this->update_opt();
		
		require($this->internal['plugin_path'].'plugin/includes/setup_'.$this->opt['setup_wizard_stage'].'.php');
		
		if( $this->opt['setup_wizard_stage'] == '2' ) {
			
			// Final setup stage - remove setup related options

			$this->internal['setup_is_being_done'] = false;
			$this->opt['setup_is_being_done'] = false;
			$this->opt['setup_done'] = true;
			$this->update_opt();
			
		}

	}
	public function process_credentials_at_setup_p($v1)
	{
		global $cb_p6;
		$request=$v1;

		
		$credentials = $request['opt'][$this->internal['prefix'].'client_details_input'];
		
		if($credentials=='')
		{
			$error=true;
		
		}
		if($credentials!='')
		{
			
			// Wow wow wow. We got the client credentials copy pasted directly - parse them:
			$process=stripslashes($credentials);
			
		
			$snip_start = strpos($process,'ID:')+3;
			$snip = stripslashes(substr($credentials,$snip_start,strlen($process)));

			$snip=str_replace('API Version:','',$snip);
			$snip=str_replace('Client Secret:','',$snip);
			$snip=str_replace('Creator\'s Access Token:','',stripslashes($snip));
			$snip=str_replace('Creator\'s Refresh Token:','',stripslashes($snip));

			$snip = explode(PHP_EOL, $snip);
			
			$credentials=array();
			foreach($snip as $key => $value)
			{
				$snip[$key]=trim($snip[$key]);
				
				if($snip[$key]!='')
				{
					$credentials[]=$snip[$key];
					
				}
				
			}
			
			// Remove api version:
			
			array_splice($credentials, 1, 1);
			
			// Cleaned, prepared. Check if we have all 4 keys:

			if(!isset($credentials) OR !is_array($credentials))
			{

					$this->opt['last_operation_result']=$this->lang['error_auto_parsing_credentials_failed'];
					$this->update_opt();
					
				
			}
			else
			{
			
				$error=false;
				foreach($credentials as $key => $value)
				{
					if($credentials[$key]=='')
					{
						$error=true;
					}
					
				}

				if($error==true)
				{
					$this->opt['last_operation_result']=$this->lang['error_auto_parsing_credentials_failed'];
					$this->update_opt();
					
				}
				else
				{

					// Update options from array:
					
					update_option('patreon-client-id',$credentials[0]);
								
					update_option('patreon-client-secret',$credentials[1]);
					
					update_option('patreon-creators-access-token',$credentials[2]);
					
					update_option('patreon-creators-refresh-token',$credentials[3]);
					
													
					
				}
			}
		
		}
		
		if($error)
		{
			$this->opt['last_operation_result']=$this->lang['error_auto_parsing_credentials_failed'];
			$this->opt['last_operation_result_key']='error_auto_parsing_credentials_failed';
			$this->update_opt();
			
			wp_redirect($this->internal['admin_url'].'admin.php?page=setup_wizard_'.$this->internal['id'].'&'.$this->internal['prefix'].'setup_stage=1');
			exit;			
			
		}
		else
		{
				// Success 
				
				unset($this->opt['last_operation_result']);
				unset($this->opt['last_operation_result_key']);
				$this->opt['setup_is_being_done']=true;
				$this->opt['setup_successful_show_guides']=true;
				$this->update_opt();
							
		
				wp_redirect($this->internal['admin_url'].'admin.php?page=setup_wizard_'.$this->internal['id'].'&'.$this->internal['prefix'].'setup_stage=2');
				exit;				
			
			
		}
		
		 
	}
	public function api_credentials_fail_during_setup_p($v1)
	{
		global $cb_p6;

		// This happened during setup, and credentials failed. Drop a notifier.
		$this->internal['setup_is_being_done']=true;
		$cb_p6->internal['setup_is_being_done']=true;

		$this->opt['setup_is_being_done']=false;
		$this->opt['setup_done']=true;
		unset($this->opt['last_operation_result']);
		unset($this->opt['last_operation_result_key']);

		$this->update_opt();

		require($this->internal['plugin_path'].'plugin/includes/api_credentials_setup_failed.php');
		
	}
	public function required_plugins_p($v1)
	{
		if(!function_exists('wp_get_current_user')) {
			include(ABSPATH . "wp-includes/pluggable.php"); 
		}
		
		if ( !( is_admin() AND current_user_can('manage_options') ) ) {
			return;
		}
		
		$active_plugins=get_option('active_plugins');
		
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$plugins = get_plugins();
		$to_process = false;
		
		// Iterate through required plugins and match against existing ones
		foreach ( $this->internal['required_plugins'] as $key => $value ) {
			
			$installed = false;
			$active = false;
			$correct_version = false;
			$process = false;
			
			foreach ( $plugins as $plugin_key => $plugin_value ) {

				if ( $plugin_key == $this->internal['required_plugins'][$key]['slug'] ) {
				
					$installed = true;
					
					if ( is_plugin_active( $plugin_key ) ) {
						
						$active = true;
					}
					
					if(version_compare( $plugins[$plugin_key]['Version'], $this->internal['required_plugins'][$key]['version'], '>=' ))
					{
						
						$correct_version = true;
					}
					
				}
				
			}
			
			if ( !$installed OR !$active OR !$correct_version ) {
				$process = true;		
			}
			
			if ( $process ) {
				
				if ( !$to_process ) {
					$to_process = array();
				}
				
				$to_process[$key] = $this->internal['required_plugins'][$key];
				
				$to_process[$key]['installed'] = $installed;
				$to_process[$key]['active'] = $active;
				$to_process[$key]['correct_version'] = $correct_version;
				
			}
			
		}
		
		return $to_process;
		
	}
	public function install_update_plugins_p($v1) {
		
		if(!function_exists('wp_get_current_user')) {
			include(ABSPATH . "wp-includes/pluggable.php"); 
		}
		
		if ( !( is_admin() AND current_user_can('manage_options') ) ) {
			return;
		}
				
		$required_plugins = $this->required_plugins();
		
		include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' ); //for plugins_api..
		
//includes necessary for Plugin_Upgrader and Plugin_Installer_Skin
		include_once( ABSPATH . 'wp-admin/includes/file.php' );
		include_once( ABSPATH . 'wp-admin/includes/misc.php' );
		include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
		include_once( $this->internal['plugin_path'] . 'plugin/includes/upgrader_skin.php' );
		
		$errors_encountered = false;
		
		foreach ( $required_plugins as $key => $value ) {
			
			
			// New concise format deactivates, deletes and reinstalls all plugins. If necessary, old format that does different actions depending on not installed, inactive, and wrong version states can be retrieved from commit f5dea12032b249118f5912ab83ade82cfe96ac5a at github			
			
				
			if( !$required_plugins[$key]['installed'] OR !$required_plugins[$key]['correct_version'] OR !$required_plugins[$key]['activated'] ) {
				
				// Deactivate
				
				if ( $required_plugins[$key]['activated'] ) {
				
					echo $required_plugins[$key]['name']. ' - <div class="cb_p2_plugin_install_info">deactivating</div>';
					echo '<br>';
					
					@deactivate_plugins( $required_plugins[$key]['slug'] );
					
					if ( is_plugin_active( $required_plugins[$key]['slug'] ) ) {
						// Deactivation failed
						
						echo '<div class="cb_p2_plugin_install_error">Deactivation of old plugin failed!</div>';
					}
				
				}
				
				// Uninstall
				
				if ( $required_plugins[$key]['installed'] ) {
					
					echo $required_plugins[$key]['name']. ' - <div class="cb_p2_plugin_install_info">uninstalling</div>';
					echo '<br>';				
					
					$error_check = @delete_plugins( array( $required_plugins[$key]['slug'] ) );
					
					if ( is_wp_error( $error_check ) ) {
						
						echo '<div class="cb_p2_plugin_install_error">Uninstallation of old plugin failed! Error was: '.$error_check->get_error_message().'</div>';
					}
				}
				
				// Install
				
				$api = plugins_api( 'plugin_information', array(
					'slug' => $required_plugins[$key]['plugin_name_slug'],
					'fields' => array(
						'short_description' => false,
						'sections' => false,
						'requires' => false,
						'rating' => false,
						'ratings' => false,
						'downloaded' => false,
						'last_updated' => false,
						'added' => false,
						'tags' => false,
						'compatibility' => false,
						'homepage' => false,
						'donate_link' => false,
					),
				));
				
				$api->download_link = $required_plugins[$key]['download_url'];
						
				echo $required_plugins[$key]['name']. ' - <div class="cb_p2_plugin_install_info">downloading & installing</div>';
				echo '<br>';
				// Ob needed to prevent further output by upgraders
				ob_start();
				
				// Updater details credit 
				// https://stackoverflow.com/a/38768707/1792090
				
				// Non silent version below
				// $cb_p2_upgrader = new Plugin_Upgrader( new Plugin_Installer_Skin( compact('title', 'url', 'nonce', 'plugin', 'api') ) );
				
				$cb_p2_upgrader = new \Plugin_Upgrader( new Quiet_Skin() );
				// Keep installation silent
				
				$install_result = $cb_p2_upgrader->install($api->download_link);
				$dummy = ob_get_clean();
								
				if ( is_wp_error( $install_result ) ) {
					
					echo $required_plugins[$key]['name']. ' - <div class="cb_p2_plugin_install_fail">installation failed</div>';
					echo 'Error was "'.$install_result->get_error_message().'"';
					echo '<br>';
					
					$errors_encountered = true;
					
				}
				else {
					if ( $install_result ) {
						echo $required_plugins[$key]['name']. ' - <div class="cb_p2_plugin_install_success">installation successful!</div>';
						echo '<br>';
								
						$activate_plugin = activate_plugin( WP_PLUGIN_DIR  . '/' . $required_plugins[$key]['slug'] );
					
						if ( is_wp_error( $activate_plugin ) ) {
							
							echo $required_plugins[$key]['name']. ' - <div class="cb_p2_plugin_install_fail">activation failed</div>';
							echo '<br>';
							echo 'Error was "'.$activate_plugin->get_error_message().'"';
							echo '<br>';
							$errors_encountered = true;
						}
						else {
							// if ( is_plugin_active( WP_PLUGIN_DIR  . '/' . $required_plugins[$key]['slug'] ) ) {
							if ( is_null( $activate_plugin ) ) {
								echo $required_plugins[$key]['name']. ' - <div class="cb_p2_plugin_install_success">activation successful!</div>';
								echo '<br>';
							}
							else {
								echo $required_plugins[$key]['name']. ' - <div class="cb_p2_plugin_install_fail">activation failed</div>';
								echo '<br>';
								$errors_encountered = true;
							}
						}						
						
					}

				}				
				
			}
				
		}
		
		if ( $this->required_plugins() ) {
			
			// There are still issues
			
			?>
			<h2>Sorry - couldn't complete setup</h2>
			<div class="cb_p2_setup_wizard_text_small">You can retry configuring plugins again. If this issue persists, please contact CodeBard help desk <a href="https://codebard.com/help-desk" target="_blank">here</a></div>
				<form id="cb_p2_ajax_plugin_install_form" method="post" action="<?php echo $this->internal['admin_url'].'admin.php?page=setup_wizard_'.$this->internal['id']; ?>" ajax_target_div="cb_p2_install_update_plugin_results">
					<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Retry configuring plugins"></p>
					<input type="hidden" name="wp_ajax_<?php echo $this->internal['prefix'].'install_update_plugins'; ?>" value="1" />
					<input type="hidden" name="<?php echo $this->internal['prefix'].'setup_stage'; ?>" value="0" />
				</form>
			
			<?php
			
		}
		else {
			
			?>
			<h2>Great! All good! Now we can connect your site to Patreon</h2>
				<form method="post" action="<?php echo $this->internal['admin_url'].'admin.php?page=setup_wizard_'.$this->internal['id']; ?>" ajax_target_div="cb_p2_install_update_plugin_results">
					<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Let's go!"></p>
					<input type="hidden" name="<?php echo $this->internal['prefix'].'setup_stage'; ?>" value="1" />
				</form>
			
			<?php	
			
			
		}
		
		// Exit for ajax response (html)
		
		exit();
		
	}
	
	
	public function save_user_last_visited_page_before_login_p() 
	{
	
		global $post;
 
		if(is_admin())
		{
			
			setcookie( $this->internal['prefix'].'user_last_visited_page', '', 0 );
			return;
		}

		if(!is_user_logged_in() AND strpos($this->get_current_full_url(),$this->get_patreon_landing_page())===false AND (is_single($post->ID) OR is_page($post->ID)))
		{
		
			setcookie( $this->internal['prefix'].'user_last_visited_page', base64_encode(get_permalink($post->ID)), time()+(30 * 3600 * 24));
		}
		
	}
	
	public function make_date_select_p($v1=false)
	{
		$args = $v1;
		
		if(isset($args['start_year']))
		{
			$start_year=$args['start_year'];
		}
		else
		{
			$start_year=1900;
		}
		
		if(isset($args['end_year']))
		{
			$end_year=$args['end_year'];
			
		}
		else
		{
			$end_year=date("Y");
		}
		
		$load_template = 'date_select';
		
		if(isset($args['template'])) {
			$load_template = $args['template'];
		}
		
		$date_template = $this->load_template($load_template);
		
		$date_template = $this->process_lang($date_template);
			
		// Process the internal ids and replacements
			
		$date_template = $this->process_vars_to_template($this->internal, $date_template,array('prefix','id'));		
		
		// Make days:
		
		$counter=1;
		$days='';
		while($counter<=31)
		{
			// 
			if($counter<10) {
				// Slap a zero
				$day_count='0'.$counter;
				
			}
			else {
				$day_count=$counter;
			}
			$day_label=$counter;
			if(isset($this->lang['day_of_month_'.$day_count]) AND $this->lang['day_of_month_'.$day_count]!='')
			{
				// Why did we do this? because we want languages which dont use roman numerals to be able to have day translations coming from language file.
				
				// If it exists, override label:
				
				$day_label=$this->lang['day_of_month_'.$day_count];
				
				
			}
			$selected ='';
			if(isset($args['selected_day']) AND $args['selected_day'] == $day_count)
			{
				$selected = " selected";
			}
			
			$days.='<option value="'.$day_count.'"'.$selected.'>'.$day_label.'</option>';
			
			$counter++;
		}
		
		// Do months
		$counter=1;
		$months='';		
		while($counter<=12)
		{
			// 
			if($counter<10)
			{
				// Slap a zero
				$month_count='0'.$counter;
				
			}
			else
			{
				$month_count=$counter;
			}
			$month_label=$counter;
			if(isset($this->lang['month_'.$month_count]) AND $this->lang['month_'.$month_count]!='')
			{
				// Why did we do this? because we want languages which dont use roman numerals to be able to have month translations coming from language file. Also we will put default language there
				
				// If it exists, override label:
				
				$month_label=$this->lang['month_'.$month_count];
				
			}
			$selected ='';
			if(isset($args['selected_month']) AND $args['selected_month'] == $month_count)
			{
				$selected = " selected";
			}			
			$months.='<option value="'.$month_count.'"'.$selected.'>'.$month_label.'</option>';
			
			$counter++;
		}
		
		// Do years
		$counter=$end_year;

		$years='';		
		while($counter>=$start_year)
		{

			$year_label=$counter;
			if(isset($this->lang['year_'.$counter]) AND $this->lang['year_'.$counter]!='')
			{
				// Anyone wanting to use non numeral years may be quite unlikely, but just in case.
				
				// If it exists, override label:
				
				$year_label = $this->lang['year_'.$counter];
				
			}
			$selected ='';
			if(isset($args['selected_year']) AND $args['selected_year'] == $counter)
			{
				$selected = " selected";
			}			
			$years.='<option value="'.$counter.'"'.$selected.'>'.$year_label.'</option>';
			
			$counter--;
		}
		if(isset($args['fieldset_class']))
		{
			$fieldset_class=$args['fieldset_class'];
		}
		else
		{
			$fieldset_class='date_fieldset';
		}
		
		if(isset($args['title']))
		{
			$title=$args['title'];
		}
		else
		{
			$title=$this->lang['date'];
		}
		
		if(isset($args['label_month']))
		{
			$label_month=$args['label_month'];
		}
		else
		{
			$label_month=$this->lang['month'];
		}
		
		if(isset($args['id_month']))
		{
			$id_month=$args['id_month'];
		}
		else
		{
			$id_month='id_month';
		}
		
		if(isset($args['select_name_month']))
		{
			$select_name_month=$args['select_name_month'];
		}
		else
		{
			$select_name_month='select_month';
		}
		
		
		if(isset($args['label_day']))
		{
			$label_day=$args['label_day'];
		}
		else
		{
			$label_day=$this->lang['day'];
		}
		
		if(isset($args['id_day']))
		{
			$id_day=$args['id_day'];
		}
		else
		{
			$id_day='id_day';
		}
		
		if(isset($args['select_name_day']))
		{
			$select_name_day=$args['select_name_day'];
		}
		else
		{
			$select_name_day='select_day';
		}
		
		if(isset($args['label_year']))
		{
			$label_year=$args['label_year'];
		}
		else
		{
			$label_year=$this->lang['year'];
		}
		
		if(isset($args['id_year']))
		{
			$id_year=$args['id_year'];
		}
		else
		{
			$id_year='id_year';
		}
		
		if(isset($args['select_name_year']))
		{
			$select_name_year=$args['select_name_year'];
		}
		else
		{
			$select_name_year='select_year';
		}
		
		if(isset($args['default_year_value']) AND isset($args['default_year_label']) ) {
			$years='<option value="'.$args['default_year_value'].'">'.$args['default_year_label'].'</option>'.$years;
		}
		if(isset($args['default_month_value']) AND isset($args['default_month_label']) ) {
			$months='<option value="'.$args['default_month_value'].'">'.$args['default_month_label'].'</option>'.$months;
		}
		if(isset($args['default_day_value']) AND isset($args['default_day_label']) ) {
			$days='<option value="'.$args['default_day_value'].'">'.$args['default_day_label'].'</option>'.$days;
		}
		
		$vars=array(
		
			'months' => $months, 
			'days' => $days, 
			'years' => $years, 
			'fieldset_class' => $fieldset_class, 
			'title' => $title, 
			'label_year' => $label_year, 
			'id_year' => $id_year, 
			'select_name_year' => $select_name_year, 
			'label_month' => $label_month, 
			'id_month' => $id_month, 
			'select_name_month' => $select_name_month, 
			'label_day' => $label_day,
			'id_day' => $id_day, 
			'select_name_day' => $select_name_day, 
			
		);
		
		$date_template = $this->process_vars_to_template($vars, $date_template);
				
		return $date_template;
	}
	public function admin_notices_p() {
		
		$active_lang=$this->opt['lang'];
		if(!$active_lang OR $active_lang=='') {
			$active_lang='en-US';
		}
		$setup_notice_shown = false;

		if( ( !isset( $this->opt['setup_done'] ) OR !$this->opt['setup_done'] ) AND ( !isset( $_REQUEST['page'] ) OR $_REQUEST['page'] != 'setup_wizard_'.$this->internal['id'] ) ) {
			
			// Include language file:
			?>
				 <div class="error notice">
					<p><?php echo $this->lang['setup_not_complete']; ?></p>
				</div>
			<?php
			$setup_notice_shown = true;
		}
		
		if( $this->required_plugins() AND ( !isset( $_REQUEST['page'] ) OR $_REQUEST['page'] != 'setup_wizard_'.$this->internal['id'] ) AND !$setup_notice_shown ) {
			
			// Include language file:
			?>
				 <div class="error notice">
					<p><?php echo $this->lang['required_plugins_missing']; ?></p>
				</div>
			<?php		
		}
	}
	
	
	public function frontend_init_p() {
		
		add_filter( 'the_content', array(&$this, 'add_post_buttons'), 10 , 1 );
		
		add_action('wp_head', array(&$this, 'add_css_to_head'));
		
	}
	
	// #MARKER
	
	public function add_post_buttons_p( $content ) {
		
		// Return if it is not a post from an accepted post type		
		if(in_array('get_the_excerpt', $GLOBALS['wp_current_filter']) OR !in_array( get_post_type(), $this->opt['accepted_post_types'] ) ) {
			return $content;
		}
	
		global $post;
		
		// In case the url has https://, replace it with http:// so shares will concentrate on one url
		$get_url=get_permalink($post->ID);
		
		$share_url = urlencode($get_url);
		
		$share_title = urlencode( $post->post_title );
		

		// form array of items set to 1
		$shares.='<div class="cb_p2_share_container"><ul class="cb_p2_socialshare">';
		$follows.='<div class="cb_p2_follow_container"><ul class="cb_p2_socialshare">You can follow CodeBard from below social networks<br clear="both">';
		foreach($this->opt['social_networks'] as $key => $value)
		{
			$processed_url='';
			$current=$this->opt['social_networks'][$key];
			
			if(!$current['active'])
			{
				continue;
			}
			 
			$shares .= '<li class="cb_p2_socialshare_item">';	
			$follows .= '<li class="cb_p2_socialshare_item">';	
		
			
			$processed_url=str_replace('{CONTENTTITLE}',$share_title,$current['url']);
			$processed_url=str_replace('{CONTENTURL}',$share_url,$processed_url);
			
			if($key=='twitter')
			{
				$processed_url=str_replace('{FOLLOWACCOUNT}',$this->opt['social_networks'][$key]['follow'],$processed_url);
		
			
			}
			if($key=='pinterest')
			{
					
				$processed_url=str_replace('{CONTENTIMAGE}',wp_get_attachment_url(get_post_thumbnail_id()),$processed_url);
				
			}			
			$shares .= '<a class="cb_p2_socialshare_link cb_p2_socialshare_button_'.$key.'" href="'.$processed_url.'" rel="nofollow" target="_blank">'.$current['text'].'</a>';	
			if($current['follow']!='')
			{
				if($key=='twitter')
				{
					$current['follow']='http://twitter.com/'.$current['follow'];
				
				}			
				$follows .= '<a class="cb_p2_socialshare_link cb_p2_socialshare_button_'.$key.'" href="'.$current['follow'].'" rel="nofollow" target="_blank">&nbsp;</a>';	
			}
			$shares .= '</li>';				
			$follows .= '</li>';				
			
	
		
		}
		$shares.='</ul></div>';
		$follows.='</ul></div>';
		
		return $content.$shares.$follows;
			


	}
	
	public function add_css_to_head_p() {
	
		echo '<style>
		
		
			.cb_p2_share_container {
				display: inline-table:
				width : 100%;
				clear:both;
				margin-top:20px;
			}

		
			.cb_p2_socialshare {
				padding-left: 0;
				list-style: none; 
				text-align : center;
			}

			.cb_p2_socialshare_item {
				display: inline;
				font-size : '.$this->opt['style']['button_font_size'].'em;
			}
	
			.cb_p2_socialshare_follow_item {
				display: inline;
				font-size : '.$this->opt['style']['follow_button_icon_size'].'px;
			}
	
			.cb_p2_socialshare_link {
			
				text-decoration: '.$this->opt['style']['button_text_decoration'].';
				color: '.$this->opt['style']['button_link_color'].';
				font-weight: '.$this->opt['style']['button_font_weight'].';
				padding: .3em .45em .3em '.($this->opt['style']['button_icon_size']+8).'px;
				background-color: '.$this->opt['style']['button_background_color'].';
				border: '.$this->opt['style']['button_border_thickness'].'px '.$this->opt['style']['button_border_style'].' '.$this->opt['style']['button_border_color'].';
				display: inline-block;
				background-size: '.$this->opt['style']['button_icon_size'].'px '.$this->opt['style']['button_icon_size'].'px;
				background-repeat: no-repeat;
				background-position: 5px center;
				margin: '.$this->opt['style']['button_margin'].'em;
			  
			  }
			  
			.cb_p2_socialshare_follow_link {
			
				text-decoration: '.$this->opt['style']['button_text_decoration'].';
				color: '.$this->opt['style']['button_link_color'].';
				font-weight: '.$this->opt['style']['button_font_weight'].';
				padding: .5em .5em .5em .5em;
				background-color: '.$this->opt['style']['button_background_color'].';
				border: '.$this->opt['style']['button_border_thickness'].'px '.$this->opt['style']['button_border_style'].' '.$this->opt['button_border_color'].';
				display: inline-block;
				background-size: '.$this->opt['style']['follow_button_icon_size'].'px '.$this->opt['style']['follow_button_icon_size'].'px;
				background-repeat: no-repeat;
				background-position: 5px center;
				margin: '.$this->opt['style']['button_margin'].'em;
			  
			  }			  
			  
			.cb_p2_socialshare_link:hover, 
			.cb_p2_socialshare_link:active, 
			.cb_p2_socialshare_link:focus 
			{
				color: #0000ff;
				text-decoration : none;
			}
			';
			
			foreach($this->opt['social_networks'] as $key => $value) {
				echo '			.cb_p2_socialshare_button_'.$key.' {
				background-image: url("'.$this->internal['plugin_url'].'plugin/templates/default/images/icon_set_1/'.$key.$this->opt['style']['button_icon_size'].'.png");
				}';

			}
			
		
		echo '</style>';


	}	
	
}


$cb_p2 = cb_p2_plugin::get_instance();

function cb_p2_get()
{

	// This function allows any plugin to easily retieve this plugin object
	return cb_p2_plugin::get_instance();

}