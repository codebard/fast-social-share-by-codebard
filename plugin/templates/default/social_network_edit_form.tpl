<form action="/" id="{***prefix***}social_network_edit_form" method="post" enctype="multipart/form-data" ajax_target_div="cb_p2_network_editor">

	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_name%%%}</h4>
	<input type="text" name="{***prefix***}network_details[{***network_id***}][name]" value="{***network_name***}" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_id%%%}</h4>
	<input type="text" name="{***prefix***}network_details[{***network_id***}][id]" value="{***network_id***}" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_text_before%%%}</h4>
	<input type="text" name="{***prefix***}network_details[{***network_id***}][text_before]" value="{***text_before***}" size="36" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_text_after%%%}</h4>
	<input type="text" name="{***prefix***}network_details[{***network_id***}][text_after]" value="{***text_after***}" size="36" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_icon%%%}</h4>
	<input type="text" name="{***prefix***}network_details[{***network_id***}][icon]" value="{***icon***}"  />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_url%%%}</h4>
	<input type="text" name="{***prefix***}network_details[{***network_id***}][url]" value="{***url***}" style="width :100%; max-width:500px;" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_active%%%}</h4>
	<input type="text" name="{***prefix***}network_details[{***network_id***}][active]" value="{***active***}" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_follow%%%}</h4>
	<input type="text" name="{***prefix***}network_details[{***network_id***}][follow]" value="{***follow***}" size="72" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_sort%%%}</h4>
	<input type="text" name="{***prefix***}network_details[{***network_id***}][sort]" value="{***sort***}" />
	<input type="hidden" name="{***prefix***}network_id" value="{***network_id***}" />
<br clear="both" />
<br clear="both" />
	<input type="submit" class="cb_p2_social_network_edit_button" value="Add/Update Network">

</form>


