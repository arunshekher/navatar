<?php

namespace Navatar\Plugin\Controllers;

class Color extends Base
{

	/**
	 * Public static alias for randomColor()
	 *
	 * @return string
	 */
	public static function random()
	{
		$controller = static::instantiate();
		return $controller->randomColor();
	}

	/**
	 * Returns a random color hex value from an array of values
	 *
	 * @return string
	 *  A random hex color value
	 */
	private function randomColor()
	{
		return $this->randomValue($this->bgColors);
	}


	/**
	 * Returns a random index key value pair from the inputted array
	 *
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