<?php

if (!elgg_is_xhr()) {
    register_error('Sorry, Ajax only!');
    forward();
}

// Data
$data = array(
	'guid' => (int)get_input('guid'),
	'id' => (int)get_input('id'),
);

if ($data['guid']) {

	$user = elgg_get_logged_in_user_entity();

	if (!can_write_to_container($user->guid, $data['guid'])) {

		register_error(elgg_echo('cloudintegration:share:access:error'));
		return;
	}
}

$objEntity = get_entity($data['guid']);
if( ( elgg_instanceof($objEntity, 'object', \HLV\PLUGIN_ID) || elgg_instanceof($objEntity, 'group', \HLV\PLUGIN_ID) ) && $objEntity->canEdit()){

	$path = $objEntity->path;

	if($data['id'] != ''){

		$ocs = new \HLV\Cloud\Api\OCS();
		$ocs->rawData(false);
		$response = $ocs->deleteShare($data['id']);

		if($response == 200){

			$elist = elgg_get_entities_from_metadata(array(
				'type' => 'object',
				'subtype' => \HLV\PLUGIN_ID,
				'owner_guid' => elgg_get_logged_in_user_entity()->guid,
				'metadata_values' => array('shareid',$objEntity->shareid),
			));
	
			foreach($elist as $e){
	
				$e->delete();
			}

			echo json_encode([
				'status' => 'ok',
				'path' => \HLV\Functions::seoUrl($path),
			]);
			system_message(elgg_echo('cloudintegration:unshare:sys:correct'));
			
		}else{
			
			register_error(elgg_echo('cloudintegration:share:notfound:error'));
		}

	}else{

		$objEntity->delete();
	}

}else{

	register_error(elgg_echo('cloudintegration:share:notfound:error'));
	return;
}


