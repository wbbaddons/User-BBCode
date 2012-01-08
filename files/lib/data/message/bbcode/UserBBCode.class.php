<?php
// wcf imports
require_once(WCF_DIR.'lib/data/message/bbcode/BBCodeParser.class.php');
require_once(WCF_DIR.'lib/data/message/bbcode/BBCode.class.php');

/**
 * Parses the [user]-BBCode.
 *
 * @author	Tim Düsterhus
 * @copyright	2011 wbbaddons.de
 * @license 	Creative Commons BY-ND <http://creativecommons.org/licenses/by-nd/3.0/de/>
 * @package 	de.wbbaddons.wcf.bbcode.user
 */
class UserBBCode implements BBCode {

	/**
	 * @see BBCode::getParsedTag()
	 */
	public function getParsedTag($openingTag, $content, $closingTag, BBCodeParser $parser) {
		$userID = intval(isset($openingTag['attributes'][0]) ? $openingTag['attributes'][0] : 0);

		if ($userID == 0) {
			$user = new User(null, null, StringUtil::decodeHTML($content));
			$userID = $user->userID;
			$content = $user->username;
		}

		if ($parser->getOutputType() == 'text/html') {
			return '<img src="'.StyleManager::getStyle()->getIconPath('userS.png').'" alt="" /> <a href="index.php?page=User&amp;userID='.$userID.'">'.$content.'</a>';
		}
		else if ($parser->getOutputType() == 'text/plain') {
			return $content;
		}
	}
}
