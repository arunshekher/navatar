<?php

namespace Navatar\Plugin\Controllers;

class Font
{
	public static function index()
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