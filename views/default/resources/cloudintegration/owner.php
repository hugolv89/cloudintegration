<?php
/**
 * Elgg CloudIntegration plugin everyone page
 *
 */
elgg_group_gatekeeper();

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	forward('', '404');
}

if($page_owner->getGUID() == elgg_get_logged_in_user_guid()){

	if(\HLV\Cloud\User\CredentialsHandler::IS_READY()){

		$owner = new \HLV\Cloud\Graphic\Owner();

		$html = $owner->getHTML(elgg_extract('webdavpath', $vars));

	}else{

		$html = elgg_echo('cloudintegration:usersettings:info:misconfigured');

		$username = elgg_get_logged_in_user_entity()->username;

		$html .= ' <a href="'.elgg_get_site_url().'settings/plugins/'.$username.'/'.\HLV\PLUGIN_ID.'">'.elgg_echo('cloudintegration:usersettings:info:configure:here').'</a>';
	}

}else{

	// Metadata
	$elist = elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => \HLV\PLUGIN_ID,
		'owner_guid' => $page_owner->getGUID(),
	));

	$owlist = new \HLV\Cloud\Graphic\Owner($elist);

	$html = $owlist->getHTML();
}

$content = $html;

$title = elgg_echo('cloudintegration:owner', array($page_owner->name));

$filter_context = '';
if ($page_owner->getGUID() == elgg_get_logged_in_user_guid()) {
	$filter_context = 'mine';
}

$vars = array(
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view(\HLV\PLUGIN_ID.'/sidebar'),
);

// don't show filter if out of filter context
if ($page_owner instanceof ElggGroup) {
	$vars['filter'] = false;
}

$body = elgg_view_layout('content', $vars);

echo elgg_view_page($title, $body);
