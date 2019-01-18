<?php
/**
 * Share form CloudIntegration
 *
 */
$guid = (int)$_GET['guid'];
$name = base64_decode((string)$_GET['name']);
$path = base64_decode((string)$_GET['path']);

$newResource = true;
$isGroup = false;

if(elgg_get_logged_in_user_entity()->guid != $guid && $guid != 0){

	$groupName = get_entity($guid)->name;
	$isGroup = true;
}

$OCS = new \HLV\Cloud\Api\OCS();
$OCS->rawData(false);

$ocsShare = $OCS->getShares($path);
if(isset($ocsShare->data->element)){

	$newResource = false;
	
	echo'<p>'.elgg_echo('cloudintegration:share:get:info').'</p>';

	$s_plublic = array();
	$s_users = array();
	$s_groups = array();

	foreach($ocsShare->data->element as $element){

		if($element->share_type == 3){
			
			$s_plublic[] = $element;
		}elseif($element->share_type == 1){

			$s_groups[] = $element;
		}elseif($element->share_type == 0){

			$s_users[] = $element;
		}
	}

	$info = '<div>';

	foreach($s_users as $element){

		$info_users .= ', '.$element->share_with_displayname;

	}

	if($info_users != ''){

		$info .= elgg_echo('cloudintegration:api:sharetypes:0').': '.ltrim($info_users, ',').'.';
	}

	foreach($s_groups as $element){

		$info_groups .= ', '.$element->share_with_displayname;

	}

	if($info_groups != ''){

		if($info_users != ''){
			$info .= '</br>';
		}
		$info .= elgg_echo('cloudintegration:api:sharetypes:1').': '.ltrim($info_groups, ',').'.';
	}

	$info .= '</div>';

}

echo '<div id="cinewshare">';
	echo $info;
	echo '<label>'.elgg_echo('cloudintegration:share:password:optional').'</label></br>';
?>
	<div style="clear:both;">
		<div style="width:60%;float:left;">
		<?php echo elgg_view('input/password', array('id' => 'cloud_passwd','disabled' => !$newResource,'name' => 'passwd','autocomplete' => 'false')).'</br>'; ?>
		</div>
		<div style="width:40%;float:left;text-align:right;margin-top:5px;">
		<?php	
				if(!$newResource){
					echo elgg_echo('Nuevo recurso*').' ';
					echo elgg_view('input/checkbox', array(	'id' => 'cloud_new',
										'name' => 'cloud_new', 
										'checked' => false,
										'onchange' => 'CloudIntegration.optformpass();',
									));
				}
		?>
		</div>
	</div>
</br></br>
	<div style="clear:both;">
		<label><?php echo elgg_echo('description'); ?></label>
		<?php echo elgg_view('input/plaintext', array('id' => 'cloud_descrp','name' => 'description','rows' => '3')); ?>
	</div>
	<div style="clear:both;">
		<div style="width:30%;float:left;">
			<?php 
				echo '<label>'.elgg_echo('comments').'</label><br>'; 
				echo elgg_view('input/select', array( 
					'name' => 'comments_on', 
					'id' => 'cloud_comments_on', 
					'value' => 'Off',
					'style' => 'margin-top:5px;',
					'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off')) 
				)); 
			?>
		</div>
		<div style="width:70%;float:left;">
			<label><?php echo elgg_echo('tags'); ?></label>
			<?php echo elgg_view('input/tags', array('id' => 'cloud_tags','name' => 'tags')); ?>
		</div>
	</div>
</br></br>
<?php
	echo '</br>';
	echo '<label>'.elgg_echo('access').'</label></br>';

	if(!$isGroup){
		echo elgg_view('input/access', array(
			'name' => 'access_id',
			'id' => 'cloud_access_id',
			'style' => 'margin-top:0px;',
			'value' => $vars['access_id'],
			'entity' => $vars['entity'],
			'entity_type' => 'object',
			'entity_subtype' => \HLV\PLUGIN_ID,
		));
	}else{
		echo elgg_view('input/select', array(
		   	'name' => 'access_id',
			'id' => 'cloud_access_id',
			'style' => 'margin-top:0px;',
			'value' => 3,
		   	'options_values' => array(
		      		'0' => elgg_echo('PRIVATE'),						// Private
		      		'1' => elgg_echo('LOGGED_IN'), 						// Connected Users
					'3' => elgg_echo('group').': \''.$groupName.'\'',	// Group 
		   	),
		));
	}

	echo elgg_view('input/button', array(
		'name' => 'share',
		'value' => elgg_echo('cloudintegration:share'),
		'class' => 'elgg-button-submit elgg-button',
		'style' => 'float:right;',
		'onclick' => 'CloudIntegration.share('.$guid.',"'.$name.'","'.$path.'");',
	));

	if(!$newResource){
		echo '</br></br>';
		echo'<p style="clear:both;font-style:italic;">* '.elgg_echo('cloudintegration:share:new:info').'</p>';
	}
echo '</div>';
?>
