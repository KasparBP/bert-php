<?php
namespace Bert\Bert;

class Encoder
{
	/**
	 * Encode a PHP object into a BERT.
   * @param $obj is the object
   * @return string The serialized object
   */
	public static function encode($obj)
	{
		$complexObj = self::convert($obj);
		return Encode::encode($complexObj);
	}

	/**
	 * Convert complex PHP type to a simple BERT compatible PHP type.
	 * @param $obj is the object to convert
	 *
	 * @return object
	 */
	public static function convert($obj)
	{
		if (is_array($obj) && self::_isDict($obj))
		{
			$pairs = array();
			foreach ($obj as $k => $v)
			{
				$pairs []= array(
					self::convert($k),
					self::convert($v),
				);
			}

			return new Tuple(array(
				Atom::bert(),
				new Atom('dict'),
				$pairs,
			));
		}
		elseif ($obj instanceof Tuple)
		{
			return new Tuple(
				array_map(
					array('Encoder', 'convert'),
					iterator_to_array($obj)));
		}
		elseif ($obj instanceof Time)
		{
			return new Tuple(array(
				Atom::bert(),
				new Atom('time'),
				$obj->megaseconds,
				$obj->seconds,
				$obj->microseconds,
			));
		}
		elseif ($obj instanceof Regex)
		{
			return new Tuple(array(
				Atom::bert(),
				new Atom('regex'),
				$obj->source,
				array_map(array('Bert','a'), $obj->options) // atom-ise options
			));
		}
		elseif (is_array($obj))
		{
			return array_map(array('Encoder', 'convert'), $obj);
		}
		elseif ($obj === null)
		{
			return new Tuple(array(
				Atom::bert(),
				Atom::nil(),
			));
		}
		elseif ($obj === true)
		{
			return new Tuple(array(
				Atom::bert(),
				Atom::true(),
			));
		}
		elseif ($obj === false)
		{
			return new Tuple(array(
				Atom::bert(),
				Atom::false(),
			));
		}
		else
		{
			return $obj;
		}
	}

	// Check if array is associative or not.. stolen from a comment on php.net
	private static function _isDict($array)
	{
		return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
	}
}
