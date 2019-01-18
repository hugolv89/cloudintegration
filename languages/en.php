<?php

return array(

	'cloudintegration' => 'Cloud',
	'cloudintegration:cloudintegrations' => 'Cloud',
	'cloudintegration:group:tool:option:enable' => 'Enable group Cloud',

	// General
	'cloudintegration:add' => "Link a file from Cloud",
	'cloud:add' => "Link a file from Cloud",
	'cloudintegration:edit' => "Edit link from Cloud",

	'cloudintegration:owner' => "%s's Cloud",
	'cloudintegration:friends' => "Friends Cloud",
	'cloudintegration:everyone' => 'All site Cloud',

	'cloudintegration:download' => "Download",
	'cloudintegration:open' => "Open in a new window",
	'cloudintegration:view' => "View",
	'cloudintegration:edit' => "Edit",
	'cloudintegration:none' => 'No Cloud',
	'cloudintegration:nofiles' => 'No files.',
	'cloudintegration:unknown' => 'Unknown share.',

	'cloudintegration:share' => "Share",
	'cloudintegration:share:view:dc' => "See description and comments",
	'cloudintegration:share:get:info' => "The file has been shared before, the same link is used.",
	'cloudintegration:share:new' => "New share",
	'cloudintegration:share:new:info' => "A new share resource configuration eliminates the previously shared <br/> and remove previously shared resource Elgg completely.",
	'cloudintegration:share:create' => "Create share",
	'cloudintegration:share:password:optional' => "Password (Optional)",
	'cloudintegration:share:password:repeat' => "Repeat Password",

	'cloudintegration:share:sys:correct' => "File shared correctly",
	'cloudintegration:share:sys:save:correct' => "File saved correctly",
	'cloudintegration:share:access:error' => "Error: Shared file cannot be written",
	'cloudintegration:share:save:error' => "Error: Shared file cannot be save",
	'cloudintegration:share:duplicate:error' => "Error: Shared file already exists",
	'cloudintegration:share:notfound:error' => "Error: Shared file not found",

	'cloudintegration:unshare' => "Unshare",
	'cloudintegration:unshare:remove:all' => 'Remove from elgg',
	'cloudintegration:unshare:remove:group' => 'Remove from group',
	'cloudintegration:unshare:remove:here' => 'Remove from here only',
	'cloudintegration:unshare:remove:owner' => 'Remove from your own space',
	'cloudintegration:unshare:info:shared' => 'You can unshare the file completely, or just remove it from elgg',
	'cloudintegration:unshare:info:noshared' => 'This file is no longer shared from Cloud or there are a connexion problem.',

	'cloudintegration:unshare:sys:correct' => "File unshared correctly",

	'cloudintegration:group' => 'Cloud documents',
	'cloudintegration:visible:true' => 'Visible',
	'cloudintegration:visible:false' => 'Invisible',
	'cloudintegration:visibility:sys:correct' => 'Visibility successfully set',
	'cloudintegration:visibility:save:error' => 'Visibility has not been changed correctly',

	// River

	'cloudintegration:notify:summary' => 'New Cloud shared called %s',
	'cloudintegration:notify:subject' => 'New Cloud shared: %s',
	'cloudintegration:notify:body' =>
'%s added a new Cloud shared: %s

Link: %s

%s

View and comment on the Cloud shared:
%s
',

	'river:create:object:cloudintegration' => '%s shared %s',
	'river:comment:object:cloudintegration' => '%s commented on a Cloud shared %s',
	'cloudintegration:river:annotate' => 'a comment on this Cloud shared',
	'cloudintegration:river:item' => 'an item',

	//
	// Api
	// ********

	'cloudintegration:api:sharetype:0' => 'User',
	'cloudintegration:api:sharetypes:0' => 'Users',
	'cloudintegration:api:sharetype:1' => 'Group',
	'cloudintegration:api:sharetypes:1' => 'Groups',
	'cloudintegration:api:sharetype:3' => 'Public link',
	'cloudintegration:api:sharetypes:3' => 'Public links',

	'cloudintegration:api:permissions:1' => 'Read',
	'cloudintegration:api:permissions:2' => 'Update',
	'cloudintegration:api:permissions:4' => 'Create',
	'cloudintegration:api:permissions:8' => 'Delete',
	'cloudintegration:api:permissions:16' => 'Share',
	'cloudintegration:api:permissions:31' => 'All',

	//
	// Widgets
	// ********

	// Shares
	'cloudintegration:widgets:shares:name' => 'Cloud shares',
	'cloudintegration:widgets:shares:description' => 'Share your own public files from Cloud.',
	'cloudintegration:widgets:shares:number:label' => 'Number of shares to display',
	'cloudintegration:widgets:shares:toshare:label' => 'To share',
	'cloudintegration:widgets:shares:toshare:op:public' => 'Public shares only',
	'cloudintegration:widgets:shares:toshare:op:all' => 'All my shares',
	'cloudintegration:widgets:shares:noshare' => 'No Shares.',
	'cloudintegration:widgets:shares:folder:label' => 'Folder to share',
	'cloudintegration:widgets:shares:error' => 'Cloud error.',

	// MetaShares
	'cloudintegration:widgets:metashares:name' => 'Shares',
	'cloudintegration:widgets:metashares:description' => 'Share your Cloud files.',
	'cloudintegration:widgets:metashares:number:label' => 'Number of shares to display',
	'cloudintegration:widgets:metashares:noshare' => 'No Shares.',

	// 
	// Settings
	// ********

	// User Settings
	'cloudintegration:usersettings:message' => '', //Descriptive message
	'cloudintegration:usersettings:label:cloudintegration:url' => 'Cloud server URL (https only)',
	'cloudintegration:usersettings:help:cloudintegration:url' => 'if blank, the default URL will be used.',
	'cloudintegration:usersettings:legend:credentials' => 'Cloud credentials',
	'cloudintegration:usersettings:label:credential:user' => 'User',
	'cloudintegration:usersettings:label:credential:password' => 'Password',
	'cloudintegration:usersettings:label:credential:passwordagain' => 'Repeat password',
	'cloudintegration:usersettings:label:credential:unlink' => 'Unlink account?',
	'cloudintegration:usersettings:error:password' => 'Error: Invalid password',
	'cloudintegration:usersettings:error:credential' => 'Error: Credentials are invalid',
	'cloudintegration:usersettings:error:empty' => 'Error: Credentials not saved, empty fields',
	'cloudintegration:usersettings:info:misconfigured' => 'The Cloud account is misconfigured.',
	'cloudintegration:usersettings:info:configure:here' => 'Configure',

	// General
	'cloudintegration:settings:legend:general' => 'General',
	'cloudintegration:settings:label:secure' => 'Allow unsecured servers (http)',
	'cloudintegration:settings:help:secure' => 'Enable only for debugging, not recommended for production.',
	'cloudintegration:settings:label:url:default' => 'Cloud default server',
	'cloudintegration:settings:help:url:default' => 'Secure server only (https)',
	'cloudintegration:settings:label:url:custom' => 'Allow to use external Cloud servers?',
	'cloudintegration:settings:help:url:custom' => 'The user can choose a different Cloud server.',
	'cloudintegration:settings:label:custom:credential' => 'Enable credential form for Cloud?',
	'cloudintegration:settings:help:custom:credential' => 'Set Cloud server credentials in users settings.',
	'cloudintegration:settings:error:cloudintegration:url:secure' => 'Error: Cloud server is not secure.',

	// User options
	'cloudintegration:settings:legend:users' => 'User options',
	'cloudintegration:settings:label:own:enable' => 'Allow Cloud in user space?',
	'cloudintegration:settings:help:own:enable' => 'If disable, only on groups.',

);

?>
