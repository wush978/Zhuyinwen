<?php
	//
// Replace the mb_substr function if it is not compiled into PHP
if( !function_exists( 'mb_substr' ) ) {
	function mb_substr( $string, $offset, $length = null, $type = 'utf8' ) {
   // If not a mutibyte string, use the old substr() function
		if( $type != 'utf8' ) {
			return substr( $string , $offset, $length );
		}
   // generates E_NOTICE
   // for PHP4 objects, but not PHP5 objects
		$string = (string)$string;
		$offset = (int)$offset;
		if (!is_null($length)) $length = (int)$length;
   // handle trivial cases
		if ($length === 0) return '';
		if ($offset < 0 && $length < 0 && $length < $offset)
			return '';
   // normalise negative offsets (we could use a tail
   // anchored pattern, but they are horribly slow!)
		if ($offset < 0) {
    // see notes
			$strlen = strlen(utf8_decode($string));
			$offset = $strlen + $offset;
			if ($offset < 0) $offset = 0;
		}
		$Op = '';
		$Lp = '';
   // establish a pattern for offset, a
   // non-captured group equal in length to offset
		if ($offset > 0) {
			$Ox = (int)($offset / 65535);
			$Oy = $offset%65535;
			if ($Ox) {
				$Op = '(?:.{65535}){'.$Ox.'}';
			}
			$Op = '^(?:'.$Op.'.{'.$Oy.'})';
		} else {
    // offset == 0; just anchor the pattern
			$Op = '^';
		}
   // establish a pattern for length
		if (is_null($length)) {
    // the rest of the string
			$Lp = '(.*)$';
		} else {
			if (!isset($strlen)) {
         // see notes
				$strlen = strlen(utf8_decode($string));
			}
    // another trivial case
			if ($offset > $strlen) return '';
			if ($length > 0) {
         // reduce any length that would
         // go passed the end of the string
				$length = min($strlen - $offset, $length);
				$Lx = (int)( $length / 65535 );
				$Ly = $length % 65535;
         // negative length requires a captured group
         // of length characters
				if ($Lx) $Lp = '(?:.{65535}){'.$Lx.'}';
				$Lp = '('.$Lp.'.{'.$Ly.'})';
			} else if ($length < 0) {
				if ( $length < ($offset - $strlen) ) {
					return '';
				}
				$Lx = (int)((-$length) / 65535);
				$Ly = (-$length)%65535;
         // negative length requires ... capture everything
         // except a group of  -length characters
         // anchored at the tail-end of the string
				if ($Lx) $Lp = '(?:.{65535}){'.$Lx.'}';
				$Lp = '(.*)(?:'.$Lp.'.{'.$Ly.'})$';
			}
		}
		if (!preg_match( '#' . $Op . $Lp . '#us', $string, $match)) {
			return '';
		}
		return $match[1];
	}
}


function getWordList(){
	$wordList = array();
	$fp = fopen('./words_utf8.dat','r');
	while(fscanf($fp,"%s %s %s",$word,$zhuyinwen,$cangjie)){
		if(ereg("%.*",$word)){
			continue;	
		}	
		//printf("%s<br/>\n",$word);	
		$zhuyinwen_part[0] = mb_substr($zhuyinwen,0,1);
		//printf("%s<br/>\n",$zhuyinwen);
		//printf("%s<br/>\n",$zhuyinwen_part[0]);	
		//printf("%s<br/>\n",$cangjie);	
		//ereg("(\W+)\w+(\W+)\w+(\W+)",$line,$matches);
		//print_r($matches);
		//echo "<br>\n";
		//$wordList[$word] = $zhuyinwne_part[0];
		$wordList[$word] = $zhuyinwen_part[0];
	}
	fclose($fp);
	return $wordList;
}
function getZhuyinwenList($wordList){
  $zhuyinwneList = array();
  foreach ($wordList as $word => $zhuyinwen){
    $zhuyinwenList[$zhuyinwen][] = $word;
  }
  return $zhuyinwenList;
}

function debugPrint($zhuyinwenList){
  
  foreach ($zhuyinwenList as $key => $value){
    echo "$key ";
    foreach($value as $k => $v){
      echo " $v";
    }
    echo "<br/>\n ";
  }
}



?>