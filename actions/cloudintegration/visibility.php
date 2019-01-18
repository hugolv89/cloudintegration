<?php

if (!elgg_is_xhr()) {
    register_error('Sorry, Ajax only!');
    forward();
}

// Data
$data = array(
	'guid' => (int)get_input('guid'),
	'visible' => get_input('visible'),
);

// save access status
$access_setting = elgg_get_ignore_access();	
// Ignore access
elgg_set_ignore_access(true);

$objEntity = get_entity($data['guid']);
if(elgg_instanceof($objEntity, 'object', \HLV\PLUGIN_ID)){

	$objEntity->visible = $data['visible'];

	// will be rendered client-side

	if($objEntity->save()){

		echo json_encode([
			'status' => 'ok',
		]);

	}else{

		// Restore access
		elgg_set_ignore_access($access_setting);

		register_error(elgg_echo('cloudintegration:visibility:save:error'));
		return;
	}

}else{

	// Restore access
	elgg_set_ignore_access($access_setting);

	register_error(elgg_echo('cloudintegration:share:notfound:error'));
	return;
}

// Restore access
elgg_set_ignore_access($access_setting);

system_message(elgg_echo('cloudintegration:visibility:sys:correct'));
