<?php
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Annoy them :D
 *
 * @author Tim Düsterhus
 * @copyright 2010 Tim Düsterhus
 * @package timwolla.wcf.annoy
 * @license LGPL <http://www.gnu.org/licenses/lgpl.html>
 */
class AnnoyUserListener implements EventListener {
	public static $whatDo = array('slow', 'blank', 'redirect', 'doNothing', 'logout');
	public function execute($eventObj, $className, $eventName) {
		if (!WCF::getUser()->annoyThisUser) return;
		$do = self::$whatDo[array_rand(self::$whatDo)];
		$this->$do();
	}

	protected function logout() {
		require_once(WCF_DIR.'lib/system/session/UserSession.class.php');
		WCF::getSession()->delete();
		// remove cookies
		if (isset($_COOKIE[COOKIE_PREFIX.'userID'])) {
			HeaderUtil::setCookie('userID', 0);
		}
		if (isset($_COOKIE[COOKIE_PREFIX.'password'])) {
			HeaderUtil::setCookie('password', '');
		}
	}

	protected function doNothing() {

	}

	protected function slow() {
		sleep(MathUtil::getRandomValue(ANNOY_SLOW_MIN, ANNOY_SLOW_MAX));
	}

	protected function blank() {
		if (MathUtil::getRandomValue(0, 99) < ANNOY_BLANK_PERCENTAGE) exit;
	}

	protected function redirect() {
		if (MathUtil::getRandomValue(0, 99) < ANNOY_REDIRECT_PERCENTAGE) {
			HeaderUtil::redirect('index.php');
			exit;
		}
	}
}
?>