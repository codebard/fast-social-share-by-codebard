<br /><br /><div class="cb_p2_install_plugins_vector"><img src="<?php echo $this->internal['plugin_url'] ?>images/Install-0.png" border="0" /></div><?php

?>
<h1 class="cb_p2_setup_wizard_heading">Setup Wizard Screen 1</h1>

<div class="cb_p2_setup_wizard_text">This is setup wizard 1st screen!</div>
	
<form method="post" action="<?php echo $this->internal['admin_url'].'admin.php?page=setup_wizard_'.$this->internal['id'].'&'.$this->internal['prefix'].'setup_stage=1'; ?>">
	<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Skip to configuration!"></p>
	</form>
<?php

?>
