<?php
namespace Bert\Bert;

class Bert
{
	public static function encode($obj)
	{
		return Encoder::encode($obj);
	}

	public static function decode($bert)
	{
		return Decoder::decode($bert);
	}

	public static function ebin($str)
	{
		$bytes = unpack('C*', $str);
		return '<<' . implode(',', $bytes) . '>>';
	}

	public static function a($str)
	{
		return new Atom($str);
	}

	public static function t()
	{
		return new Tuple(func_get_args());
	}

}

