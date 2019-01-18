<?php 

$settings = new HLV\Cloud\User\Settings();

// Message
?>
	<div><?php echo elgg_echo('cloudintegration:usersettings:message'); ?></div> 
<?php

// Custom URL IF
if($user_custom_url = $settings->verifyCloudIntegrationServer()){ ?>
	<label><?php echo elgg_echo('cloudintegration:usersettings:label:cloudintegration:url'); ?></label> 
	<div class="example"><?php echo elgg_echo('cloudintegration:usersettings:help:cloudintegration:url')?></div>
	<input type="text" class="elgg-input-text" name="params[user_custom_url]" value="<?php echo $user_custom_url; ?>"/>
	<br/>
	<br/>
<?php 
} // END Custom URL IF

// Credentials IF
if(\HLV\Functions::SETTING_BOOL('enable_customcredentials')){ ?>

	<fieldset style="border: 1px solid black; padding: 15px; margin: 0 0px 0 0px;">
		<legend><?php echo elgg_echo('cloudintegration:usersettings:legend:credentials')?></legend>
	<?php	if($settings->newCredentials()){	?>

			<label><?php echo elgg_echo('cloudintegration:usersettings:label:credential:user'); ?></label> 
			<input type="text" class="elgg-input-text" name="params[credential_user]" />
			<br/><br/>	
			<label><?php echo elgg_echo('cloudintegration:usersettings:label:credential:password'); ?></label> 
			<input type="password" class="elgg-input-text" name="params[credential_password]" />
			<br/>	
			<label><?php echo elgg_echo('cloudintegration:usersettings:label:credential:passwordagain'); ?></label> 
			<input type="password" class="elgg-input-text" name="params[credential_passwordagain]" />
	<?php 
		elgg_set_plugin_user_setting('newEncrypt', 'true', elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);
		}else{	
		    if(\HLV\Functions::USETTING_BOOL('newEncrypt')){
				$settings->encryptCredentials();
				elgg_set_plugin_user_setting('newEncrypt', 'false', elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);
			}

			$enable_unlink = \HLV\Functions::USETTING('enable_unlink');	
	?>
			<label><?php echo elgg_echo('cloudintegration:usersettings:label:credential:unlink'); ?></label>
			<br/><br/> 
			<select name="params[enable_unlink]">
		  		<option value="true" <?php if (($enable_unlink == 'true')) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes')?></option>
		  		<option value="false" <?php if (($enable_unlink == 'false') || (!isset($enable_unlink))) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no')?></option>
			</select>
	<?php } ?>
	</fieldset>
	<br/>

<?php
}// END Credentials IF
?>
