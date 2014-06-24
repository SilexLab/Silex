<?php
class T {
	private static $asdf = 'Hallo na';

	public function __call($n, $a) {
		return self::$asdf;
	}

	public static function __callStatic($n, $a) {
		return self::$asdf;
	}

	public static function __get($n) {
		return self::$asdf;
	}
}

// $a = new T();
// echo $a->asdf();
// echo T::asdf();
echo T::$asdf;
