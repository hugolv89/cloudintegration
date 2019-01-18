<?php

elgg_gatekeeper();

$page_type = elgg_extract('page_type', $vars);
$group_guid = elgg_extract('guid', $vars);
$group = get_entity($group_guid);

elgg_push_breadcrumb(elgg_echo('cloudintegration:group').' '.$group->name, \HLV\PLUGIN_URI.'/group/'.$group_guid.'/all');

$title = elgg_echo('cloudintegration:owner', array(elgg_get_logged_in_user_entity()->name));

if(\HLV\Cloud\User\CredentialsHandler::IS_READY()){

	$owner = new \HLV\Cloud\Graphic\Owner();

	$html = $owner->getHTML(elgg_extract('webdavpath', $vars), $group_guid);
}else{

	$html = elgg_echo('cloudintegration:usersettings:info:misconfigured');

	$username = elgg_get_logged_in_user_entity()->username;

	$html .= ' <a href="'.elgg_get_site_url().'settings/plugins/'.$username.'/"'.\HLV\PLUGIN_ID.'>'.elgg_echo('cloudintegration:usersettings:info:configure:here').'</a>';
}

$content = $html;

$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view(\HLV\PLUGIN_ID.'/sidebar'),
	'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
