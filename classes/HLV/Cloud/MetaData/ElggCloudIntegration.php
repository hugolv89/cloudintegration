<?php

namespace HLV\Cloud\MetaData;

class ElggCloudIntegration extends \ElggObject {

	/**
	 * Set subtype to CloudIntegration.
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = \HLV\PLUGIN_ID;
	}

	/**
	 * Can a user comment on this CloudIntegration file?
	 *
	 * @see ElggObject::canComment()
	 *
	 * @param int $user_guid User guid (default is logged in user)
	 * @return bool
	 * @since 1.8.0
	 */
	public function canComment($user_guid = 0) {

		$result = parent::canComment($user_guid);

		if ($result == false) {

			return false;
		}
		/*
		if ($this->comments_system == 'Off') {
			return false;
		}
		*/
		return true;
	}

}

?>
