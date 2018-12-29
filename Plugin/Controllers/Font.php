<?php

namespace Navatar\Plugin\Controllers;

class Font extends Base
{
	public static function index()
	{
		$controller = static::instantiate();
		return $controller->listAll();
	}


	public function listAll()
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