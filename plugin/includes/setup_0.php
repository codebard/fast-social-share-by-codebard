<br /><br /><div class="cb_p2_install_plugins_vector"><img src="<?php echo $this->internal['plugin_url'] ?>images/Install-0.png" border="0" /></div><?php

?>
<h1 class="cb_p2_setup_wizard_heading">Let's get started!</h1>

<div class="cb_p2_setup_wizard_text">Choose a social share style that you like. Customize the design if you wish!</div>

<?php


echo $this->make_design_selector_for_setup_wizard();

echo '';

// Check if a bg color for active theme can be acquired

$background_color = get_background_color();

if ($background_color != '' ) {
	
	$set_wrapper_bg = ' background-color: #'.$background_color.';"';
	
}
echo '<div id="cb_p2_selector_messages"></div>';
echo '<div id="cb_p2_style_editor_buttons_wrapper"'.$set_wrapper_bg.'>';

echo $this->add_post_buttons();

echo '</div>';


echo '<div id="cb_p2_customize_style_info"><h1>Customize this style if you wish!</h2><p>You can always do this whenever you want from the "Customize Design" tab of your plugin settings</p><p><div class="cb_p2_save_style_details_button cb_p2_general_wizard_button" id="cb_p2_customize_style_save_button1" save_type="same_style">Save this style</div></p></div>';

echo $this->make_style_editor();


?></center>

<div id="cb_p2_new_style_dialog"><form id="cb_p2_new_style_dialog_form" action="" method="post"><br><label>Type a name for new style</label><br><br><input type="text" name="cb_p2_new_style_name" id="cb_p2_new_style_name" /><br><br><div class="cb_p2_save_style_details_button cb_p2_general_wizard_button" id="cb_p2_new_style_dialog_form_submit" save_type="new_style">Go ahead and save</div><br><br></div>

