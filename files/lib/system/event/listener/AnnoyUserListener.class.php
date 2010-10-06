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
class NoGuestListener implements EventListener {
	public static $whatDo = array('slow', 'blank', 'redirect');
	public function execute($eventObj, $className, $eventName) {
		if (!WCF::getUser()->annoy) return;
		$do = self::$whatDo[array_rand(self::$whatDo)];
		$this->$do();
	}

	protected function slow() {
		sleep(MathUtil::getRandomValue(ANNOY_SLOW_MIN, ANNOY_SLOW_MAX));
	}

	protected function blank() {
		if (MathUtil::getRandomValue(0, 99) < ANNOY_BLANK_PERCENTAGE) exit;
	}

	protected function redirect() {
		if (MathUtil::getRandomValue(0, 99) < ANNOY_REDIRECT_PERCENTAGE) HeaderUtil::redirect('index.php');
	}
}
?>