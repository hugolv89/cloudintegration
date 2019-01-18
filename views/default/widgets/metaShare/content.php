<?php
/**
 * Shares Widget
 */

$ci = $vars['entity'];

// set default value
if (!isset($ci->share_number)) {
	$ci->share_number = 5;
}

$options = array(
	'type' => 'object',
	'subtype' => \HLV\PLUGIN_ID,
	'container_guid' => $ci->owner_guid,
	'limit' => $ci->share_number,
	'full_view' => FALSE,
	'pagination' => FALSE,
	'distinct' => false,
);

$content = elgg_list_entities($options);

echo $content;
