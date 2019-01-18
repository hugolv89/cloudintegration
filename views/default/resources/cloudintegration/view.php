<?php
/**
 * View a CloudIntegration metadata
 *
 */

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', \HLV\PLUGIN_ID);

$ow = get_entity($guid);

$page_owner = elgg_get_page_owner_entity();

elgg_group_gatekeeper();

$crumbs_title = $page_owner->name;

if (elgg_instanceof($page_owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, \HLV\PLUGIN_URI."/group/$page_owner->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, \HLV\PLUGIN_URI."/owner/$page_owner->username");
}

$title = $ow->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($ow, array('full_view' => true));

if ($ow->comments_on == 'On') { 
	$content .= elgg_view_comments($ow); 
} 

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
