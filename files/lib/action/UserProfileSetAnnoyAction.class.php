<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractSecureAction.class.php');
require_once(WCF_DIR.'lib/data/user/group/Group.class.php');
require_once(WCF_DIR.'lib/system/session/Session.class.php');

/**
 * Sets the user to annoy state
 *
 * @author	Martin Schwendowius (Sani9000)
 * @copyright	2010 - 2011 wbb3addons.de
 * @license 	Creative Commons Attribution-NoDerivs 3.0 Unported License <http://creativecommons.org/licenses/by-nd/3.0/>
 * @package	timwolla.wcf.annoy
 */
class UserProfileSetAnnoyAction extends AbstractSecureAction {
	protected $userID;

	/**
	 * @see AbstractSecureAction::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		//get userID
		if (isset($_REQUEST['userID'])) {
			$this->userID = intval($_REQUEST['userID']);
		} else {
			throw new IllegalLinkException();
		}

		//check admin permission and protect the admin not to annoy himself...
		if (!WCF::getUser()->getPermission('admin.user.canAnnoyUser') || WCF::getUser()->userID == $this->userID) {
			throw new PermissionDeniedException();
		}

	}

	/**
	 * @see AbstractAction::execute()
	 */
	public function execute() {
		parent::execute();

		// check accessible group permissions
		$sql = "SELECT	DISTINCT groupID
			FROM	wcf".WCF_N."_user_to_groups
			WHERE	userID = ".$this->userID;
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			if (!Group::isAccessibleGroup($row['groupID'])) {
				throw new PermissionDeniedException();
			}
		}

		// set user state
		$sql = "UPDATE	wcf".WCF_N."_user
			SET	annoyThisUser = 1
			WHERE	userID = ".$this->userID;
		WCF::getDB()->sendQuery($sql);

		// reset session of the banned user
		Session::resetSessions($this->userID);

		$this->executed();

		// redirect to user page
		HeaderUtil::redirect('index.php?page=User&userID='.$this->userID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>