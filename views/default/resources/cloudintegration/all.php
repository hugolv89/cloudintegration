<?php
/**
 * Elgg CloudIntegration plugin everyone page
 *
 */

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('cloudintegration'));

$content = elgg_list_entities_from_relationship(array(
	'type' => 'object',
	'subtype' => \HLV\PLUGIN_ID,
));

$title = elgg_echo('cloudintegration:everyone');

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view(\HLV\PLUGIN_ID.'/sidebar'),
));

echo elgg_view_page($title, $body);
