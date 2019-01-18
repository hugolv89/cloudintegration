<?php
/**
 * Edit form CloudIntegration
 *
 */
$guid = elgg_extract('guid', $vars, null);
$objEntity = get_entity($guid);

$name = $objEntity->title;
$desc = $objEntity->description;
$tags = $objEntity->tags;
$access_id = $objEntity->access_id;
$container_guid = $objEntity->container_guid;
$comments_on = $objEntity->comments_on;
$visible = filter_var($objEntity->visible, FILTER_VALIDATE_BOOLEAN);
?>
<div>
	<label><?php echo elgg_echo('name').': '.$name; ?></label>
</div>

<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>

<div>
	<label><?php echo elgg_echo('cloudintegration:visible:true'); ?></label><br/>
	<?php echo elgg_view('input/checkbox', array('name' => 'visible', 'checked' => $visible)); ?>
</div>
<?php
	echo '<div><label>'.elgg_echo('comments').'</label><br>'; 
	$comments_input = elgg_view('input/select', array( 
		'name' => 'comments_on', 
		'id' => 'cloud_comments_on', 
		'value' => $comments_on,
		'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off')) 
	)); 
	echo $comments_input.'</div>'; 
?>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>

<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array(
		'name' => 'access_id',
		'value' => $access_id,
		'entity' => get_entity($guid),
		'entity_type' => 'object',
		'entity_subtype' => \HLV\PLUGIN_ID,
	)); ?>
</div>

<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => elgg_echo("save")));

?>
</div>
