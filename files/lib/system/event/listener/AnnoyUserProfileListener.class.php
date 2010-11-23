<?php
//wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * provides an option to annoy a user in his profile :P
 * 
 * @author	Martin Schwendowius (Sani9000)
 * @copyright	2010 Woltlab Community
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl.html>
 * @package	timwolla.wcf.annoy
 */
class AnnoyUserProfileListener implements EventListener {
	protected $userID;

	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName){
		
		//get userID
		if (isset($_REQUEST['userID'])) $this->userID = intval($_REQUEST['userID']);
		
		//checks admin permission and aborts at own profile
		if (!WCF::getUser()->getPermission('admin.user.canAnnoyUser') || WCF::getUser()->userID == $this->userID) return;
		
		//assign variable
		WCF::getTPL()->assign(array('userID' => $this->userID));
		
		//fetch template
		WCF::getTPL()->append(array('additionalAdminOptions' => WCF::getTPL()->fetch('userProfileAnnoyContent')));
	}
}
?>