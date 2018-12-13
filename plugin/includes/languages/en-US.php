<?php


$lang = array(
	'lang' => 'en-US',
	'current_lang_label' => 'English (US)',
	'labelcontinue' => 'Continue',
	'plugin_name' => 'Fast Social Share',
	'success_language_operation_successful' => 'Language operation was successful',
	'save' => 'Save',
	'change_license' => 'Update',
	'plugin_is_almost_ready' => 'is almost ready!',
	'plugin_is_ready' => 'is now ready!',
	'setup_wizard_keep_in_touch' => 'Keep in touch with us below for info on new features, updates, security and bugfixes',
	'setup_wizard_follow_us_on_twitter' => 'Follow us on Twitter',
	'setup_wizard_twitter_follow_label_prefix' => 'Follow',
	'setup_wizard_join_list' => 'Join our Newsletter',
	'setup_wizard_join_mailing_list_link_label' => 'Subscribe',
	'setup_read_quickstart_guide' => 'Read Quickstart Guide',
	'manual_link_label' => 'Read the Manual' ,
	'admin_menu_label' => 'Fast Social Share',
	'admin_tab_dashboard' => 'Dashboard',
	'admin_tab_social_networks' => 'Social Networks',
	'admin_tab_customize_design' => 'Customize Design',
	'admin_tab_sidebar_widgets' => 'Sidebar Widgets',
	'admin_tab_general' => 'General',
	'admin_tab_addons' => 'Addons',
	'admin_tab_support' => 'Support',
	'admin_tab_general' => 'General',
	'admin_page_support_title' => 'Support',
	'admin_page_support_explanation' => 'You can get support from ',
	'admin_tab_extras' => 'Extras',
	'admin_tab_dashboard_general' => 'General',
	'admin_tab_dashboard_general_magical' => 'Magical',
	'admin_tab_dashboard_general_super' => 'Super',
	'admin_tab_dashboard_tickets' => 'Tickets',
	'admin_tab_departments_general' => 'General 2',
	'admin_tab_departments_general_magical' => 'Magical 2',
	'admin_tab_departments_general_super' => 'Super 2',
	'admin_tab_departments_tickets' => 'Tickets 2',
	'admin_tab_languages' => 'Languages',	
	'setup_read_manual' => 'Check out the manual',	
	'error_operation_failed_no_permission' => 'Sorry. You don\'t have the necessary permission to perform this operation',
	'add_edit_button_label' => 'Add/Edit',
	'set_language_button_label' => 'Set Language',
	'reset_languages_button_label' => 'Reset Languages',
	'admin_title_choose_reset_language' => 'Choose Language or Reset languages',
	'admin_title_modify_current_language' => 'You can modify current language\'s translations below',
	'error_language_operation_failed' => 'Sorry... Language operation failed...',
	'success_language_operation_successful' => 'Great! Language operation was successful!',
	'info_language_is_already_active' => 'Language you selected is the already active language',
	'error_updating_one_of_the_languages_failed' => 'Update of one of the languages failed...',
	'success_language_translation_saved' => 'Language translation was successfully saved!',
	'error_language_translation_no_save' => 'Sorry. Couldn\'t save language translation...',
	'info_language_is_already_same_with_saved' => 'Saved translation is exactly the same with the one in database',
	'info_active_language_updated' => 'Active language updated to saved values',
	'toggle_to_view_edit_current_language' => 'Click to view/edit existing language\'s translation',

	'month_01' => 'January' ,
	'month_02' => 'February' ,
	'month_03' => 'March' ,
	'month_04' => 'April' ,
	'month_05' => 'May' ,
	'month_06' => 'June' ,
	'month_07' => 'July' ,
	'month_08' => 'August' ,
	'month_09' => 'September' ,
	'month_10' => 'October' ,
	'month_11' => 'November' ,
	'month_12' => 'December' ,
	
	'label_start_date_month' => 'Start Month' ,
	'label_end_date_month' => 'End Month' ,
	'day' => 'Day' ,
	'month' => 'Month' ,
	'year' => 'Year' ,
	'date' => 'Date' ,
	'start_date' => 'Starting From' ,
	'end_date' => 'Until' ,
	
	'required_plugins_missing' => '<h2>'.$this->internal['plugin_name'].' configuration incomplete!</h2>At least one plugin in the package is not installed, inactive or the wrong version. This will prevent '.$this->internal['plugin_name'].' from working. Please visit the wizard to get more information and auto-fix:<br>
	<form method="post" action="'.$this->internal['admin_url'].'admin.php?page=setup_wizard_'.$this->internal['id'].'">
	<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Go to the Wizard"></p></form>',
	
	'setup_not_complete' => '<h2>'.$this->internal['plugin_name'].' setup incomplete!</h2>Please resume the setup wizard to complete configuration of the plugin:
	<form method="post" action="'.$this->internal['admin_url'].'admin.php?page=setup_wizard_'.$this->internal['id'].'">
	<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Go to the Wizard"></p>
	</form>',
	
	'setup_now_you_can' => 'Now if you want, you can...',
	'setup_read_manual' => 'Read the Manual',
	'setup_change_settings' => 'Adjust settings',
	
	#MARKER
	'social_networks' => 'Social Networks',
	'social_networks_name' => 'Social Network Name',
	'social_networks_id' => 'Id ( a simple word with all lowercase letters )',
	'social_networks_text_before' => 'Text to show before the network icon. Generally not necessary',
	'social_networks_text_after' => 'Text to show after the network icon. Like, "Share on Facebook", or "Tweet" (for twitter)',
	'social_networks_url' => 'The GET share URL of the social network',
	'social_networks_icon' => 'The icon for the social network',
	'social_networks_active' => 'Social network active/inactive. Inactive networks won\'t be shown in the share buttons list',
	'social_networks_follow' => 'Follow URL of your account at the social network, if it exists',
	'social_networks_sort' => 'Sort order of the social network. Smaller numbers will show up before bigger numbers',
	'social_networks_select_network' => 'Select Social Network to edit',
	
	'style_set_1' => 'Super One',
	'style_set_2' => 'Diagnotico',
	'style_set_3' => 'Avatar S',
	'style_set_4' => 'Pink',
	'style_set_5' => 'Nori-Nori San',
	'style_set_6' => 'Elemental',
	'style_set_default' => 'Selected default style',
	'style_default' => 'Selected default style',
	'style_none' => 'No social share shown',
	
	'set_1' => 'Icon set 1',
	'set_2' => 'Icon set 2',
	'set_3' => 'Icon set 3',
	'set_4' => 'Icon set 4',
	'set_5' => 'Icon set 5',
	'set_6' => 'Icon set 6',
	
	 
	'extras_join_affiliates_title' => 'Work with us',
	'extras_join_affiliates_explanation' => 'Partner with us in our affiliate program and receive 70% of initial sale and up to 20% recurring commissions for promoting our software',
	'admin_page_affiliate_link_label' => 'Click here for details',
	'admin_rapier_title' => 'Rapier WordPress Theme',
	'view_all_tickets_label' => 'All Tickets',
	'previous_page_url_label' => 'Click here',
	'newsletter_link' => 'https://zortzort.us9.list-manage.com/subscribe?u=5afbc1be9f2ed76070f4b64fd&id=25287e5ddb',
	'tell_your_friends' => 'Tell your friends!',
	'tweet_the_plugin' => 'http://twitter.com/intent/tweet?url=https%3A%2F%2Fwordpress.org%2Fplugins%2Ffast-social-share-by-codebard&text=Fast%20Custom%20Social%20Share%20is%20a%20great%20way%20to%20add%20social%20buttons%20to%20your%20WordPress%20site!%20&via=codebardcom&hashtags=wordpress,social,share',

	'admin_rapier_info' => 'A very fast, HTML5, Responsive theme from CodeBard. Rapier has page load speeds as low as 1.5 seconds, which is very good for SEO and user experience.',
	'admin_rapier_link_text' => 'More info, demo and download here',
	
	
	'news_and_info_title' => 'News & Info',
	'news_and_info_title_explanation' => 'Receive news, notifications, info regarding this and other CodeBard Plugins & Themes:',
	'join_mailing_list_link' => 'Join CodeBard News List here',
	'admin_page_support_link' => 'our help desk by clicking here',

);





?>