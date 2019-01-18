<?php

namespace HLV\Cloud\Graphic;

use \HLV\Cloud\Api\WebDAV as WebDAV;
use \HLV\Cloud\Api\OCS as OCS;
use \HLV\Cloud\User\CredentialsHandler as CredentialsHandler;

class Owner {

	private $_webdav = null;
	private $_ocs = null;
	private $_owURL;

	public function __construct($password = '') {

		$schema = parse_url(CredentialsHandler::SERVER(), PHP_URL_SCHEME);
		$host = parse_url(CredentialsHandler::SERVER(), PHP_URL_HOST);
		//$path = parse_url(CredentialsHandler::SERVER(), PHP_URL_PATH);
		$this->_owURL = $schema.'://'.$host;

		$this->_ocs = new OCS($password);
		$this->_ocs->rawData(false);

		$this->_webdav = new WebDAV($password);
		$this->_webdav->rawData(false);
	}

	private function breadcrumb($wdPath, $guid){

		if($guid == ''){
	
			$zone = '/owner/'.elgg_get_logged_in_user_entity()->username;
		}else{

			$zone = '/add/'.$guid;
		}

		if($wdPath == ''){

			elgg_push_breadcrumb(elgg_get_logged_in_user_entity()->name);
		}else{

			elgg_push_breadcrumb(elgg_get_logged_in_user_entity()->name, elgg_get_site_url().\HLV\PLUGIN_URI.$zone);
		}

		$bcExplode = explode('/', $wdPath);

		// breadcrumb
		$uriBread = '/';
		foreach($bcExplode as $key => $bread) {

			if($key < (count($bcExplode) -2)){

				$uriBread .= $bread.'/';
				elgg_push_breadcrumb(urldecode($bread), elgg_get_site_url().\HLV\PLUGIN_URI.$zone.'/'.base64_encode($uriBread));
			}else{

				elgg_push_breadcrumb(urldecode($bread));
			}
		}
	}

	private function getChilds($wdPath){

		$Childs = array();

		$xml = $this->_webdav->getProperties('/'.$wdPath);

		$namespaces = $xml->getNamespaces(true);
		foreach($xml->children($namespaces['d']) as $child) {

			//$Childs[] = ( json_decode(json_encode((array) $child), 1) );
			$Childs[] = $child;
		}

		return $Childs;
	}

	private function getRowHTML($row, $wdname, $wdpath, $owuri ,$is_folder, $guid = ''){

		$link = $wdname;

		if($is_folder){

			if($guid == ''){

				$zone = '/owner/'.elgg_get_logged_in_user_entity()->username;
			}else{

				$zone = '/add/'.$guid;
			}

			$link = '<a href="'.elgg_get_site_url().\HLV\PLUGIN_URI.$zone.'/'.base64_encode($wdpath).'">'.$wdname.'</a>';

		}

		$owurl = $this->_owURL.$owuri;
		$type = 'download';

		if($shared_entity = $this->getEntityByPath($wdpath,$guid)){

			if($is_folder){

				$type = 'view';
			}

			$owurl = $shared_entity->link;

			
			$styleShare = 'display:none;';	
		}else{

			$styleUnshare = 'display:none;';		
		}


		$shareOP = elgg_view('output/url', [
			'id' => 'ciunshare'.\HLV\Functions::seoUrl($wdpath),
			'text' => elgg_view_icon('share-alt-square'),
			'title' => elgg_echo('cloudintegration:unshare'),
			'href' => 'ajax/form/'.\HLV\PLUGIN_ID.'/unshare?guid='.$shared_entity->guid,
			'class' => 'elgg-lightbox cilink',
			'style' => $styleUnshare,
			'data-colorbox-opts' => json_encode([
						'title' =>  elgg_echo('cloudintegration:unshare'),
						'min-width' => '300px',
						'max-width' => '600px',
						])
			]);

		$shareOP .= elgg_view('output/url', [
			'id' => 'cishare'.\HLV\Functions::seoUrl($wdpath),
			'text' => elgg_view_icon('share-alt'),
			'title' => elgg_echo('cloudintegration:share'),
			'href' => 'ajax/form/'.\HLV\PLUGIN_ID.'/share?guid='.$guid.'&name='.base64_encode($wdname).'&path='.base64_encode($wdpath),
			'class' => 'elgg-lightbox cilink',
			'style' => $styleShare,
			'data-colorbox-opts' => json_encode([
						'title' =>  elgg_echo('cloudintegration:share'),
						'min-width' => '300px',
						'max-width' => '600px',
						])
			]);


		if(!$is_folder || $shared_entity != null){

			$owlink = '<a id="'.$type.\HLV\Functions::seoUrl($wdpath).'" class ="cilink" target="_blank" href="'.$owurl.'">'.elgg_echo('cloudintegration:'.$type).'</a>';
		}
		
		return '<li class="cirow'.$row.'">'.$link.$shareOP.$owlink.'</li>';
	}

	private function getEntityByPath($wdPath, $guid = ''){

		if($guid == ''){

			$guid = elgg_get_logged_in_user_entity()->guid;
		}

		$elist = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => \HLV\PLUGIN_ID,
			'metadata_owner_guid' => elgg_get_logged_in_user_guid(),
			'container_guid' => $guid,
			'metadata_name_value_pairs' => array(
							    'name' => 'path',
							    'value' => $wdPath,
							    'operand' => '=',
							    'case_sensitive' => true
							   ),
			'limit' => 0,
		));

		if(count($elist) > 0){

			return $elist[0];
		}

		return false;
	}

	public function getHTML($wdPath, $guid = ''){

		$wdPath = base64_decode($wdPath);

		$this->breadcrumb($wdPath,$guid);

		$wdexplode = explode('/', $wdPath);
		$wdend = end($wdexplode);
		if($wdend == ''){

			$wdend = $wdexplode[(count($wdexplode)-2)];
		}

		$html = '';
		$displayError = false;
		$expID = null;
		$i = 0;

		foreach($this->getChilds($wdPath) as $xml) {

			$explode = explode('/', $xml->href);

			if($expID == null){

				$expID = array_search('webdav',$explode) + 1; 
			}

			$wdname = end($explode);
			if($wdname == ''){

				$wdname = $explode[(count($explode)-2)];
			}

			if($explode[$expID] != '' && $wdend != $wdname){

				$displayError = false;

				$wdname = urldecode($wdname);
				
				$wdPath = '';
				for($ifor = $expID; $ifor < count($explode); $ifor++) {
					$wdPath .= '/'.$explode[$ifor];
				}
				$wdPath = ltrim($wdPath,'/');

				if(isset($xml->propstat->prop->getcontenttype)){
					// file 
					$is_folder = false;
				}else{
					//folder
					$is_folder = true;
				}

				$html .= $this->getRowHTML(($i % 2), $wdname, $wdPath, $xml->href, $is_folder, $guid);

				$i++;
			}
		}

		if($displayError){

			return elgg_echo('cloudintegration:nofiles');
		}

		return '<ul class="cloud">'.$html.'</ul>';
	}

}

?>
