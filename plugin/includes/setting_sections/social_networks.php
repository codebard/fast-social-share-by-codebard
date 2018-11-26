<?php 



if($this->opt['assign_tickets_to_admins']=='yes')
{
	$assign_tickets_to_admins_checked_yes=" CHECKED";
}
else
{
	$assign_tickets_to_admins_checked_no=" CHECKED";
}



	echo '<div class="'.$this->internal['prefix'].'social_network_edit_wrapper">';
	foreach ( $this->opt['social_networks'] as $key => $value ) {
		
		if( $this->opt['social_networks'][$key]['id'] =='' ) {
			continue;
		}
		echo '<div class="'.$this->internal['prefix'].'social_network_edit_button '.$this->internal['prefix'].'social_network_edit" target="'.$this->internal['prefix'].'network_editor" network="'.$key.'"><img src="'.$this->internal['plugin_url'].'plugin/images/set_1/'.$key.'/20.png" />'.$this->opt['social_networks'][$key]['name'].'</div>';
		
		 
	}
		echo '<div class="'.$this->internal['prefix'].'social_network_edit_button '.$this->internal['prefix'].'social_network_edit" target="'.$this->internal['prefix'].'network_editor" network="add_new"><img src="'.$this->internal['plugin_url'].'plugin/images/set_1/add_network.png" />Add New</div>';
		
echo '</div>';

echo '<div id="'.$this->internal['prefix'].'network_editor"><h2>'.$this->lang['social_networks_select_network'].'</h2></div>';


