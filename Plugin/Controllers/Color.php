<?php

namespace Navatar\Plugin\Controllers;

class Color extends Base
{

	public static function random()
	{
		$controller = static::instantiate();
		return $controller->randomColor();
	}

	/**
	 * Returns a random color hex value from an array
	 * @return string
	 *  A random hex color value
	 */
	private function randomColor()
	{
		$colors = ['#c9d57d', '#a3d2ec', '#e4c165', '#a57b9c', '#697fcd', '#50dea0',
			'#50dea0', '#54738a', '#85b58f', '#333132', '#333132', '#187aab',
			'#fe342b', '#b09171', '#4263a7', '#5cc4ac', '#8fe0e5', '#f9d1ba',
			'#e0c9a4', '#cad3ab', '#bcd3dd', '#92b558', '#B0F566', '#4AF2A1',
			'#6638F0', '#F78AE0', '#FFF095', '#a085d2'];

		return $this->randomValue($colors);

	}


	/**
	 * @param $array
	 *
	 * @return mixed
	 */
	private function randomValue($array)
	{
		$values = array_values($array);
		return $values[mt_rand(0, count($values) - 1)];
	}

}