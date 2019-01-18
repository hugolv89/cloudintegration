<?php
/**
 * Shares Widget
 */

// set default value
if (!isset($vars['entity']->share_type)) {
	$vars['entity']->share_type = 1;
}
// set default value
if (!isset($vars['entity']->share_number)) {
	$vars['entity']->share_number = 5;
}

$share_type = $vars['entity']->share_type;

if(!\HLV\Cloud\User\CredentialsHandler::IS_READY()){

	$html = elgg_echo('cloudintegration:usersettings:info:misconfigured');

	$username = elgg_get_logged_in_user_entity()->username;

	$html .= ' <a href="'.elgg_get_site_url().'settings/plugins/'.$username.'/'.\HLV\PLUGIN_URI.'">'.elgg_echo('cloudintegration:usersettings:info:configure:here').'</a>';
}else{

	$ocs = new \HLV\Cloud\Api\OCS();
	$ocs->rawData(false);

	if($vars['entity']->share_folder == '' || $vars['entity']->share_folder == '/'){

		$all = $ocs->allShares();
	}else{

		$all = $ocs->getShares($vars['entity']->share_folder,false,true);

	}

	if($all->meta->statuscode == 100){

		$is_element = false;
		$i = 0;
		foreach ($all->data->element as $element) {

			if($i >= $vars['entity']->share_number){

				continue;
			}

			if( ($share_type == 1 && $element->permissions == 1) || ($share_type == 2)){

				echo '<a href="'.$element->url.'" target="_blank">'.ltrim($element->file_target,'/').'</a><br>';

				$is_element = true;
			}

			$i++;
		}

		if(!$is_element){

			echo elgg_echo('cloudintegration:widgets:shares:noshare');
		}

	}else{

		echo elgg_echo('cloudintegration:widgets:shares:error');
	}

}
