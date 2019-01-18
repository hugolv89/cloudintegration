<?php
/**
 * Unshare form CloudIntegration
 *
 */
$guid = (int)$_GET['guid'];

if ($guid) {

	$user = elgg_get_logged_in_user_entity();

	if( ! $user->canWriteToContainer() ){
	//if (!can_write_to_container($user->guid, $guid)) {

		register_error(elgg_echo('cloudintegration:share:access:error'));
		echo '<script> elgg.ui.lightbox.close();</script>';
		return;
	}
}

$objEntity = get_entity($guid);
$elist = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => \HLV\PLUGIN_ID,
	'owner_guid' => elgg_get_logged_in_user_entity()->guid,
	'metadata_values' => array('shareid',$objEntity->shareid),
));

$btnHTML[] = elgg_view('input/button', array(
	'name' => 'delshare',
	'value' => elgg_echo('cloudintegration:unshare:remove:here'),
	'class' => 'elgg-button-submit elgg-button',
	'style' => 'float:right;',
	'onclick' => 'CloudIntegration.unshare('.$objEntity->guid.', "");',
));

foreach($elist as $e){

	if($e->guid == $guid){

		continue;
	}else{
		
		if($e->container_guid != elgg_get_logged_in_user_entity()->guid){

			$zonelang = elgg_echo('cloudintegration:unshare:remove:group').': '.get_entity($e->container_guid)->name;
		}else{

			$zonelang = elgg_echo('cloudintegration:unshare:remove:owner');
		}

		$btnHTML[] = elgg_view('input/button', array(
			'name' => 'delshare',
			'value' => $zonelang,
			'class' => 'elgg-button-submit elgg-button',
			'style' => 'float:right;',
			'onclick' => 'CloudIntegration.unshare('.$e->guid.', "");',
		));
	}

}

$OCS = new \HLV\Cloud\Api\OCS();
$OCS->rawData(false);

$ocsShare = $OCS->getShares($objEntity->path);
if(isset($ocsShare->data->element)){

	$btnUnshare = elgg_view('input/button', array(
		'name' => 'unshare',
		'value' => elgg_echo('cloudintegration:unshare'),
		'class' => 'elgg-button-submit elgg-button',
		'style' => 'float:left;',
		'onclick' => 'CloudIntegration.unshare('.$guid.', '.$objEntity->shareid.');',
	));

	echo elgg_echo('cloudintegration:unshare:info:shared');

}else{ // No Share

	echo elgg_echo('cloudintegration:unshare:info:noshared');
}

echo '</br></br>';


echo '<div>';
	echo $btnUnshare;

	foreach($btnHTML as $html){

		echo $html.'</br></br>';
	}

echo '</div>';
?>
