<?php
/**
 * group
 */

$page_type = elgg_extract('page_type', $vars);
$subpage = elgg_extract('subpage', $vars);
$group_guid = elgg_extract('group_guid', $vars);
$lower = elgg_extract('lower', $vars);
$upper = elgg_extract('upper', $vars);

$group = get_entity($group_guid);

if (!elgg_instanceof($group, 'group')) {
	forward('', '404');
}

elgg_register_title_button();

$title = elgg_echo('cloudintegration:owner', array($group->name));

$content = elgg_list_entities_from_relationship(array(
	'type' => 'object',
	'subtype' => \HLV\PLUGIN_ID,
	'container_guid' => $group_guid,
));

$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('discussion/sidebar'),
	'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

?>
