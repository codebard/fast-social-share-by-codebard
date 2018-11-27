<form action="/" id="{***prefix***}social_network_edit_form" method="post" enctype="multipart/form-data" ajax_target_div="cb_p2_network_editor">

	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_name%%%}</h4>
	<input type="text" name="{***prefix***}name" value="{***network_name***}" />
	{***network_id_box***}
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_text_before%%%}</h4>
	<input type="text" name="{***prefix***}text_before" value="{***text_before***}" size="36" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_text_after%%%}</h4>
	<input type="text" name="{***prefix***}text_after" value="{***text_after***}" size="36" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_icon%%%}</h4>
	<input class="{***prefix***}file_upload" type="text" name="{***prefix***}icon" value="{***icon***}" style="width :100%; max-width:600px;"  /> <a href="" class="cb_p2_clear_prevfield">Clear</a>
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_url%%%}</h4>
	<input type="text" name="{***prefix***}url" value="{***url***}" style="width :100%; max-width:600px;" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_active%%%}</h4>
	{***social_network_active***}
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_follow%%%}</h4>
	<input type="text" name="{***prefix***}follow" value="{***follow***}" size="72" />
	<h4 class="{***prefix***}social_network_form_title">{%%%social_networks_sort%%%}</h4>
	<input type="text" name="{***prefix***}sort" value="{***sort***}" />
	<input type="hidden" name="{***prefix***}existing_network_id" value="{***existing_network_id***}" />
<br clear="both" />
<br clear="both" />
	<input type="submit" class="cb_p2_social_network_edit_button" value="Add/Update network">&nbsp;&nbsp;&nbsp;&nbsp;<div class="cb_p2_social_network_edit_button" id="cb_p2_delete_network_button" ajax_target_div="cb_p2_network_editor" network="{***existing_network_id***}">Delete network</div>

</form>


