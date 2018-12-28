<?php

namespace Navatar\Plugin\Controllers;

class File extends Base
{
	/**
	 * Public static alias for all non-static remove methods
	 *
	 * @param mixed $mask
	 *
	 * @return array
	 */
	public static function remove($mask)
	{
		$controller = static::instantiate();

		if ($mask === '*') {
			return $controller->removeAll();
		}

		return $controller->removeGiven($mask);
	}


	/**
	 * Removes all navatar images (detected with '*_navatar.png' wildcard)
	 *  under e_AVATAR_UPLOAD path.
	 *
	 * @return array
	 */
	protected function removeAll()
	{
		$unlinkStatus = [];
		$files = glob(e_AVATAR_UPLOAD . '*_navatar.png');

		foreach ($files as $filename) {

			if (is_file($filename) && @unlink($filename)) {
				// delete success
				$unlinkStatus['success'][] = $filename;
			} else if (is_file($filename)) {
				// unlink failed.
				$unlinkStatus['fail'][] = $filename;
			} else {
				// file doesn't exist
				$unlinkStatus['desist'][] = $filename;
			}

		}

		return $unlinkStatus;
	}


	/**
	 * Removes given file
	 *
	 * @param int $userId
	 *
	 * @return mixed
	 */
	protected function removeGiven($userId)
	{
		$tp = \e107::getParser();
		$path = e_AVATAR_UPLOAD;
		$filename = $path . 'ap_' . $tp->leadingZeros($userId, 7) . '.png';

		if (is_file($filename) && @unlink($filename)) {
			// delete success
			return 'success';
		} else if (is_file($filename)) {
			// unlink failed.
			return 'failed';
		} else {
			// file doesn't exist
			return 'nofile';
		}

	}


}