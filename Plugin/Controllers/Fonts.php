<?php

namespace Navatar\Plugin\Controllers;

class Fonts extends Base
{
	/**
	 * Public static alias for Navatar\Plugin\Controllers\Fonts::listAll()
	 *
	 * @return array|null
	 */
	public static function index()
	{
		$font = static::instantiate();
		return $font->listAll();
	}


	/**
	 * Returns a numeric array of all ttf fonts under
	 *  e_PLUGIN . 'navatar/vendor/lasserafn/php-initial-avatar-generator/src/fonts/'
	 *
	 * @return array|null
	 */
	private function listAll()
	{
		$fontArray = [];
		$fonts = glob(__DIR__ . '/../../vendor/lasserafn/php-initial-avatar-generator/src/fonts/*.ttf');
		foreach ($fonts as $font) {

			$dirname = basename(dirname($font));
			$fontname = basename($font);

			$fontArray[$fontname] = '/' . $dirname . '/' . $fontname;

		}
		return array_flip($fontArray);
	}


}