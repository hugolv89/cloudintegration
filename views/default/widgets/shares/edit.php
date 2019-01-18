<?php
/**
 * Shares Widget
 */

// set default value
if (!isset($vars['entity']->share_type)) {
	$vars['entity']->share_type = 1;
}

$paramsNumber = array(
	'name' => 'params[share_number]',
	'value' => $vars['entity']->share_number,
	'options' => array(3,5,10,15,20,25,30),
);
$number_dropdown = elgg_view('input/select', $paramsNumber);

$paramsType = array(
	'name' => 'params[share_type]',
	'value' => $vars['entity']->share_type,
	'options_values' => array(	1 => elgg_echo('cloudintegration:widgets:shares:toshare:op:public'), 
					2 => elgg_echo('cloudintegration:widgets:shares:toshare:op:all')
				 ),
);
$type_dropdown = elgg_view('input/select', $paramsType);

if(!\HLV\Cloud\User\CredentialsHandler::IS_READY()){

	$html = elgg_echo('cloudintegration:usersettings:info:misconfigured');

	$username = elgg_get_logged_in_user_entity()->username;

	$html .= ' <a href="'.elgg_get_site_url().'settings/plugins/'.$username.'/'.\HLV\PLUGIN_URI.'">'.elgg_echo('cloudintegration:usersettings:info:configure:here').'</a>';
}else{

	$ocs = new \HLV\Cloud\Api\OCS();
	$ocs->rawData(false);
	$all = $ocs->allShares();

	$shareFolders = array('/');
	foreach ($all->data->element as $key => $element) {

		if($element->item_type == 'folder'){

			$shareFolders[] = $element->path;
		}
	}


	$paramsFolder = array(
		'name' => 'params[share_folder]',
		'value' => $vars['entity']->share_folder,
		'options' => $shareFolders,
	);
	$folder_dropdown = elgg_view('input/select', $paramsFolder);

	?>
	<div>
		<?php 
			echo elgg_echo('cloudintegration:widgets:shares:number:label').': ';
	 		echo $number_dropdown; 
		?>
	</br></br>
		<?php 
			echo elgg_echo('cloudintegration:widgets:shares:toshare:label').': ';
	 		echo $type_dropdown; 
		?>
	</br></br>
		<?php 
			if(count($shareFolders) > 1){
				echo elgg_echo('cloudintegration:widgets:shares:folder:label').': ';
				echo $folder_dropdown;
			}else{

				$vars['entity']->share_folder = '';
			}
		?>
	</div>
<?php
}
?>
