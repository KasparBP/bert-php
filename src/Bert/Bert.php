<?php
namespace Bert;

use Bert\Bert\Bert_Atom;
use Bert\Bert\Bert_Decoder;
use Bert\Bert\Bert_Encoder;
use Bert\Bert\Bert_Tuple;

class Bert
{
	public static function encode($obj)
	{
		return Bert_Encoder::encode($obj);
	}

	public static function decode($bert)
	{
		return Bert_Decoder::decode($bert);
	}

	public static function ebin($str)
	{
		$bytes = unpack('C*', $str);
		return '<<' . implode(',', $bytes) . '>>';
	}

	public static function a($str)
	{
		return new Bert_Atom($str);
	}

	public static function t()
	{
		return new Bert_Tuple(func_get_args());
	}

}

