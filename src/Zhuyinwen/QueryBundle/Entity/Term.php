<?php

namespace Zhuyinwen\QueryBundle\Entity;

class Term 
{
	static protected $phpdata_path = '/termlist.phpdata';
	
	static protected $dictionary = NULL;
	
	static public function query($query) {
		if (is_null(self::$dictionary)) {
			self::$dictionary = unserialize(file_get_contents(__DIR__ . self::$phpdata_path));
		}
		if (array_key_exists($query, self::$dictionary))
			return self::$dictionary[$query];
		else
			return NULL;
	}
}