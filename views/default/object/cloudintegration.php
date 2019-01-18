<?php
/**
 * View for CloudIntegration objects
 *
 * @package cloudintegration
 */

$full = elgg_extract('full_view', $vars, FALSE);
$cloud = elgg_extract('entity', $vars, FALSE);

$container = get_entity($cloud->container_guid);
$canEdit = $container->canEdit();
$visible = filter_var($cloud->visible, FILTER_VALIDATE_BOOLEAN);

if (!$cloud) {
	return TRUE;
}

$owner = $cloud->getOwnerEntity();

$excerpt = $cloud->excerpt;
if (!$excerpt) {
	$excerpt = elgg_get_excerpt($cloud->description);
}

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$categories = elgg_view('output/categories', $vars);

$vars['owner_url'] = \HLV\PLUGIN_URI."/owner/$owner->username";
$by_line = elgg_view('page/elements/by_line', $vars);

if($cloud->comments_on == 'On'){

	$comments_count = $cloud->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $cloud->getURL() . '#comments',
			'text' => $text,
			'is_trusted' => true,
		));
	} else {
		$comments_link = '';
	}
}

$subtitle = "$by_line $comments_link $categories";

$metadata = '';
if (!elgg_in_context('widgets')) {
	// only show entity menu outside of widgets
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => \HLV\PLUGIN_URI,
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

if($visible || $canEdit){

	if ($full) {

		$body = '<div class="elgg-content mts">
				'.elgg_view_icon('push-pin-alt').'
				<a target="_blank" href="'.$cloud->link.'">'.$cloud->link.'</a>
			</div>';

		$body .= elgg_view('output/longtext', array(
			'value' => $cloud->description,

		));

		$params = array(
			'entity' => $cloud,
			'title' => false,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
		);
		$params = $params + $vars;
		$summary = elgg_view('object/elements/summary', $params);

		echo elgg_view('object/elements/full', array(
			'entity' => $cloud,
			'summary' => $summary,
			'icon' => $owner_icon,
			'body' => $body,
		));


	}else{
		// brief view

		$params = array(
			'entity' => $cloud,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'content' => $excerpt,
		);
		$params = $params + $vars;

		$list_body = elgg_view('cloudintegration/elements/summary', $params);

		echo elgg_view_image_block($owner_icon, $list_body);

	}

}
