	<fieldset style="border: 1px solid black; padding: 15px; margin: 0 0px 0 0px;">
		<legend><?php echo elgg_echo('cloudintegration:settings:legend:general')?></legend>
		<label><?php echo elgg_echo('cloudintegration:settings:label:url:default'); ?></label> 
		<div class="example"><?php echo elgg_echo('cloudintegration:settings:help:url:default')?></div>
	<?php
		if (($vars['entity']->disable_secure_url == 'false') || (!isset($vars['entity']->disable_secure_url))){

			if (!empty($vars['entity']->custom_urldefault)) {

				if(parse_url($vars['entity']->custom_urldefault, PHP_URL_SCHEME) != 'https'){
					elgg_set_plugin_setting('custom_urldefault','',\HLV\PLUGIN_ID);
					register_error(elgg_echo('cloudintegration:settings:error:cloudintegration:url:secure'));
				}
			}
		}
	?>
      		<input type="text" class="elgg-input-text" name="params[custom_urldefault]" value="<?php if (empty($vars['entity']->custom_urldefault)) { echo "";} else { echo $vars['entity']->custom_urldefault;}?>"/>
		<br/><br/>
		<label><?php echo elgg_echo('cloudintegration:settings:label:secure'); ?></label> 
		<div class="example"><?php echo elgg_echo('cloudintegration:settings:help:secure')?></div>
		<select name="params[disable_secure_url]">
	  		<option value="true" <?php if (($vars['entity']->disable_secure_url == 'true')) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes')?></option>
	  		<option value="false" <?php if (($vars['entity']->disable_secure_url == 'false') || (!isset($vars['entity']->disable_secure_url))) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no')?></option>
		</select>
		<br/><br/>
		<label><?php echo elgg_echo('cloudintegration:settings:label:url:custom'); ?></label> 
		<div class="example"><?php echo elgg_echo('cloudintegration:settings:help:url:custom')?></div>
		<select name="params[enable_custom_url]">
	  		<option value="true" <?php if (($vars['entity']->enable_custom_url == 'true')) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes')?></option>
	  		<option value="false" <?php if (($vars['entity']->enable_custom_url == 'false') || (!isset($vars['entity']->enable_custom_url))) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no')?></option>
		</select>
		<br/><br/>
		<label><?php echo elgg_echo('cloudintegration:settings:label:custom:credential'); ?></label> 
		<div class="example"><?php echo elgg_echo('cloudintegration:settings:help:custom:credential')?></div>
		<select name="params[enable_customcredentials]">
	  		<option value="true" <?php if (($vars['entity']->enable_customcredentials == 'true')) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes')?></option>
	  		<option value="false" <?php if (($vars['entity']->enable_customcredentials == 'false') || (!isset($vars['entity']->enable_customcredentials))) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no')?></option>
		</select>
	</fieldset>

<br/>

	<fieldset style="border: 1px solid black; padding: 15px; margin: 0 0px 0 0px;">
		<legend><?php echo elgg_echo('cloudintegration:settings:legend:users')?></legend>
		<label><?php echo elgg_echo('cloudintegration:settings:label:own:enable'); ?></label> 
		<div class="example"><?php echo elgg_echo('cloudintegration:settings:help:own:enable')?></div>
		<select name="params[enable_users]">
	  		<option value="true" <?php if (($vars['entity']->enable_users == 'true') || (!isset($vars['entity']->enable_users))) echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes')?></option>
	  		<option value="false" <?php if ($vars['entity']->enable_users == 'false') echo " selected=\"yes\" "; ?>><?php echo elgg_echo('option:no')?></option>
		</select>
	</fieldset>

<br/>
