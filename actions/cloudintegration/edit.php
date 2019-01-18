<?php
/**
* Elgg CloudIntegration edit action
*
*/

$description = get_input('description');
$tags = get_input('tags');
$access_id = get_input('access_id');
$container_guid = get_input('container_guid', elgg_get_logged_in_user_guid());
$guid = get_input('guid');
$comments_on = get_input('comments_on');
$visible = get_input('visible');

elgg_make_sticky_form(\HLV\PLUGIN_ID);

if ($guid == 0) {
	system_message(elgg_echo('cloudintegration:share:access:error'));
	forward(REFERRER);
	return;
}else{
	$objEntity = get_entity($guid);
	if (!$objEntity->canEdit()) {
		system_message(elgg_echo('cloudintegration:share:access:error'));
		forward(REFERRER);
		return;
	}
}

$objEntity->description = $description;
$objEntity->visible = $visible;
$objEntity->access_id = $access_id;
$objEntity->container_guid = $container_guid;
$objEntity->comments_on = $comments_on;

$tagarray = string_to_tag_array($tags);
$objEntity->tags = $tagarray;

if ($objEntity->save()) {

	elgg_clear_sticky_form(\HLV\PLUGIN_ID);

	system_message(elgg_echo('cloudintegration:share:sys:save:correct'));

	forward($objEntity->getURL());
	return;

} else {
	register_error(elgg_echo('cloudintegration:share:save:error'));
	forward(REFERRER);
	return;
}
