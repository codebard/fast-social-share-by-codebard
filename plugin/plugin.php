<?php


class cb_p2_plugin extends cb_p2_core
{
	public function plugin_construct() {
		
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
						
		$this->internal['plugin_update_url'] =  wp_nonce_url(get_admin_url().'update.php?action=upgrade-plugin&plugin='.$this->internal['plugin_slug'],'upgrade-plugin_'.$this->internal['plugin_slug']);
		
		add_action( 'wp_ajax_'.$this->internal['prefix'].'install_update_plugins', array( &$this, 'install_update_plugins' ),10,1 );
		
		add_action( 'wp_ajax_'.$this->internal['prefix'].'social_network_edit', array( &$this, 'social_network_edit' ),10,1 );
		
		add_action( 'wp_ajax_'.$this->internal['prefix'].'update_social_network', array( &$this, 'social_network_add_update' ),10,1 );

		add_action( 'wp_ajax_'.$this->internal['prefix'].'save_style', array( &$this, 'save_style' ),10,1 );

		add_action( 'wp_ajax_'.$this->internal['prefix'].'make_social_network_list', array( &$this, 'make_social_network_list' ),10,1 );
		
		add_action( 'wp_ajax_'.$this->internal['prefix'].'refresh_post_to_style_assignments_div', array( &$this, 'refresh_post_to_style_assignments_div' ),10,1 );
		
		add_action( 'wp_ajax_'.$this->internal['prefix'].'delete_social_network', array( &$this, 'delete_social_network' ),10,1 );
		
		add_action( 'wp_ajax_'.$this->internal['prefix'].'load_set_to_edit', array( &$this, 'load_set_to_edit' ),10,1 );
		
		add_action( 'wp_ajax_'.$this->internal['prefix'].'activate_style', array( &$this, 'activate_style' ),10,1 );
		
		add_action( 'wp_ajax_'.$this->internal['prefix'].'assign_style_to_post_type', array( &$this, 'assign_style_to_post_type' ),10,1 );
		
		add_action( 'wp_ajax_'.$this->internal['prefix'].'change_option_from_ajax', array( &$this, 'change_option_from_ajax' ),10,1 );
		
		// Add css to head in admin if the page is related to the design wizard
		
		if ( ( isset( $_REQUEST['cb_p2_tab'] ) AND $_REQUEST['cb_p2_tab'] == 'customize_design' ) OR
			 ( isset( $_REQUEST['page'] ) AND $_REQUEST['page'] == 'setup_wizard_cb_p2' )
			)
		{
			add_action('admin_head', array(&$this, 'add_css_to_head'));
		}
						
	}
	public function init_p() {
		
		if( $this->required_plugins() OR !$this->opt['setup_done'] ) {
			return;
		}
		
		
	}
	public function load_options_p() {
		// Initialize and modify plugin related variables
		
		return $this->internal['core_return'];
		
	}
	
	// Plugin specific functions start

	public function setup_languages_p() {
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
	public function check_redirect_to_setup_wizard_p() {
	
		if(is_admin() AND current_user_can('manage_options')) {
		
			// If setup was not done, redirect to wizard

			if( isset( $this->opt['redirect_to_setup_wizard'] ) AND $this->opt['redirect_to_setup_wizard'] ) {

				$this->opt['setup_is_being_done']=true;
				$this->opt['redirect_to_setup_wizard'] = false;
				$this->update_opt();
				// wp_redirect($this->internal['admin_url'].'admin.php?page=settings_cb_p6&cb_p6_tab=content_locking');
				wp_redirect($this->internal['admin_url'].'admin.php?page=setup_wizard_'.$this->internal['id'].'&'.$this->internal['prefix'].'setup_stage=0');
				exit;	
			}
		}
		
	}	
	public function enqueue_frontend_styles_p() {
		wp_enqueue_style( $this->internal['id'].'-css-main', $this->internal['template_url'].'/'.$this->opt['template'].'/style.css' );
	}
	public function enqueue_admin_styles_p() {
		$current_screen=get_current_screen();

		if(is_admin())
		{
			wp_enqueue_style( $this->internal['id'].'-css-admin', $this->internal['plugin_url'].'plugin/includes/css/admin.css' );
			
			if ( ( isset( $_REQUEST['cb_p2_tab'] ) )  OR
			 ( isset( $_REQUEST['page'] ) AND $_REQUEST['page'] == 'setup_wizard_cb_p2' )
			 )
			 {	
				$wp_scripts = wp_scripts();
				wp_enqueue_style(
				  'jquery-ui-theme-smoothness',
				  sprintf(
					'//ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/smoothness/jquery-ui.css', // working for https as well now
					$wp_scripts->registered['jquery-ui-core']->ver
				  )
				);
				wp_enqueue_style( 'wp-color-picker');
			}
			
		}		
	}
	public function enqueue_frontend_scripts_p() {
	
	}	
	public function enqueue_admin_scripts_p() {
		// This will enqueue the Media Uploader script
		

		if ( ( isset( $_REQUEST['cb_p2_tab'] ))  OR
			 ( isset( $_REQUEST['page'] ) AND $_REQUEST['page'] == 'setup_wizard_cb_p2' )
			 )
			 {	
			wp_enqueue_media();
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_script( 'jquery-ui-dialog' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( $this->internal['id'].'-js-admin', $this->internal['plugin_url'].'plugin/includes/scripts/admin.js' );
		}	
	}
	public function upgrade_p($v1,$v2=false) {
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
	public function do_setup_wizard_p() {
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
	public function process_credentials_at_setup_p($v1) {
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
	public function api_credentials_fail_during_setup_p($v1) {
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
	public function required_plugins_p($v1) {
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
	public function make_date_select_p($v1=false) {
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
	
	public function make_share_interface_p( $post_id = false ) {
		
		if ( !$post_id ) {
			
			global $post;
			
			if ( isset( $post->ID ) ) {
				$post_id = $post->ID;
			}
			
		}
		
		$share_url = '';
		$share_title = '';
		$tags = '';
		
		if ( $post_id ) {
			
			// In case the url has https://, replace it with http:// so shares will concentrate on one url
			$get_url=get_permalink($post_id);
			
			$post = get_post( $post_id );
			
			$share_url = urlencode($get_url);
			
			$share_title = urlencode( $post->post_title );
			
			$tags = wp_get_post_tags( $post_id );
		}
		
		$share_interface_template = $this->load_template( 'share_interface' );
		
		$share_interface_template = $this->process_lang($share_interface_template);
			
		// Process the internal ids and replacements
			
		$share_interface_template = $this->process_vars_to_template($this->internal, $share_interface_template,array('prefix','id'));
		
		$button_template = $this->load_template( 'share_button' );
		
		$button_template = $this->process_lang($button_template);
		
		$button_template = $this->process_vars_to_template($this->internal, $button_template,array('prefix','id'));	
		
		$shares = '';

		foreach( $this->opt['social_networks'] as $key => $value )
		{
			if( $this->opt['social_networks'][$key]['name'] == '' ) {
				continue;
			}
			
			$processed_url = '';
			
			$current=$this->opt['social_networks'][$key];
			
			if(!$current['active']) {
				continue;
			}
			 
			$button = $button_template;			
			
			$processed_url=str_replace('{CONTENTTITLE}',$share_title,$current['url']);
			$processed_url=str_replace('{CONTENTURL}',$share_url,$processed_url);
			
			if($key=='twitter')
			{
				
				$processed_url=str_replace('{FOLLOWACCOUNT}',$this->opt['social_networks'][$key]['follow'],$processed_url);
						
				if ( is_array( $tags ) AND count( $tags ) > 0 ) {
					
					$add_twitter_tags = '';
					
					foreach( $tags as $twitter_tag_key => $twitter_tag_value ) {
						$add_twitter_tags .= str_replace( ' ', '', $tags[$twitter_tag_key]->name ) . ',';
					}
										
					$processed_url .= '&hashtags=' . substr( $add_twitter_tags,  0, -1);
					
				}
			}
			if($key=='linkedin')
			{
				
				$processed_url=str_replace('{FOLLOWACCOUNT}',$this->opt['social_networks'][$key]['follow'],$processed_url);
				
				if ( strlen( $share_title ) > 200 ) {
					$share_title = substr( $share_title, 0 , 197 ) . '...';
				}

				setup_postdata( get_post( $post_id ) );
				$linkedin_excerpt = get_the_excerpt();
				wp_reset_postdata();
				
				if ( strlen( $linkedin_excerpt ) > 250 ) {
					$linkedin_excerpt = substr( $linkedin_excerpt, 0 , 247 ) . '...';
				}
				
				$processed_url .= '&title=' . urlencode( $share_title ).'&summary='.urlencode( $linkedin_excerpt );
				
			}
			if($key=='pinterest')
			{
					
				$processed_url=str_replace('{CONTENTIMAGE}',wp_get_attachment_url(get_post_thumbnail_id()),$processed_url);
				
			}
			
			$button_content = $this->get_share_button_content( $key, $processed_url, $current['text_before'], $current['text_after'] );
			
			$vars = array(
				'button_content' => $button_content,
			);
			
			$button = $this->process_vars_to_template($vars, $button);
			
			$shares .= $button;
		
		}
		
		$vars=array(
			'social_share_buttons' => $shares,
		);
		
		$share_interface_template = $this->process_vars_to_template($vars, $share_interface_template);
		
		return $share_interface_template;
		
	}
	public function get_share_button_content_p( $network, $url, $text_before, $text_after ) {
		
		$selected_set = $this->opt['style_set'];
		$selected_icon_set = $this->opt['styles'][$selected_set]['icon_set'];
		
		// If a specific style is set for this post type, set it to that

		$post_type = get_post_type();

		if ( $post_type AND array_key_exists($post_type,$this->opt['post_types']) )  {
			$selected_set = $this->opt['post_types'][$post_type];
			
			if ( $selected_set == 'default' ) {
				$selected_set = $this->opt['style_set'];
			}
			
			$selected_icon_set = $this->opt['styles'][$selected_set]['icon_set'];
		}		
		
		if ( isset( $_REQUEST['cb_p2_set'] ) AND current_user_can('manage_options')  ) {
			$selected_set = $_REQUEST['cb_p2_set'];		
			$selected_icon_set = $this->opt['styles'][$selected_set]['icon_set'];
		}
		
		// Set the set to default set if it is set to value default
		
		if ( $selected_set == 'default' ) {
			$selected_set = $this->opt['style_set'];
			$selected_icon_set = $this->opt['styles'][$selected_set]['icon_set'];
		}		

		$sizes = array(
			'16',
			'20',
			'24',
			'28',
			'32',
			'36',
			'42',
			'48',
			'64',		
		);
		
		
		$closest_icon_size = $this->get_closest($this->opt['styles'][$selected_set]['button_icon_size'],$sizes);

		
		
		
		$button_icon = $this->internal['plugin_url'].'plugin/images/'.$selected_icon_set.'/'.$network.'/'.$closest_icon_size.'.png';
		
		if ( $this->opt['social_networks'][$network]['icon'] != 'default' )  {
			$button_icon = $this->opt['social_networks'][$network]['icon'];
		}
		
		
		return '<a class="'.$this->internal['prefix'].'social_share_link '.$this->internal['prefix'].'social_share_button_'.$network.'" href="'.$url.'" rel="nofollow" target="'.$this->opt['functionality']['share_link_target'].'"><img src="'.$button_icon.'" class="cb_p2_icon_'.$network.'" style="width:'.$this->opt['styles'][$selected_set]['button_icon_size'].'px; height:'.$this->opt['styles'][$selected_set]['button_icon_size'].'px;" /><div class="cb_p2_social_share_link_text" style="display: '.$this->opt['styles'][$selected_set]['button_text_display'].' !important;">'.$text_after.'</div></a>';		
	}
	
	public function get_closest($search, $arr) {
		// Gets closest value from an array to a given value
		// credit:
		// https://stackoverflow.com/a/5464961/1792090
	   $closest = null;
	   foreach ($arr as $item) {
		  if ($closest === null || abs($search - $closest) > abs($item - $search)) {
			 $closest = $item;
		  }
	   }
	   return $closest;
	}
	public function make_design_selector_p(  ) {
		
		$sets = '';
		
		$selected_set = $this->opt['style_set'];
		
		if ( isset( $_REQUEST['cb_p2_set'] ) AND current_user_can('manage_options') ) {
			$selected_set = $_REQUEST['cb_p2_set'];		
		}

		foreach ( $this->opt['styles'] as $key => $value ) {
			
			$set_name = $key;
			
			$selected = '';
			
			if( isset( $this->lang['style_'.$key] ) ) {
				
				$set_name = $this->lang['style_'.$key];
				
			}
			
			if ( $key == $selected_set ) {
				$selected = 'selected';
			}
		
			$sets .= '<option value="'.$key.'" '.$selected.'>'.$set_name.'</option>';			
			
		}
		
		return '<div id="cb_p2_design_editor"><div id="cb_p2_style_preview_form_heading">Preview a style</div> <form action="" method="post" id="cb_p2_style_preview_form"><select id="cb_p2_set_selector" name="cb_p2_set">'.$sets.'</select></form><div class="cb_p2_admin_button_general" id="cb_p2_select_style_button" target="cb_p2_selector_messages" target_url="">Activate</div><div class="cb_p2_admin_button_general" id="cb_p2_customize_style_button" target="cb_p2_set_editor">Customize</div></div>';		
	}
	
	public function make_design_selector_for_setup_wizard_p() {
		
		// Why?
		// Because we want to offer different options for the wizard. Those options may differentiate more in future. Hence this separate function
		
		$sets = '';
		
		$selected_set = $this->opt['style_set'];
		
		if ( isset( $_REQUEST['cb_p2_set'] ) AND current_user_can('manage_options') ) {
			$selected_set = $_REQUEST['cb_p2_set'];		
		}

		foreach ( $this->opt['styles'] as $key => $value ) {
			
			$set_name = $key;
			
			$selected = '';
			
			if( isset( $this->lang['style_'.$key] ) ) {
				
				$set_name = $this->lang['style_'.$key];
				
			}
			
			if ( $key == $selected_set ) {
				$selected = 'selected';
			}
		
			$sets .= '<option value="'.$key.'" '.$selected.'>'.$set_name.'</option>';			
			
		}
		
		return '<div id="cb_p2_design_editor"><div id="cb_p2_style_preview_form_heading">Previewing:</div> <form action="" method="post" id="cb_p2_style_preview_form"><select id="cb_p2_set_selector" name="cb_p2_set">'.$sets.'</select></form><form name="cb_p2_move_to_setup_2" enctype="multipart/form-data" id="cb_p2_move_to_setup_2_id" method="post" action="'.$this->internal['admin_url'].'admin.php?page=setup_wizard_'.$this->internal['id'].'&'.$this->internal['prefix'].'setup_stage=1'.'"><input type="hidden" name="cb_p2_selected_style_at_setup" id="cb_p2_selected_style_at_setup" value="" /><div class="cb_p2_admin_button_general" id="cb_p2_customize_style_button" target="cb_p2_set_editor">Customize</div><div class="cb_p2_admin_button_general" id="cb_p2_select_style_and_move_to_next_step_button" target="cb_p2_set_editor">Select Style & Finish</div></form>

	
	</div>';		
	}
	public function add_post_buttons_p( $content ) {
		
		// Return if it is not a post from an accepted post type		
		if( 
			(in_array('get_the_excerpt', $GLOBALS['wp_current_filter']) OR !in_array( get_post_type(), $this->opt['accepted_post_types'] )) AND
			(!isset($_REQUEST['cb_p2_tab']) OR $_REQUEST['cb_p2_tab'] != 'customize_design') AND	
			!( isset( $_REQUEST['page'] ) AND $_REQUEST['page'] == 'setup_wizard_cb_p2' )
				
		) {
			return $content;
		}
		
		$post_id = false;
	
		global $post;
		
		if ( isset ( $post->ID ) ) {
			$post_id = $post->ID;
		}
			
		$share_interface = $this->make_share_interface( $post_id );
		
		// If in install or design wizard, return one set of buttons
		
		if ( is_admin() AND ( $_REQUEST['cb_p2_tab'] == 'customize_design' OR	
			( isset( $_REQUEST['page'] ) AND $_REQUEST['page'] == 'setup_wizard_cb_p2' ) ) ) {
			return $content.$share_interface;
		}		
		
		if ( $this->opt['content_buttons_placement'] == 'top' OR $this->opt['content_buttons_placement'] == 'top_and_bottom'  ) {
			$content = $share_interface.$content;
		}
		if ( $this->opt['content_buttons_placement'] == 'bottom' OR $this->opt['content_buttons_placement'] == 'top_and_bottom'  ) {
			$content = $content.$share_interface;
		}
		
		return $content;
		

	}
	public function add_css_to_head_p() {
		

		$set = $this->opt['style_set'];
		
		// If a specific style is set for this post type, set it to that
		
		$post_type = get_post_type();
		
		if ( $post_type AND array_key_exists($post_type,$this->opt['post_types']) )  {
			$set = $this->opt['post_types'][$post_type];
		}
		
		if ( current_user_can('manage_options') AND isset( $_REQUEST['cb_p2_set'] ) ) {
			$set = $_REQUEST['cb_p2_set'];
		}
		
		// Set the set to default set if it is set to value default

		if ( $set == 'default' ) {
			$set = $this->opt['style_set'];
		}

		if ( $set == 'none' ) {
			// We dont show buttons for this set. Return
			return;
		}
	
		// Process some of the settings to make up for some defaults:
		
		foreach ( $this->opt['styles'][$set] as $key => $value ) {
			if ( substr($key,-6) == '_color' AND $this->opt['styles'][$set][$key] == '' AND $key != 'button_link_color' AND $key != 'button_link_hover_color' ) {
				// This is a color field which was set to none. Make it transparent:
				
				$this->opt['styles'][$set][$key] = 'transparent';
			}
		}
		
		$important = ' !important';
		// We want to mark  !important all css styles for frontend functions so the themes wont override them - except on pages with style editor and setup wizard on admin side
		
		if ( ( isset( $_REQUEST['cb_p2_tab'] ) AND $_REQUEST['cb_p2_tab'] == 'customize_design' ) OR	
			( isset( $_REQUEST['page'] ) AND $_REQUEST['page'] == 'setup_wizard_cb_p2' ) ) {
			$important = '';
		}

		$this->opt['styles'][$set] = $this->opt['styles'][$set] + $this->opt['style_defaults'];
		
		echo '<style>
		
			/* All styles are important-ized to prevent overriding by themes */
		
			.cb_p2_share_container {
				display: inline-table'.$important.';
				max-width : '.$this->opt['styles'][$set]['container_wrapper_width'].'px'.$important.';
				width: 100%'.$important.';
				clear: both'.$important.';
				outline-style: none'.$important.';
				box-shadow: none'.$important.';
				text-align : '.$this->opt['styles'][$set]['container_wrapper_text_align'].$important.';
				';
				
			if ( $this->opt['styles'][$set]['container_wrapper_sticky'] == 'yes' AND is_single() ) {
				
				echo '
			
				position:sticky;
				position: -webkit-sticky;
				top: '.$this->opt['styles'][$set]['container_wrapper_sticky_top_margin'].'px;
				';
				
			}
				
			echo '
			
			// End of earlier css class
			}
			
			.cb_p2_social_share {
				display: inline-block'.$important.';
				max-width : '.$this->opt['styles'][$set]['container_max_width'].'px'.$important.';
				width: 100%'.$important.';
				margin-top: '.$this->opt['styles'][$set]['container_margin'].'px'.$important.';
				margin-bottom: '.$this->opt['styles'][$set]['container_margin'].'px'.$important.';
				padding: '.$this->opt['styles'][$set]['container_padding'].'px'.$important.';
				list-style: none'.$important.'; 
				background-color: '.$this->opt['styles'][$set]['container_background_color'].$important.';
				border-width: '.$this->opt['styles'][$set]['container_border_thickness'].'px'.$important.';
				border-radius: '.$this->opt['styles'][$set]['container_border_radius'].'px'.$important.';
				border-style:  '.$this->opt['styles'][$set]['container_border_style'].$important.';
				border-color:  '.$this->opt['styles'][$set]['container_border_color'].$important.';
				box-shadow: none'.$important.';
				outline-style: none'.$important.';
				text-align : '.$this->opt['styles'][$set]['button_container_text_align'].$important.';
			}

			.cb_p2_social_share_item {
				display: inline-table'.$important.';
				margin: '.$this->opt['styles'][$set]['button_margin'].'px'.$important.';
				box-shadow: none'.$important.';
				outline-style: none'.$important.';
			}
	
			.cb_p2_social_share_follow_item {
				display: inline'.$important.';
				font-size : '.$this->opt['styles'][$set]['follow_button_icon_size'].'px'.$important.';
				box-shadow: none'.$important.';
				outline-style: none'.$important.';
			}
	
			.cb_p2_social_share_link {
				font-size : '.$this->opt['styles'][$set]['button_font_size'].'px'.$important.';
				text-decoration: '.$this->opt['styles'][$set]['button_text_decoration'].$important.';
				color: '.$this->opt['styles'][$set]['button_link_color'].$important.';
				font-weight: '.$this->opt['styles'][$set]['button_font_weight'].$important.';
				padding: '.$this->opt['styles'][$set]['button_padding'].'px'.$important.';
				padding-right: '.$this->opt['styles'][$set]['button_extra_padding'].'px'.$important.';
				padding-left: '.$this->opt['styles'][$set]['button_extra_padding'].'px'.$important.';
				background-color: '.$this->opt['styles'][$set]['button_background_color'].$important.';
				border-width: '.$this->opt['styles'][$set]['button_border_thickness'].'px'.$important.';
				border-radius: '.$this->opt['styles'][$set]['button_border_radius'].'px'.$important.';
				border-style:  '.$this->opt['styles'][$set]['button_border_style'].$important.';
				border-color:  '.$this->opt['styles'][$set]['button_border_color'].$important.';
				display: table-cell'.$important.';
				vertical-align: middle'.$important.';
				box-shadow: none'.$important.';
				outline-style: none'.$important.';
				text-align : '.$this->opt['styles'][$set]['button_text_align'].$important.';
			  
			  }
			  
			  .cb_p2_social_share_link_text{
				  display:inline-block'.$important.';
				  vertical-align:middle'.$important.'; 
				  box-shadow: none'.$important.';
				  outline-style: none'.$important.';
			  }
			  
			  .cb_p2_social_share_link img {
				  display:inline-block'.$important.';
				  vertical-align:middle'.$important.';
				  margin: '.$this->opt['styles'][$set]['button_icon_margin'].'px'.$important.';
				  box-shadow: none'.$important.';
				outline-style: none'.$important.';
			  }
			  
			.cb_p2_social_share_follow_link {
			
				text-decoration: '.$this->opt['styles'][$set]['button_text_decoration'].$important.';
				padding: '.$this->opt['styles'][$set]['button_padding'].'px'.$important.';
				background-color: '.$this->opt['styles'][$set]['button_background_color'].$important.';
				border: '.$this->opt['styles'][$set]['button_border_thickness'].'px '.$this->opt['styles'][$set]['button_border_style'].' '.$this->opt['styles'][$set]['button_border_color'].$important.';
				display: inline-block'.$important.';
				background-size: '.$this->opt['styles'][$set]['follow_button_icon_size'].'px '.$this->opt['styles'][$set]['follow_button_icon_size'].'px'.$important.';
				background-repeat: no-repeat'.$important.';
				background-position: 5px center'.$important.';
				margin: '.$this->opt['styles'][$set]['button_margin'].'px'.$important.';
				box-shadow: none'.$important.';
				outline-style: none'.$important.';
			  
			  }			  
			  
			.cb_p2_social_share_link:link, .cb_p2_social_share_link:visited, .cb_p2_social_share_link:active 
			{
				color: '.$this->opt['styles'][$set]['button_link_color'].$important.';
				font-weight: '.$this->opt['styles'][$set]['button_font_weight'].$important.';
				box-shadow: none'.$important.';
				outline-style: none'.$important.';
			}
			.cb_p2_social_share_link:hover
			{
				background-color: '.$this->opt['styles'][$set]['button_hover_color'].$important.';
				box-shadow: none'.$important.';
				outline-style: none'.$important.';
			}
			.cb_p2_social_share_link:hover, .cb_p2_social_share_link:hover .cb_p2_social_share_link_text
			{
				text-decoration: '.$this->opt['styles'][$set]['button_hover_text_decoration'].$important.';
				color: '.$this->opt['styles'][$set]['button_link_hover_color'].$important.';
				box-shadow: none'.$important.';
				outline-style: none'.$important.';
			}
			
			
			';
						
			echo '</style>';
	}
	public function load_set_to_edit_p() {
	
		// Loads an icon set to edit its styles.
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
		
		$requested_set = $_REQUEST['cb_p2_selected_set'];
		
		
		wp_die();
		
	
	}
	public function activate_style_p() {
	
		// Sets a style as the active one
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
		
		$message = '<div class="cb_p2_processing_message">Sorry - could not activate the style...</div>';
		
		if ( isset( $_REQUEST['cb_p2_selected_style'] ) AND array_key_exists( $_REQUEST['cb_p2_selected_style'],$this->opt['styles']) ) {
			
			$this->opt['style_set'] = $_REQUEST['cb_p2_selected_style'];
			$this->update_opt();
			$message = '<div class="cb_p2_processing_message">Activated! Please make sure to refresh your site\'s cache! This page will refresh in 5 seconds.</div>';
		}
		
		echo $message;
		
		wp_die();
		
	
	}
	public function change_option_from_ajax_p() {
	
		// Sets a style as the active one
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}

		$message = 'Sorry - could not change the option...';
		
		if ( isset( $_REQUEST['cb_p2_option'] ) AND isset( $_REQUEST['cb_p2_option_value'] ) ) {
			
			$this->opt[$_REQUEST['cb_p2_option']] = $_REQUEST['cb_p2_option_value'];
			$this->update_opt();
			$message = 'Option updated!';
		}
		
		echo $message;
		
		wp_die();
		
	
	}
	public function social_network_add_update_p() {
	
		// Adds/updates social network
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}

		$unparsed_data = $_POST['data'];
		parse_str($unparsed_data,$parsed_social_network);
		
	
		foreach ( $parsed_social_network as $key => $value ) {
			// Snip prefix
			$new_key = str_replace('cb_p2_','',$key);
			$social_network[$new_key]=$parsed_social_network[$key];
		}
		
		// If no key, abort

		
		if ( $social_network['existing_network_id'] == 'add_new' AND $social_network['id'] == '' ) {
			echo '<div class="cb_p2_processing_message">Sorry - network id is required...</div>';
			wp_die();
		}

		if ( !ctype_lower( $social_network['existing_network_id'] ) AND !ctype_lower( $social_network['id']) ) {
			echo '<div class="cb_p2_processing_message">Sorry - network id needs to be all lowercase and only letters....</div>';
			wp_die();
		}
		
		if ( !isset( $social_network['id'] ) OR $social_network['id'] == '' ) {
			$social_network['id'] = $social_network['existing_network_id'];
		}
		unset($social_network['existing_network_id']);
		// If it is an existing network, dont change the id.
		
		$this->opt['social_networks'][$social_network['id']] = $social_network;
		
		// Always unset 'add_new' network if it was ever added:
		
		unset($this->opt['social_networks']['add_new']);
		unset($this->opt['social_networks']['']);
		
		$this->update_opt();
		
		echo '<div class="cb_p2_processing_message">Network updated!</div>';
		wp_die();
	
	}
	public function assign_style_to_post_type_p() {
	
		// Adds/updates social network
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}

		$unparsed_data = $_POST['data'];
		parse_str($unparsed_data,$parsed_form);
		
		if ( !isset( $parsed_form['selected_post_type']) OR !isset( $parsed_form['selected_style']) ) {
			echo '<div class="cb_p2_processing_message">Sorry - either post type or style is missing...</div>';
			wp_die();
		}

		$this->opt['post_types'][$parsed_form['selected_post_type']] = $parsed_form['selected_style'];
		
		$this->update_opt();
		
		echo '<div class="cb_p2_processing_message">Assigned post type to style</div>';
		wp_die();
	
	}
	public function save_style_p() {
	
		// Adds/updates social network
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}

		$unparsed_data = $_POST['data'];
		parse_str($unparsed_data,$parsed_style);
		
	
		foreach ( $parsed_style as $key => $value ) {
			// Snip prefix
			$new_key = str_replace('cb_p2_','',$key);
			$style[$new_key]=$parsed_style[$key];
		}
		
		
		$style_id = $style['style_id'];
		
		if ( $style_id == '' ) {
			echo '<div class="cb_p2_processing_message">Sorry - couldn\t determine which style you are saving...</div>';
			wp_die();
		}

		unset($style['style_id']);
		
		$message = 'Style updated!';

		// A more elegant solution can be arranged for the creation of new style ids later
		if ( $_REQUEST['cb_p2_save_type'] == 'new_style' ) {
			
			$max_custom = 7;
			
			foreach ( $this->opt['styles'] as $key => $value ) {
				
				if ( substr($key, 0 , 4 ) == 'set_' ) {
					// Custom style check max id
					$custom_id_count = str_replace( 'set_', '', $key );
					
					if( $custom_id_count > $max_custom ) {
						$max_custom = $custom_id_count;
					}
				
				}
			
			}
			
			$max_custom++;
			$style_id = 'set_'.$max_custom;
			$message = 'New style saved!';
			
			$this->lang['style_'.$style_id] = $_REQUEST['cb_p2_style_name'];

			update_option( $this->internal['prefix'].'lang_'.$this->opt['lang'], $this->lang );
		}
			
		
		$this->opt['styles'][$style_id] = $style;
		
		// A more elegant solution can be arranged for the creation of new style ids later
		if ( $_REQUEST['cb_p2_save_type'] == 'delete_style' ) {
						
			// Unset the style.
			
			unset($this->opt['styles'][$style_id]);
			
			unset($this->lang['style_'.$style_id]);
			
			
			update_option( $this->internal['prefix'].'lang_'.$this->opt['lang'], $this->lang );
			
			$message = 'Style deleted...';
		}			
		
		$this->update_opt();
		
		echo '<div class="cb_p2_processing_message">'.$message.'</div>';
		wp_die();
	
	}
	public function delete_social_network_p( ) {
		
		// Deletes a given social network
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
		
		if ( $_REQUEST[''] == '' AND $_REQUEST['cb_p2_network'] != ''  ) {
			
			unset( $this->opt['social_networks'][$_REQUEST['cb_p2_network']] );
			$this->update_opt();
			
		}
		
		echo '<div class="cb_p2_processing_message">Network deleted!</div>';
		
		if (defined('DOING_AJAX') && DOING_AJAX) {
			wp_die();
		}
	}
	public function social_network_edit_p( ) {
		
		// Loads social network for editing or loads a form for adding
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
				
		if ( $_REQUEST[$this->internal['prefix'].'network'] != '' ) {
			
			$network = $_REQUEST[$this->internal['prefix'].'network'];
		
		}
		
		if ( $network == '' ) {
			$network = 'add_new';
		}
		
		
		$social_network_edit_form = $this->load_template('social_network_edit_form');
		
		// If a new network is not being added, dont show the id box:
		
		$network_box = '
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_id%%%}</h4>
	<input type="text" name="{***prefix***}id" value="{***network_id***}" />';
		
		if ( $network != 'add_new' ) {
			$network_box = '';			
		}
		

		$vars = array( 
		
			'network_id_box' => $network_box,
		
		);


		// Set the network id box
		$social_network_edit_form = $this->process_vars_to_template($vars, $social_network_edit_form);
			
		
		$social_network_edit_form = $this->process_lang($social_network_edit_form);
			
		// Process the internal ids and replacements
			
		$social_network_edit_form = $this->process_vars_to_template($this->internal, $social_network_edit_form,array('prefix','id'));
		
		// Always reset 'add_new' network if it exists
		
		if ( isset( $this->opt['social_networks']['add_new'] ) ) {
			unset( $this->opt['social_networks']['add_new'] );
		}
		
		
		// Now set the other vars
		
		
		if ( isset( $this->opt['social_networks'][$network]['id'] ) ) {		
			$existing_network_id = $this->opt['social_networks'][$network]['id'];		
			$new_network_id = $this->opt['social_networks'][$network]['id'];		
		}
		
		// Make case for network id if it is a new network
		if ( $network == 'add_new' ) {
			$existing_network_id = 'add_new';			
			$new_network_id = '';			
		}
		
		$network_active='';
		$network_inactive='';
		
		if ( $this->opt['social_networks'][$network]['active'] == 'yes' ) {
			$network_active=' selected';
		}
		if ( $this->opt['social_networks'][$network]['active'] == 'no' ) {
			$network_inactive=' selected';
		}
			
		$social_network_active_selector = '<select name="cb_p2_active"><option value="yes" '.$network_active.'>Yes</option><option value="no" '.$network_inactive.'>No</option></select>';
		
		
		$vars=array(
			'network_name' => $this->opt['social_networks'][$network]['name'],
			'network_id' => $new_network_id,
			'text_before' => $this->opt['social_networks'][$network]['text_before'],
			'text_after' => $this->opt['social_networks'][$network]['text_after'],
			'icon' => $this->opt['social_networks'][$network]['icon'],
			'url' => $this->opt['social_networks'][$network]['url'],
			'social_network_active' => $social_network_active_selector,
			'follow' => $this->opt['social_networks'][$network]['follow'],
			'sort' => $this->opt['social_networks'][$network]['sort'],
			'existing_network_id' => strtolower($existing_network_id),
		);
		
		$social_network_edit_form = $this->process_vars_to_template($vars, $social_network_edit_form);
		
		echo $social_network_edit_form;
		wp_die();

	}
	public function make_style_editor_p() {
		
		// Makes social network selection list for admin
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
		
		$set = $this->opt['style_set'];
		if ( isset( $_REQUEST['cb_p2_set'] ) ) {
			$set = $_REQUEST['cb_p2_set'];
		}
		
		echo '<div id="cb_p2_style_editor_messages"></div><div id="cb_p2_style_editor_items"><form action="" id="cb_p2_style_editor_form" method="post">';
		
		// Icon properties
		
		echo '<div class="cb_p2_style_editor_item">';
		
		$icon_set_selection = array();
		foreach ( $this->opt['icon_sets'] as $key => $value ){

			$icon_set_selection[$this->opt['icon_sets'][$key]] = $this->lang[$this->opt['icon_sets'][$key]];
			
		}
		
		$networks_array = array();
		
		foreach ( $this->opt['social_networks'] as $key => $value ) {
			$networks_array[$key] = $key;
		}
		
		$extra_info = array(
		
			'icon_sets' => $this->opt['icon_sets'],
			'social_networks' => $networks_array,
			'plugin_url' => $this->internal['plugin_url'],
			
		);

		$args = array(
			'title' => 'Icon set',
			'desc' => 'Change the color of the button borders',
			'name' => 'icon_set',
			'input_id' => 'cb_p2_icon_set_selector',
			'input_class' => 'cb_p2_icon_set_selector',
			'selections' => $icon_set_selection,
			'value' => $this->opt['styles'][$set]['icon_set'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => '',
			'css_suffix' => '',	
			'extra_info' => base64_encode(json_encode($extra_info)),	
		
		);
		
		
		echo $this->make_style_editor_select_element($args);

		$icon_size_selection = array(
			
			'16' => '16',
			'20' => '20',
			'24' => '24',
			'28' => '28',
			'32' => '32',
			'36' => '36',
			'42' => '42',
			'48' => '48',
			'64' => '64',
		
		);
		
		$args = array(
			'title' => 'Icon size',
			'desc' => 'Change the color of the button borders',
			'name' => 'button_icon_size',
			'input_id' => 'cb_p2_button_icon_size_selector',
			'input_class' => 'cb_p2_button_icon_size_selector',
			'selections' => $icon_size_selection,
			'value' => $this->opt['styles'][$set]['button_icon_size'],
			'css_target_element' => '.cb_p2_social_share_link img',
			'css_rule' => 'width',
			'css_suffix' => 'px',
			'extra_info' => base64_encode(json_encode($extra_info)),	
		
		);
		
		
		echo $this->make_style_editor_select_element($args);

		
		$args = array(
			'title' => 'Icon spacing',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'button_icon_margin',
			'input_id' => 'cb_p2_style_editor_button_icon_margin',
			'slider_id' => 'cb_p2_value_slider_button_icon_margin',
			'min' => 0,
			'max' => 50,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['button_icon_margin'],
			'css_target_element' => '.cb_p2_social_share_item img',
			'css_rule' => 'margin',
			'css_suffix' => 'px',
			'size' => 2,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);
		
		echo '</div>';
			
		
		echo '<div class="cb_p2_style_editor_item">';
		

		$selections = array(
			'inline'  => 'Show',
			'none'  => 'Hide',
		
		);

		$args = array(
			'title' => 'Show button text',
			'desc' => 'Change the color of the button borders',
			'name' => 'button_text_display',
			'input_id' => 'cb_p2_style_editor_button_text_display',
			'selections' => $selections,
			'value' => $this->opt['styles'][$set]['button_text_display'],
			'css_target_element' => '.cb_p2_social_share_link_text',
			'css_rule' => 'display',
			'css_suffix' => '',	
		
		);
		
		echo $this->make_style_editor_select_element($args);			
		
		$args = array(
			'title' => 'Button text size',
			'desc' => 'Controls the font size on the buttons',
			'name' => 'button_font_size',
			'input_id' => 'cb_p2_style_editor_button_font_size',
			'slider_id' => 'cb_p2_value_slider_1',
			'min' => 1,
			'max' => 64,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['button_font_size'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => 'font-size',
			'css_suffix' => 'px',
			'size' => 1,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);
		

		$args = array(
			'title' => 'Button text color',
			'desc' => 'Change the color of the button text',
			'name' => 'button_link_color',
			'input_id' => 'cb_p2_style_editor_button_link_color',
			'value' => $this->opt['styles'][$set]['button_link_color'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => 'color',
			'css_suffix' => '',
			'size' => 1,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_color_element($args);
	
		$args = array(
			'title' => 'Button text hover color',
			'desc' => 'Change the color of the button text',
			'name' => 'button_link_hover_color',
			'input_id' => 'cb_p2_style_editor_button_link_hover_color',
			'value' => $this->opt['styles'][$set]['button_link_hover_color'],
			'css_target_element' => '.cb_p2_social_share_link:hover',
			'css_rule' => 'color',
			'css_suffix' => '',
			'size' => 1,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_color_element($args);	


		$args = array(
			'title' => 'Button text boldness',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'button_font_weight',
			'input_id' => 'cb_p2_style_editor_button_button_font_weight',
			'slider_id' => 'cb_p2_value_slider_3',
			'min' => 100,
			'max' => 900,
			'step' => 100,
			'value' => $this->opt['styles'][$set]['button_font_weight'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => 'font-weight',
			'css_suffix' => '',
			'size' => 3,
			'maxlength' => 3
		
		);
		
		echo $this->make_style_editor_slider_element($args);


		$selections = array(
			'underline'  => 'Underline',
			'overline'  => 'Overline',
			'line-through' => 'Line-through',
			'none' => 'None',
		
		);

		$args = array(
			'title' => 'Button text decoration',
			'desc' => 'Change the color of the button borders',
			'name' => 'button_text_decoration',
			'input_id' => 'cb_p2_style_editor_button_text_decoration',
			'selections' => $selections,
			'value' => $this->opt['styles'][$set]['button_text_decoration'],
			'css_target_element' => '.cb_p2_social_share_link_text',
			'css_rule' => 'text-decoration',
			'css_suffix' => '',	
		
		);
		
		echo $this->make_style_editor_select_element($args);		
		
		$args = array(
			'title' => 'Button hover text decoration',
			'desc' => 'Change the color of the button borders',
			'name' => 'button_hover_text_decoration',
			'input_id' => 'cb_p2_style_editor_button_hover_text_decoration',
			'input_class' => 'cb_p2_style_editor_button_hover_text_decoration',
			'selections' => $selections,
			'value' => $this->opt['styles'][$set]['button_hover_text_decoration'],
			// We target the below properties with jQuery on change in vain, because jquery doesnt manipulate psuedo elements. But they are here to make the change go dud.
			'css_target_element' => '.cb_p2_social_share_link_text:hover',
			'css_rule' => 'text-decoration',
			'css_suffix' => '',	
		
		);
		
		echo $this->make_style_editor_select_element($args);		
		
		echo '</div>';
		echo '<div class="cb_p2_style_editor_item">';
		
		$args = array(
			'title' => 'Button border size',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'button_border_thickness',
			'input_id' => 'cb_p2_style_editor_button_border_thickness',
			'slider_id' => 'cb_p2_value_slider_2',
			'min' => 0,
			'max' => 10,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['button_border_thickness'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => 'border-width',
			'css_suffix' => 'px',
			'size' => 1,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);
		

		$args = array(
			'title' => 'Button border color',
			'desc' => 'Change the color of the button borders',
			'name' => 'button_border_color',
			'input_id' => 'cb_p2_style_editor_button_border_color',
			'value' => $this->opt['styles'][$set]['button_border_color'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => 'border-color',
			'css_suffix' => '',
			'size' => 1,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_color_element($args);	
		
		$selections = array(
			'solid'  => 'Solid',
			'dotted' => 'Dotted',
			'dashed' => 'Dashed',
			'double' => 'Double',
			'groove' => 'Groove',
			'ridge' => 'Ridge',
			'inset' => 'Inset',
			'outset' => 'Outset',
			'none' => 'None',
			'hidden' => 'Hidden',
		
		);

		$args = array(
			'title' => 'Button border style',
			'desc' => 'Change the color of the button borders',
			'name' => 'button_border_style',
			'input_id' => 'cb_p2_style_editor_button_border_style',
			'selections' => $selections,
			'value' => $this->opt['styles'][$set]['button_border_style'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => 'border-style',
			'css_suffix' => '',	
		
		);
		
		echo $this->make_style_editor_select_element($args);
		
		$args = array(
			'title' => 'Rounded button corners',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'button_border_radius',
			'input_id' => 'cb_p2_style_editor_button_border_radius',
			'slider_id' => 'cb_p2_value_slider_button_border_radius',
			'min' => 0,
			'max' => 50,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['button_border_radius'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => 'border-radius',
			'css_suffix' => 'px',
			'size' => 2,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);
			
		
		echo '</div>';
		
		// Button properties
		
		
		echo '<div class="cb_p2_style_editor_item">';
		
		
		$args = array(
			'title' => 'Button background color',
			'desc' => 'Change the background color of the buttons',
			'name' => 'button_background_color',
			'input_id' => 'cb_p2_style_editor_button_background_color',
			'value' => $this->opt['styles'][$set]['button_background_color'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => 'background-color',
			'css_suffix' => '',
			'size' => 1,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_color_element($args);
		
		$args = array(
			'title' => 'Button hover color',
			'desc' => 'Change the background color of the buttons',
			'name' => 'button_hover_color',
			'input_id' => 'cb_p2_style_editor_button_hover_color',
			'value' => $this->opt['styles'][$set]['button_hover_color'],
			'css_target_element' => '.cb_p2_social_share_link:hover',
			'css_rule' => '',
			'css_suffix' => '',
			'size' => 1,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_color_element($args);
		

		$args = array(
			'title' => 'Button spacing',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'button_margin',
			'input_id' => 'cb_p2_style_editor_button_button_margin',
			'slider_id' => 'cb_p2_value_slider_button_margin',
			'min' => 0,
			'max' => 50,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['button_margin'],
			'css_target_element' => '.cb_p2_social_share_item',
			'css_rule' => 'margin',
			'css_suffix' => 'px',
			'size' => 2,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);

		$args = array(
			'title' => 'Extra button width',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'button_extra_padding',
			'input_id' => 'cb_p2_style_editor_button_extra_padding',
			'slider_id' => 'cb_p2_value_slider_button_margin',
			'min' => 0,
			'max' => 300,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['button_extra_padding'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => '',
			'css_suffix' => 'px',
			'size' => 2,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);

		$args = array(
			'title' => 'Button internal spacing',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'button_padding',
			'input_id' => 'cb_p2_style_editor_button_padding',
			'slider_id' => 'cb_p2_value_slider_button_padding',
			'min' => 0,
			'max' => 50,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['button_padding'],
			'css_target_element' => '.cb_p2_social_share_link',
			'css_rule' => 'padding',
			'css_suffix' => 'px',
			'size' => 2,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);
		
		echo '</div>';
		
		// Container properties
		
		echo '<div class="cb_p2_style_editor_item">';
		
		
		$args = array(
			'title' => 'Container background color',
			'desc' => 'Change the background color of the buttons',
			'name' => 'container_background_color',
			'input_id' => 'cb_p2_style_editor_container_background_color',
			'value' => $this->opt['styles'][$set]['container_background_color'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'background-color',
			'css_suffix' => '',
			'size' => 1,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_color_element($args);
		


		$args = array(
			'title' => 'Container max width',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'container_max_width',
			'input_id' => 'cb_p2_style_editor_container_max_width',
			'slider_id' => 'cb_p2_value_slider_container_max_width',
			'min' => 10,
			'max' => 2000,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['container_max_width'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'max-width',
			'css_suffix' => 'px',
			'size' => 2,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);		
		

		$args = array(
			'title' => 'Container spacing',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'container_margin',
			'input_id' => 'cb_p2_style_editor_container_margin',
			'slider_id' => 'cb_p2_value_slider_container_margin',
			'min' => 0,
			'max' => 70,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['container_margin'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'margin',
			'css_suffix' => 'px',
			'size' => 2,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);

		$args = array(
			'title' => 'Container internal spacing',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'container_padding',
			'input_id' => 'cb_p2_style_editor_container_padding',
			'slider_id' => 'cb_p2_value_slider_container_padding',
			'min' => 0,
			'max' => 70,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['container_padding'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'padding',
			'css_suffix' => 'px',
			'size' => 2,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);
		
		echo '</div>';
		
		// Container border 
		
		echo '<div class="cb_p2_style_editor_item">';
		
		
		$args = array(
			'title' => 'Container border size',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'container_border_thickness',
			'input_id' => 'cb_p2_style_editor_container_border_thickness',
			'slider_id' => 'cb_p2_value_slider_container_border_thickness',
			'min' => 0,
			'max' => 10,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['container_border_thickness'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'border-width',
			'css_suffix' => 'px',
			'size' => 1,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);
		

		$args = array(
			'title' => 'Container border color',
			'desc' => 'Change the color of the button borders',
			'name' => 'container_border_color',
			'input_id' => 'cb_p2_style_editor_container_border_color',
			'value' => $this->opt['styles'][$set]['container_border_color'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'border-color',
			'css_suffix' => '',
			'size' => 1,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_color_element($args);	
		
		$selections = array(
			'left'  => 'Left',
			'center' => 'Center',
			'right' => 'Right',
		
		);

		$args = array(
			'title' => 'Container alignment',
			'desc' => 'Change the alignment of container',
			'name' => 'button_container_text_align',
			'input_id' => 'cb_p2_style_editor_button_container_text_align',
			'selections' => $selections,
			'value' => $this->opt['styles'][$set]['button_container_text_align'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'text-align',
			'css_suffix' => '',	
		
		);
		
		echo $this->make_style_editor_select_element($args);
		
		$selections = array(
			'solid'  => 'Solid',
			'dotted' => 'Dotted',
			'dashed' => 'Dashed',
			'double' => 'Double',
			'groove' => 'Groove',
			'ridge' => 'Ridge',
			'inset' => 'Inset',
			'outset' => 'Outset',
			'none' => 'None',
			'hidden' => 'Hidden',
		
		);

		$args = array(
			'title' => 'Container border style',
			'desc' => 'Change the color of the button borders',
			'name' => 'container_border_style',
			'input_id' => 'cb_p2_style_editor_container_border_style',
			'selections' => $selections,
			'value' => $this->opt['styles'][$set]['container_border_style'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'border-style',
			'css_suffix' => '',	
		
		);
		
		echo $this->make_style_editor_select_element($args);
		
		$args = array(
			'title' => 'Container rounded corners',
			'desc' => 'Controls the border thickness of the buttons',
			'name' => 'container_border_radius',
			'input_id' => 'cb_p2_style_editor_container_border_radius',
			'slider_id' => 'cb_p2_value_slider_container_border_radius',
			'min' => 0,
			'max' => 50,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['container_border_radius'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'border-radius',
			'css_suffix' => 'px',
			'size' => 2,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);		
		
		echo '</div>';
		
		echo '<div class="cb_p2_style_editor_item">';
		
		
		$selections = array(
			'yes'  => 'Yes',
			'no' => 'No',
		
		);

		$args = array(
			'title' => 'Make shares sticky',
			'desc' => 'Yes makes shares sticky when scrolled - recommended',
			'name' => 'container_wrapper_sticky',
			'input_id' => 'cb_p2_style_editor_button_container_wrapper_sticky',
			'selections' => $selections,
			'value' => $this->opt['styles'][$set]['container_wrapper_sticky'],
			'css_target_element' => '',
			'css_rule' => '',
			'css_suffix' => '',	
		
		);
		
		echo $this->make_style_editor_select_element($args);
		
		
		$args = array(
			'title' => 'Top margin for sticky share',
			'desc' => 'The space from top when the share is sticky',
			'name' => 'container_wrapper_sticky_top_margin',
			'input_id' => 'cb_p2_style_editor_container_wrapper_sticky_top_margin',
			'slider_id' => 'cb_p2_value_slider_container_wrapper_sticky_top_margin',
			'min' => 0,
			'max' => 200,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['container_wrapper_sticky_top_margin'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'top',
			'css_suffix' => 'px',
			'size' => 1,
			'maxlength' => 3		
		
		);
		
		echo $this->make_style_editor_slider_element($args);
		

		$args = array(
			'title' => 'Container wrapper max width',
			'desc' => 'Controls width of the space that wraps the container',
			'name' => 'container_wrapper_width',
			'input_id' => 'cb_p2_style_editor_container_wrapper_max_width',
			'slider_id' => 'cb_p2_value_slider_container_wrapper_max_width',
			'min' => 10,
			'max' => 2000,
			'step' => 1,
			'value' => $this->opt['styles'][$set]['container_wrapper_max_width'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'max-width',
			'css_suffix' => 'px',
			'size' => 2,
			'maxlength' => 2		
		
		);
		
		echo $this->make_style_editor_slider_element($args);
		

		$selections = array(
			'left'  => 'Left',
			'center' => 'Center',
			'right' => 'Right',
		
		);

		$args = array(
			'title' => 'Container wrapper text alignment',
			'desc' => 'Change the alignment of items inside wrapper',
			'name' => 'container_wrapper_text_align',
			'input_id' => 'cb_p2_style_editor_button_container_wrapper_text_align',
			'selections' => $selections,
			'value' => $this->opt['styles'][$set]['container_wrapper_text_align'],
			'css_target_element' => '.cb_p2_social_share',
			'css_rule' => 'text-align',
			'css_suffix' => '',	
		
		);
		
		echo $this->make_style_editor_select_element($args);		
		
		
		echo '</div>';
		
		echo '<input type="hidden" name="style_id" value="'.$set.'" />';
		echo '</div></form>';
		
	}
	public function make_style_editor_select_element_p($args) {
	
		$element = '';
		
		$input_class = 'cb_p2_select_input';
		$extra_info = '';
		
		if ( isset( $args['input_class'] ) ) {
			$input_class = $args['input_class'];
		}
		if ( isset( $args['extra_info'] ) ) {
			$extra_info = $args['extra_info'];
		}
	
		$element .= '<div class="cb_p2_style_editor_item_label" for="'.$args['input_id'].'">'.$args['title'].'</div>
			<select name="'.$args['name'].'" id="'.$args['input_id'].'" class="'.$input_class.'" css_target_element="'.$args['css_target_element'].'" css_rule="'.$args['css_rule'].'" css_suffix="'.$args['css_suffix'].'" extra_info="'.$extra_info.'">';
			
		foreach($args['selections'] as $key => $value){
			
			$selected = '';
			
			if($key == $args['value']) {
				$selected = ' selected';
			}
			
			$element .= '<option value="'.$key.'"'.$selected.'>'.$args['selections'][$key].'</option>';
			
		}	
			
		$element .= '</select>';
		
		return $element;
		
	}
	public function make_style_editor_slider_element_p($args) {
		
		$element = '';
	
		$element .= '<div class="cb_p2_style_editor_item_label" for="'.$args['input_id'].'">'.$args['title'].'</div>
			<input type="text" name="'.$args['name'].'" id="'.$args['input_id'].'" class="cb_p2_slider_input_value" value="'.$args['value'].'" min="'.$args['min'].'" max="'.$args['max'].'" step="'.$args['step'].'" css_target_element="'.$args['css_target_element'].'" css_rule="'.$args['css_rule'].'" css_suffix="'.$args['css_suffix'].'" parent_slider="'.$args['slider_id'].'" size="'.$args['size'].'" maxlength="'.$args['maxlength'].'" /> px
			<br />
			<br />
			<div class="cb_p2_value_slider" id="'.$args['slider_id'].'" slider_value_target="'.$args['input_id'].'"></div>';
		
		return $element;
	}
	public function make_style_editor_color_element_p($args) {
		
		$element = '';
		
		
		$element .= '<div class="cb_p2_style_editor_item_label" for="'.$args['input_id'].'">'.$args['title'].'</div>
			<input class="cb_p2_color_picker" id="'.$args['input_id'].'" type="text" name="'.$args['name'].'" value="'.$args['value'].'"  css_target_element="'.$args['css_target_element'].'" css_rule="'.$args['css_rule'].'" css_suffix="'.$args['css_suffix'].'" />';
		
		return $element;
	}
	public function refresh_post_to_style_assignments_div_p() {
		
		// Makes social network selection list for admin
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}


		$post_types = get_post_types();
		$select='';
		$current_post_types='';
		$shown = 'default';
		foreach($post_types as $key => $value)
		{
			$obj=get_post_type_object($key);
			$select.='<option value="'.$key.'">'.$obj->labels->singular_name.'</option>';
			
			if ( !isset( $this->opt['post_types'][$key] ) ) {
				continue;
			}
			
			$obj=get_post_type_object($key);
			$current_post_types .= $obj->labels->name.':<br>'.$this->lang['style_'.$this->opt['post_types'][$key]];
			$current_post_types .= '<br><br>';
		}
		
		echo 'Current post types to styles - for any post type that is not listed, default applies<br><br><b>'.substr($current_post_types,0,-2).'</b>';
	
		if (defined('DOING_AJAX') && DOING_AJAX) {
			wp_die();
		}
	}
	public function make_social_network_list_p() {
		
		// Makes social network selection list for admin
		
		if ( !current_user_can( 'manage_options' ) ) {
			return;
		}
		
		echo '<div class="'.$this->internal['prefix'].'social_network_edit_wrapper">';

		foreach ( $this->opt['social_networks'] as $key => $value ) {
			
			if( $this->opt['social_networks'][$key]['id'] =='' ) {
				continue;
			}
			
			$icon_url = $this->internal['plugin_url'].'plugin/images/set_1/'.$key.'/20.png';
			
			if ( $this->opt['social_networks'][$key]['icon'] != 'default' ) {
				$icon_url = $this->opt['social_networks'][$key]['icon'];
			}
			
			echo '<div class="'.$this->internal['prefix'].'social_network_edit_button '.$this->internal['prefix'].'social_network_edit" target="'.$this->internal['prefix'].'network_editor" network="'.$key.'"><img src="'. $icon_url . '" style="width:20px; height:20px;" />'.$this->opt['social_networks'][$key]['name'].'</div>';
			
			 
		}

		echo '<div class="'.$this->internal['prefix'].'social_network_edit_button '.$this->internal['prefix'].'social_network_edit" target="'.$this->internal['prefix'].'network_editor" network="add_new"><img src="'.$this->internal['plugin_url'].'plugin/images/set_1/add_network.png" class="cb_p2_icon_'.$key.'" style="width:20px; height:20px;" />Add New</div>';
		
		echo '</div>';
		if (defined('DOING_AJAX') && DOING_AJAX) {
			wp_die();
		}
	}
	
	public function check_for_update($checked_data) 
	{
			global $wp_version, $plugin_version, $plugin_base;
		
			if ( empty( $checked_data->checked ) ) {
				return $checked_data;
			}

			if(isset($checked_data->response[$this->internal['plugin_id'].'/index.php']) AND version_compare( $this->internal['version'], $checked_data->response[$this->internal['plugin_id'].'/index.php']->new_version, '<' ))
			{

				// place update link into update lang string :
		
				$update_link = $this->process_vars_to_template(array('plugin_update_url'=>$this->internal['plugin_update_url']),$this->lang['update_available']);

				$this->queue_notice($update_link,'info','update_available','perma',true);		
			}
			return $checked_data;
		
	}	
}

$cb_p2 = cb_p2_plugin::get_instance();

function cb_p2_get()
{

	// This function allows any plugin to easily retieve this plugin object
	return cb_p2_plugin::get_instance();

}