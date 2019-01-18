<?php
/**
 * CloudIntegration Plugin
 */

 // TODO
 // Si desactivas Cloud en un grupo con ficheros vinculados aparece en la lista All (no deberia de ser así)
 // Cuando borras un archivo desde su view devuelve que no existe (por que ya no existe una entidad asociada a esa url)
 // ¿Que hacer si el enlace no funciona?
 // Multivinculo de un mismo archivo (compartir el mismo archivo en diferentes grupos...)
 // Añadir Multicuenta (Diferentes credenciales)
 
namespace HLV;

const PLUGIN_ID = 'cloudintegration';
const PLUGIN_URI = 'cloud';

// Class Handlers
Cloud\Encrypt\EncryptHandler::SET_HANDLER('\HLV\Cloud\Encrypt\OpenSSL');
Cloud\User\CredentialsHandler::SET_HANDLER('\HLV\Cloud\User\Credentials');

// Encrypt Seed
Cloud\Encrypt\EncryptHandler::SET_SEED('?2Yr:SZ-B:gUPLwz=~`#B_!VJZ;[a!4&GA72}^^P]YDnz#_{}Q4774Jh"Y>gd4]<');

//register the plugin hook handler
elgg_register_event_handler('init', 'system', __NAMESPACE__.'\\init');

/**
 * plugin init function
 */
function init() {

	// extend css && js
	elgg_extend_view('css/elgg', PLUGIN_ID.'/style.css');
	elgg_extend_view('js/elgg', PLUGIN_ID.'/script.js');

	// site menu
	if(Functions::SETTING_BOOL('enable_users')){

		elgg_register_menu_item('site', array(
			'name' => PLUGIN_ID,
			'text' => elgg_echo('cloudintegration'),
			'href' => PLUGIN_URI.'/all',
		));
	}
	
	// routing of urls
	elgg_register_page_handler(PLUGIN_URI, __NAMESPACE__.'\\page_handler');

	// add CloudIntegration link to
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', __NAMESPACE__.'\\owner_block_menu');

	// override the default url to view a blog object
	elgg_register_plugin_hook_handler('entity:url', 'object', __NAMESPACE__.'\\set_url');

	// Register a plugin hook handler for the entity menu
    	elgg_register_plugin_hook_handler('register', 'menu:entity',  __NAMESPACE__.'\\menu_handler');

	// Register for notifications
	elgg_register_notification_event('object', PLUGIN_ID, array('create'));
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:'.PLUGIN_ID , __NAMESPACE__.'\\prepare_notification');

	// Register for search.
	elgg_register_entity_type('object', PLUGIN_ID);

	// Add group option
	add_group_tool_option(PLUGIN_ID, elgg_echo('cloudintegration:group:tool:option:enable'), true);
	// Extend group main page
	elgg_extend_view('groups/tool_latest', PLUGIN_ID.'/group_module');

	// Add Shares widget
	elgg_register_widget_type(	'shares', 
					elgg_echo('cloudintegration:widgets:shares:name'), 
					elgg_echo('cloudintegration:widgets:shares:description'), 
					array('dashboard'), 	// Context
					true); 					// Multiple
	elgg_register_widget_type(	'metaShare', 
					elgg_echo('cloudintegration:widgets:metashares:name'), 
					elgg_echo('cloudintegration:widgets:metashares:description'), 
					array('all'), 			// Context
					true); 					// Multiple

	// Actions
	elgg_register_action(PLUGIN_ID."/share", __DIR__ . "/actions/".PLUGIN_ID."/share.php");
	elgg_register_action(PLUGIN_ID."/unshare", __DIR__ . "/actions/".PLUGIN_ID."/unshare.php");
	elgg_register_action(PLUGIN_ID."/edit", __DIR__ . "/actions/".PLUGIN_ID."/edit.php");
	elgg_register_action(PLUGIN_ID."/visibility", __DIR__ . "/actions/".PLUGIN_ID."/visibility.php");

	// Ajax View
	elgg_register_ajax_view('forms/'.PLUGIN_ID.'/share');
	elgg_register_ajax_view('forms/'.PLUGIN_ID.'/unshare');

	// ecml
	elgg_register_plugin_hook_handler('get_views', 'ecml',  __NAMESPACE__.'\\ecml_views_hook');

	// allow to be liked
	elgg_register_plugin_hook_handler('likes:is_likable', 'object:'.PLUGIN_ID , 'Elgg\Values::getTrue');

}

/*
 * Dispatches plugin pages.
 * URLs take the form of
 *  All cloudintegration:	 cloud/all
 *  User's cloudintegration:     cloud/owner/<username>
 *  Friends' cloudintegration:   cloud/friends/<username>
 *  view file cloudintegration:  cloud/view/<guid>/<title>
 *  New file cloudintegration:   cloud/add/<guid>
 *  Edit file cloudintegration:  cloud/edit/<guid>
 *  Group cloudintegration:      cloud/group/<guid>/all
 *
 * Title is ignored
 *
 * @param array $page
 * @return bool
 */
function page_handler($page) {

	$page_type = elgg_extract(0, $page, 'all');
	$resource_vars = [
		'page_type' => $page_type,
	];

	switch ($page_type) {
		case 'owner':
			if(Functions::SETTING_BOOL('enable_users')){

				$resource_vars['username'] = elgg_extract(1, $page);
				$resource_vars['webdavpath'] = elgg_extract(2, $page);

				elgg_push_breadcrumb(elgg_echo('cloudintegration'), PLUGIN_URI.'/all');
				echo elgg_view_resource(PLUGIN_ID.'/owner', $resource_vars);
				
			}else{
				return false;
			}

			break;
		case 'friends':
			if(Functions::SETTING_BOOL('enable_users') && elgg_is_logged_in()){

				$resource_vars['username'] = elgg_extract(1, $page);
			
				elgg_push_breadcrumb(elgg_echo('cloudintegration'), PLUGIN_URI.'/all');
				echo elgg_view_resource(PLUGIN_ID.'/friends', $resource_vars);
				
			}else{
				return false;
			}

			break;
		case 'view':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			elgg_push_breadcrumb(elgg_echo('cloudintegration'), PLUGIN_URI.'/all');
			echo elgg_view_resource(PLUGIN_ID.'/view', $resource_vars);
			break;
		case 'add':
			if(elgg_is_logged_in()){

				$resource_vars['guid'] = elgg_extract(1, $page);
				$resource_vars['webdavpath'] = elgg_extract(2, $page);
			
				elgg_push_breadcrumb(elgg_echo('cloudintegration'), PLUGIN_URI.'/all');
				echo elgg_view_resource(PLUGIN_ID.'/add', $resource_vars);
				
			}else{
				return false;
			}

			break;
		case 'edit':
			if(elgg_is_logged_in()){
				$resource_vars['guid'] = elgg_extract(1, $page);
			
				elgg_push_breadcrumb(elgg_echo('cloudintegration'), PLUGIN_URI.'/all');
				echo elgg_view_resource(PLUGIN_ID.'/edit', $resource_vars);
				
			}else{
				return false;
			}

			break;
		case 'group':
			$resource_vars['page_type'] = elgg_extract(0, $page);
			$resource_vars['group_guid'] = elgg_extract(1, $page);
			$resource_vars['subpage'] = elgg_extract(2, $page);
			$resource_vars['lower'] = elgg_extract(3, $page);
			$resource_vars['upper'] = elgg_extract(4, $page);
			
			// Breadcrumb for groups
			$g_entity = get_entity($resource_vars['group_guid']);
			elgg_push_breadcrumb(elgg_echo('cloudintegration:group').' '.$g_entity->name, PLUGIN_URI.'/group/'.$resource_vars['group_guid'].'/all');
			
			echo elgg_view_resource(PLUGIN_ID.'/group', $resource_vars);
			break;
		case 'all':
			if(Functions::SETTING_BOOL('enable_users')){

				elgg_push_breadcrumb(elgg_echo('cloudintegration'), PLUGIN_URI.'/all');
				echo elgg_view_resource(PLUGIN_ID.'/all', $resource_vars);
				
			}else{
				return false;
			}

			break;
		default:
			return false;
	}

	return true;
}

/**
 * Add a menu item to an ownerblock
 */
function owner_block_menu($hook, $type, $return, $params) {

	if (elgg_instanceof($params['entity'], 'user')) {
		if(Functions::SETTING_BOOL('enable_users')){
			$url = PLUGIN_URI."/owner/{$params['entity']->username}";
			$item = new \ElggMenuItem(PLUGIN_ID, elgg_echo('cloudintegration'), $url);
			$return[] = $item;
		}
	} else {
		if ($params['entity']->{PLUGIN_ID.'_enable'} != "no") {
			$url = PLUGIN_URI."/group/{$params['entity']->guid}/all";
			$item = new \ElggMenuItem(PLUGIN_ID, elgg_echo('cloudintegration:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Format and return the URL for CloudIntegration.
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string URL of Ownlcoud.
 */
function set_url($hook, $type, $url, $params) {
	
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', PLUGIN_ID)) {
		$friendly_title = elgg_get_friendly_title($entity->title);
		return PLUGIN_URI."/view/{$entity->guid}/$friendly_title";
	}
}

/**
 * Customize the entity menu for CloudIntegration objects
 */
function menu_handler($hook, $type, $menu, $params) {
	
    // The entity can be found from the $params parameter
    $entity = $params['entity'];

    // We want to modify only the ElggOW objects, so we
    // return immediately if the entity is something else
	$handler = elgg_extract('handler', $params, false);
	if ($handler != PLUGIN_URI) {
		return $return;
	}

	$context = null;

	foreach ($menu as $key => $item) {
	    switch ($item->getName()) {
            case 'edit':
                // Change the "Edit" text into a custom icon
                $item->setText(elgg_view_icon('pencil'));
				$context = $item->getContext();
 				//unset($menu[$key]);
	                break;
			case 'delete':
                // Remove the "Delete" menu item
                unset($menu[$key]);
                    break;
	        }
	}

	// Get options data
	$container = get_entity($entity->container_guid);
	$canEdit = $container->canEdit();
	$visible = filter_var($entity->visible, FILTER_VALIDATE_BOOLEAN);

	$displayV = 'display:block;';
	$displayI = 'display:none;';
	if(!$visible){
		$displayV = 'display:none;';
		$displayI = 'display:block;';
	}

	if($canEdit){

		// Visibility button
		$optionsVisible = array(
			'id' => 'civisible'.$entity->guid,
			'name' => 'visible',
			'title' => elgg_echo('cloudintegration:visible:true'),
			'text' =>  elgg_view_icon('eye'),
			'style' => $displayV,
			'link_class' => 'ciiconvisiblefix',
			'onclick' => 'CloudIntegration.visibility('.$entity->guid.',false);return false;',	
			'priority' => 100,
		);
	
		$Visible = \ElggMenuItem::factory($optionsVisible);
		$Visible->addItemClass("cilivisiblefix");
		$Visible->setContext($context);
		
	
		// Invisibility button
		$optionsInvisible = array(
			'id' => 'ciinvisible'.$entity->guid,
			'name' => 'invisible',
			'title' => elgg_echo('cloudintegration:visible:false'),
			'text' =>  elgg_view_icon('eye-slash'),
			'style' => $displayI,
			'link_class' => 'ciiconvisiblefix',
			'onclick' => 'CloudIntegration.visibility('.$entity->guid.',true);return false;',
			'priority' => 100,
		);
			
		$Invisible = \ElggMenuItem::factory($optionsInvisible);
		$Invisible->addItemClass("cilivisiblefix");
		$Invisible->setContext($context);
		
		// Sort icons
		$menu[] = $Invisible;
		$menu[] = $Visible;
	
		// Unshare
		$optionsUnshare = array(
			'id' => 'ciunshare'.$entity->guid,
			'name' =>  'unshare',
			'title' =>  elgg_echo('cloudintegration:unshare'),
			'text' =>  elgg_view_icon('share-alt-square'),
			'href' => 'ajax/form/'.PLUGIN_ID.'/unshare?guid='.$entity->guid,
			'priority' => 1010,
			'link_class' => 'elgg-lightbox owlink',
			'data-colorbox-opts' => json_encode([
						'title' =>  elgg_echo('cloudintegration:unshare'),
						'min-width' => '300px',
						'max-width' => '600px',
						]),
		);
	    $Unshare = \ElggMenuItem::factory($optionsUnshare);
		$Unshare->setContext($context);
		$menu[] = $Unshare;

	}

	return $menu;
	
}

/**
 * Prepare a notification message about a new owncloud metadata
 * 
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg\Notifications\Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg\Notifications\Notification
 */
function prepare_notification($hook, $type, $notification, $params) {
	
	$entity = $params['event']->getObject();
	$owner = $params['event']->getActor();
	$recipient = $params['recipient'];
	$language = $params['language'];
	$method = $params['method'];

	// Title for the notification
	$notification->subject = elgg_echo('cloudintegration:notify:subject', array($entity->title), $language);

	// Message body for the notification
	$notification->body = elgg_echo('cloudintegration:notify:body', array(
		$owner->name,
		$entity->title,
		$entity->getExcerpt(),
		$entity->getURL()
	), $language);

	// Short summary about the notification
	$notification->summary = elgg_echo('cloudintegration:notify:summary', array($entity->title), $language);

	return $notification;
}

/**
 * Register CloudIntegration with ECML.
 */
function ecml_views_hook($hook, $entity_type, $return_value, $params) {
	
	$return_value['object/'.PLUGIN_ID] = elgg_echo('cloudintegration:cloudintegrations');

	return $return_value;
}
