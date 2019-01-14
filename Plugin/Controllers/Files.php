<?php

namespace Navatar\Plugin\Controllers;

class Files extends Base
{
	/**
	 * Public static alias for both non-static remove methods
	 *  in Navatar\Plugin\Controllers\Files
	 *
	 * @param mixed $mask
	 *
	 * @return mixed
	 */
	public static function remove($mask)
	{
		$file = static::instantiate();

		if ($mask === '*') {
			return $file->removeAll();
		}

		if (is_int($mask)) {
			return $file->removeById($mask);
		}

		return false;
	}


	/**
	 * Removes all navatar images ('glob'ed with '*_navatar.png' wildcard)
	 *  under e_AVATAR_UPLOAD path.
	 *
	 * @return array
	 */
	private function removeAll()
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
	 * Removes given navatar file under e_AVATAR_UPLOAD path
	 *
	 * @param int $userId
	 *
	 * @return mixed
	 */
	private function removeById($userId)
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