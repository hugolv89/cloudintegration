<?php
/**
 * Edit CloudIntegration page
 *
 */
elgg_gatekeeper();

elgg_gatekeeper();

$guid = elgg_extract('guid', $vars);
$ci = get_entity($guid);

if (!elgg_instanceof($ci, 'object', \HLV\PLUGIN_ID) || !$ci->canEdit()) {
	register_error(elgg_echo('cloudintegration:unknown'));
	forward(REFERRER);
}

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('cloudintegration:edit');
elgg_push_breadcrumb($title);

//$vars = bookmarks_prepare_form_vars($bookmark);
$content = elgg_view_form(\HLV\PLUGIN_ID.'/edit', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
