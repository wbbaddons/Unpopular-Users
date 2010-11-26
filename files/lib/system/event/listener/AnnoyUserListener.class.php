<?php
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Annoy them :D
 *
 * @author 	Tim Düsterhus
 * @copyright 	2010 Tim Düsterhus
 * @package 	timwolla.wcf.annoy
 * @license 	LGPL <http://www.gnu.org/licenses/lgpl.html>
 */
class AnnoyUserListener implements EventListener {
	public static $whatDo = array(
		'thizShitDoesNotReallyLookLikeHTMLButItIs', 
		'iDontKnowVasSupWithTheServerButIThinkItIsVerySlow', 
		'noThereIsReallyNoContentGoAwayAndPlaySomewhereElse', 
		'iLiekTehIndexPage', 
		'tihzTimeILiekU', 
		'iThinkUForgotToSetYourAlwaysLoginCookiesAndYourSessionTimedOutNoob'
	);
	public function execute($eventObj, $className, $eventName) {
		if (!WCF::getUser()->annoyThisUser) return;
		$do = self::$whatDo[array_rand(self::$whatDo)];
		$this->$do();
	}

	protected function thizShitDoesNotReallyLookLikeHTMLButItIs() {
		// maybe you can decode it with a pencil, a paper and your head afterwards :)
		if (MathUtil::getRandomValue(0, 99) >= ANNOY_GZIP_PERCENTAGE) return;
		if (HTTP_ENABLE_GZIP && HTTP_GZIP_LEVEL > 0 && HTTP_GZIP_LEVEL < 10 && !defined('HTTP_DISABLE_GZIP')) {
			// break gzip output
			echo ' ';
			ob_start();
			flush();
			ob_flush();
			WCF::getTPL()->display('permissionDenied');
			exit;
		}
	}

	protected function iThinkUForgotToSetYourAlwaysLoginCookiesAndYourSessionTimedOutNoob() {
		if (MathUtil::getRandomValue(0, 99) >= ANNOY_LOGOUT_PERCENTAGE) return;
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

	protected function tihzTimeILiekU() {
		// it looks shitty if the function is empty, so lets fill it with crap
		if (false || (true && 1==0)) {
			while (true || !false) {
				// i'm i yr loop
			}
		}
	}

	protected function iDontKnowVasSupWithTheServerButIThinkItIsVerySlow() {
/*		 ______________________________
		/ zzZzzzzzZZzzzzZZZZZZzzZZZZzZ \
		| zzZzzzzzzZZZzzzzzzZZzzzzzzzZ |
		\ ZzZZzzzZZZzzZZzzZZzzzzZZZzzz /
		 ------------------------------
		        \   ^__^
		         \  (--)\_______
		            (__)\       )\/\
		                ||----w||
		                ||     ||
*/
		sleep(MathUtil::getRandomValue(ANNOY_SLOW_MIN, ANNOY_SLOW_MAX));
	}

	protected function noThereIsReallyNoContentGoAwayAndPlaySomewhereElse() {
		// burp, the content tasted good.
		if (MathUtil::getRandomValue(0, 99) < ANNOY_BLANK_PERCENTAGE) die;
	}

	protected function iLiekTehIndexPage() {
		// yeah, it is really better, than this one :D
		if (MathUtil::getRandomValue(0, 99) < ANNOY_REDIRECT_PERCENTAGE) {
			HeaderUtil::redirect('index.php');
			exit;
		}
	}
}
?>