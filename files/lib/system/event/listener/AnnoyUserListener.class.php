<?php
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Annoy them :D
 *
 * @author	Tim Düsterhus (TimWolla)
 * @copyright	2010 wbb3addons.de
 * @license 	Creative Commons Attribution-NoDerivs 3.0 Unported License <http://creativecommons.org/licenses/by-nd/3.0/>
 * @package	timwolla.wcf.annoy
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
	
	/**
	 * Shows raw gzip output
	 */
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
	
	/**
	 * Logs the user out
	 */
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
	
	/**
	 * Does nothing
	 */
	protected function tihzTimeILiekU() {
		// it looks shitty if the function is empty, so lets fill it with crap
		if (false || (true && 1==0)) {
			while (true || !false) {
				// i'm i yr loop
			}
		}
	}
	
	/**
	 * Makes the page slow (waits bevor working)
	 */
	protected function iDontKnowVasSupWithTheServerButIThinkItIsVerySlow() {
/*		 This is a cow >:[
		 ______________________________
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
	
	/**
	 * Shows a blank page
	 */
	protected function noThereIsReallyNoContentGoAwayAndPlaySomewhereElse() {
		// "Knock knock!" "Who's there?" "Me, i kill you!" 
		// <http://www.youtube.com/watch?v=D2AfZEYKxzA>
		if (MathUtil::getRandomValue(0, 99) < ANNOY_BLANK_PERCENTAGE) die;
	}
	
	/**
	 * Redirects to index
	 */
	protected function iLiekTehIndexPage() {
		// yeah, it is really better, than this one :D
		if (MathUtil::getRandomValue(0, 99) < ANNOY_REDIRECT_PERCENTAGE) {
			HeaderUtil::redirect('index.php');
			exit;
		}
	}
}
// hello sani :D
// if the cow gets a horse i will kill you
?>