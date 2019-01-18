<?php
/**
 * New CloudIntegration river entry
 *
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$object = $item->getObjectEntity();
$excerpt = elgg_get_excerpt($object->description);

echo elgg_view('river/elements/layout', array(
	'item' => $item,
	'message' => $excerpt,
	'attachments' => elgg_view('output/url', array('href' => $object->link)),
));
