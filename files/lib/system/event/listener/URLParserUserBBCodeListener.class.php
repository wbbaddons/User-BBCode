<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Parses the [user]-BBCode into URL-Tags
 *
 * @author	Tim Düsterhus
 * @copyright	2011 wbbaddons.de
 * @license 	Creative Commons BY-NC-SA <http://creativecommons.org/licenses/by-nc-sa/3.0/de/>
 * @package 	de.wbbaddons.wcf.bbcode.user
 */
class URLParserUserBBCodeListener implements EventListener {

	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		// the only one we do not get is a username that contains "[/user]". But who would name himself that way? :D
		preg_match_all('~\[user\](.*?)\[/user\]~', URLParser::$text, $matches);

		// sort out duplicates, saves queries
		array_unique($matches[1]);

		foreach ($matches[1] as $match) {
			$user = new User(null, null, $match);
			URLParser::$text = StringUtil::replace('[user]'.$match.'[/user]', '[url=index.php?page=User&amp;userID='.$user->userID.']'.$user->username.'[/url]', URLParser::$text);
		}
	}
}
