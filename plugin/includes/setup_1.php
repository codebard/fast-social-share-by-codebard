<br /><br /><div class="cb_p2_install_plugins_vector"><img src="<?php echo $this->internal['plugin_url'] ?>images/Install-Final.png" border="0" /></div><?php

if ( isset($_REQUEST['cb_p2_selected_style_at_setup'] ) AND array_key_exists($_REQUEST['cb_p2_selected_style_at_setup'],$this->opt['styles'] ) ) {

	$this->opt['style_set'] = $_REQUEST['cb_p2_selected_style_at_setup'];
	$this->update_opt();
}

?>

<div class="<?php echo $this->internal['prefix'];?>settings">

	<h1 class="cb_p2_setup_wizard_heading"><?php echo $this->internal['plugin_name']; ?> is ready!</h1>
	
	<div class="cb_p2_setup_wizard_text">We successfully set up <?php echo $this->internal['plugin_name']; ?>! You are good to go!</div>
	<button class="cb_p2_admin_button" style="width:auto;height: 40px;vertical-align : top;margin-top:10px;" onclick="window.open('https://codebard.com/fast-custom-social-share-documentation');" target="_blank"><?php echo $this->lang['manual_link_label'];?></button>
	<button class="cb_p2_admin_button" style="width:auto;height: 40px;vertical-align : top;margin-top:10px;" onclick="window.open('<?php echo $this->lang['tweet_the_plugin']; ?>');" target="_blank">Tweet & Recommend</button>

	<hr width="100%" />
	<h2>Empower your site with our other plugins!</h2>
	<div class="cb_p2_plugin_insert">
	<a href="https://codebard.com/patron-plugin-pro" target="_blank"><img src="<?php echo $this->internal['plugin_url'] ?>plugin/images/Patron-Plugin-Pro-200.png" /></a>
	<h4 class="cb_p2_plugin_title">Patron Plugin Pro</h4>
	Connect your site to Patreon and make monthly revenue
	<br><br>
	<a href="https://codebard.com/patron-plugin-pro" target="_blank">Read details and see demo here</a>
	<br><br>
	</div>
	<div class="cb_p2_plugin_insert">
	<a href="https://codebard.com/codebard-help-desk-woocommerce-integration" target="_blank"><img src="<?php echo $this->internal['plugin_url'] ?>plugin/images/WooCommerce-Help-Desk-200.png" /></a>
	<h4 class="cb_p2_plugin_title">WooCommerce<br>Help Desk</h4>
	Provide integrated support to your customers from your WooCommerce store
	<br><br>
	<a href="https://codebard.com/codebard-help-desk-woocommerce-integration" target="_blank">Read details and see demo here</a>
	<br><br>
	</div>
	<div class="cb_p2_plugin_insert">
	<a href="https://codebard.com/codebard-help-desk-for-wordpress" target="_blank"><img src="<?php echo $this->internal['plugin_url'] ?>plugin/images/CodeBard-Help-Desk-for-WordPress-200.png" /></a>
	<h4 class="cb_p2_plugin_title">CodeBard<br>Help Desk</h4>
	Customer help desk system for your WordPress site
	<br><br>
	<a href="https://codebard.com/codebard-help-desk-for-wordpress" target="_blank">Read details and see demo here</a>
	<br><br>
	</div>
	
	
	
	<hr width="100%" />
	<div class="cb_p2_setup_wizard_one_col" style="max-width : 600px;">
	<!-- Begin Mailchimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	/* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="https://zortzort.us9.list-manage.com/subscribe/post?u=5afbc1be9f2ed76070f4b64fd&amp;id=25287e5ddb" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	<h2>Join Fast Custom Social Share mailing list to get notified of updates and info</h2>
<div class="mc-field-group">
	<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
</label>
	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_5afbc1be9f2ed76070f4b64fd_25287e5ddb" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>
</div>
<!--End mc_embed_signup-->
	

	
	
<?php


?>