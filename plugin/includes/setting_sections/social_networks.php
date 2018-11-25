<?php 




echo '<h2>'.$this->lang['social_networks_select_network'].'</h2>';

if($this->opt['assign_tickets_to_admins']=='yes')
{
	$assign_tickets_to_admins_checked_yes=" CHECKED";
}
else
{
	$assign_tickets_to_admins_checked_no=" CHECKED";
}



echo '<h2>'.$this->lang['option_title_assign_tickets_to_admins'].'</h2>';



	foreach ( $this->opt['social_networks'] as $key => $value ) {
		
		
		echo '<a href="" class="'.$this->internal['prefix'].'social_network_edit" target="'.$this->internal['prefix'].'network_editor" network="'.$key.'">'.$this->opt['social_networks'][$key]['name'].'</a>';
		
		
	}
	
echo '<div id="'.$this->internal['prefix'].'network_editor"></div>';


echo '<h2>'.$this->lang['option_title_assign_tickets_to_admins'].'</h2>';

echo '<div class="'.$this->internal['prefix'].'option_info">'.$this->lang['option_info_assign_tickets_to_admins'].'</div>';

echo $this->lang['yes'].' <input type="radio" name="opt[assign_tickets_to_admins]" value="yes"'.$assign_tickets_to_admins_checked_yes.'>'.$this->lang['no'].' <input type="radio" name="opt[assign_tickets_to_admins]" value="no"'.$assign_tickets_to_admins_checked_no.'>';



