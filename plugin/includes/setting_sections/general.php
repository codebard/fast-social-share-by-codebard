<?php


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
		
		$sets = '';
		
		foreach ( $this->opt['styles'] as $key => $value ) {
			
			$set_name = $key;
			
			$selected = '';
			
			if( isset( $this->lang['style_'.$key] ) ) {
				
				$set_name = $this->lang['style_'.$key];
				
			}
		
			$sets .= '<option value="'.$key.'" '.$selected.'>'.$set_name.'</option>';			
			
		}
		
		if( $this->opt['content_buttons_placement'] == 'top' ) {
			$placement_top = ' selected';
		}
		
		
		if( $this->opt['content_buttons_placement'] == 'bottom' ) {
			$placement_bottom = ' selected';
		}
		
		if( $this->opt['content_buttons_placement'] == 'top_and_bottom' ) {
			$placement_top_and_bottom = ' selected';
		}

		
?>


<h3>Social share placement</h3>
You can choose to place the social share at the bottom of your content, at the top, or both.
<div id="content_buttons_placement_messages" class="cb_p2_option_message cb_p2_block"></div>

<select name="content_buttons_placement" class="cb_p2_select_option" id="content_buttons_placement">
<option value="bottom" <?php echo $placement_bottom ?>>Bottom</option>
<option value="top_and_bottom" <?php echo $placement_top_and_bottom ?>>Top and Bottom</option>
<option value="top" <?php echo $placement_top ?>>Top</option>
</select>


<h3>Style to Post type matches</h3>
Set which style set to use for post types to show the social share. 
<br><br>
<form action="" method="post" id="cb_p2_assign_style_to_post_type_form" ajax_target_div="cb_p2_style_assignment_div">
<select name="selected_post_type"><?php echo $select; ?></select> <select name="selected_style"><option selected value="default">Default</option><option value="none">None</option><?php echo $sets; ?></select><input type="submit" class="cb_p2_button_general" id="cb_p2_assign_style_to_post_type" value="Assign" /><input type="hidden" name="action" value="cb_p2_assign_style_to_post_type" /></form>


<div id="cb_p2_style_assignment_div">Current post types to styles - for any post type that is not listed, default applies<br><br><b><?php echo substr($current_post_types,0,-2); ?></b></div>
