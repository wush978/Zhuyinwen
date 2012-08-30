<?php

namespace Zhuyinwen\QueryBundle\Entity;

class Term 
{
	static protected $phpdata_path = '/termlist.phpdata';
	
	static protected $dictionary = NULL;
	
	static public function query($query) {
		$retval = self::query_internal($query);
		if (!is_array($retval)) {
			return "查無資料";
		}
		else {
			$retval_string = '<ul>';
			foreach($retval as $value) {
				$retval_string .= "<li>$value</li>";
			}
			$retval_string .= '</ul>';
			return $retval_string;
		}
	}
	
	static private function query_internal($query) {
		if (is_null(self::$dictionary)) {
			self::$dictionary = unserialize(file_get_contents(__DIR__ . self::$phpdata_path));
		}
		if (array_key_exists($query, self::$dictionary))
			return self::$dictionary[$query];
		else
			return NULL;
	}
}