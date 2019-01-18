<?php

if (!elgg_is_xhr()) {
    register_error('Sorry, Ajax only!');
    forward();
}

// Data
$data = array(
	'guid' => (int)get_input('guid'),
	'access_id' => (int)get_input('access_id'),
	'title' => (string)get_input('title'),
	'description' => (string)get_input('description'),
	'path' => (string)get_input('path'),
	'password' => (string)get_input('password'),
	'newshare' => (bool)get_input('newshare'),
	'comments_on' => (string)get_input('comments_on'),
	'tags' => (string)get_input('tags'),
);

$isGroup = false;
if ($data['guid']) {

	$user = elgg_get_logged_in_user_entity();

	if (!can_write_to_container($user->guid, $data['guid'])) {

		register_error(elgg_echo('cloudintegration:share:access:error'));
		return;
	}else{

		$isGroup = true;
	}

} else {

    $data['guid'] = elgg_get_logged_in_user_guid();
}

$ocs = new \HLV\Cloud\Api\OCS();
$ocs->rawData(false);

$ocsShare = $ocs->getShares($data['path']);

if($data['newshare'] == 1){

	$elist = elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => \HLV\PLUGIN_ID,
		'owner_guid' => elgg_get_logged_in_user_entity()->guid,
		'metadata_values' => array('shareid',$objEntity->shareid),
	));

	foreach($elist as $e){

		$e->delete();
	}

	if(isset($ocsShare->data->element)){
		$ocs->deleteShare($ocsShare->data->element->id);
	}

	$ocs->createShare($data['path'], 3, '', false, $data['password']);

}elseif (!isset($ocsShare->data->element)){

	$response = $ocs->createShare($data['path'], 3, '', false, $data['password']);
		
	//system_message("Code:".$response);
}

$ocsShare = $ocs->getShares($data['path']); // to fix

$publicShare;
$isShare = false;
foreach($ocsShare->data->element as $element){

	// Public
	if($element->share_type == 3){
		$isShare = true;
		$publicShare = $element;
		break;
	}

}

if(!$isShare){

	register_error(elgg_echo('cloudintegration:share:save:error'));
	return;
}

$metaCount = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => \HLV\PLUGIN_ID,
	'container_guid' => $data['guid'],
	'metadata_name_value_pairs' => array(	
		array(
	    		'name' => 'link',
	    		'value' => (string)$publicShare->url,
	    		'operand' => '=',
	    		'case_sensitive' => true
		),
		array(
	    		'name' => 'path',
	    		'value' => (string)$data['path'],
	    		'operand' => '=',
	    		'case_sensitive' => true
		),
	),
	'count' => true,
));

if($metaCount == 0){

	// Create Entity
	$objEntity = new \HLV\Cloud\MetaData\ElggCloudIntegration();

	if($isGroup && $data['access_id'] == 3){
		$objEntity->access_id = get_entity($data['guid'])->group_acl;
	}else{
		$objEntity->access_id = $data['access_id'];
	}

	$objEntity->container_guid = $data['guid'];
	$objEntity->title = $data['title'];
	$objEntity->description = $data['description'];
	$objEntity->filetype = (string)$publicShare->item_type;
	$objEntity->shareid = (int)$publicShare->id;
	$objEntity->path = $data['path'];
	$objEntity->link = (string)$publicShare->url;
	$objEntity->visible = true;
	$objEntity->tags = string_to_tag_array($data['tags']);
	$objEntity->comments_on = $data['comments_on'];

	// will be rendered client-side

	if($objEntity->save()){

		system_message(elgg_echo('cloudintegration:share:sys:correct'));

		//add to river
		elgg_create_river_item(array(
			'view' => 'river/object/'.\HLV\PLUGIN_ID.'/create',
			'action_type' => 'create',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $objEntity->getGUID(),
		));
	
		echo json_encode([
			'status' => 'ok',
			'id' => (int)$objEntity->guid,
			'shareid' => (int)$objEntity->shareid,
			'path' => \HLV\Functions::seoUrl($objEntity->path),
			'link' => $objEntity->link,
		]);

	}else{

		register_error(elgg_echo('cloudintegration:share:save:error'));
		return;
	}
}else{

	register_error(elgg_echo('cloudintegration:share:duplicate:error'));
	return;
}

?>
