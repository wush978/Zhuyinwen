<?php

include('./library.php');

$wordList = getWordList();

foreach ($wordList as $key => $value){
	echo "$key  $value <br/>\n";
}



?>