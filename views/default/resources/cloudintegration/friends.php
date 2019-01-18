<?php
/**
 * Elgg CloudIntegration plugin friends page
 *
 */

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	forward('', '404');
}

elgg_push_breadcrumb($page_owner->name, \HLV\PLUGIN_URI."/owner/$page_owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

$title = elgg_echo('cloudintegration:friends');

$content = elgg_list_entities_from_relationship(array(
	'type' => 'object',
	'subtype' => \HLV\PLUGIN_ID,
	'relationship' => 'friend',
	'relationship_guid' => $page_owner->guid,
	'relationship_join_on' => 'owner_guid',

));

$params = array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
