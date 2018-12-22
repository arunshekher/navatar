<?php
/**
 * This file is part of e107dev.box distribution.
 * Copyright (c) 2016-2018, Arun S. Sekher.
 *
 * @category   Plugins
 * @package    Copyright
 * @version    1.0.0
 * @since      1.0.0
 * @author     Arun S. Sekher <arunshekher@hotmail.com>
 * @see        {@link http://github.com/shapeshed/copyright.ee_addon/}
 * @license    {@link http://www.gnu.org/licenses/}
 *
 */

namespace Navatar\Plugin\Controllers;

use Navatar\Plugin\Navatar;

class BaseController extends Navatar
{

	/**
	 * @var instances[] The reference to *Singleton* instances of any child class.
	 */
	private static $instances = [];



	/**
	 * Returns the *Singleton* instance of the called class.
	 *
	 * @return static The *Singleton* instance.
	 */
	protected static function instantiate()
	{
		if ( ! isset( self::$instances[static::class] ) ) {

			self::$instances[static::class] = new static();

		}

		return self::$instances[static::class];
	}





	public static function __callStatic($name, $arguments)
	{
		$class = static::instantiate();

		if (method_exists($class, $name)) {

			return $class->$name(implode(',', $arguments));

		}
		return false;
	}

}