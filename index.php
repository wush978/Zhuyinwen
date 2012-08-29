<?php

include('./library.php');

$wordList = getWordList();
$zhuyinwenList = getZhuyinwenList($wordList);

$input = "ㄍ";


foreach($zhuyinwenList[$input] as $key => $value){

  exec("cat ./tsi.src|cut -d \" \" -f 1|grep '$value'",$matches);
  //print_r($matches);
  //break;

  for ($i=0; $i < count($matches); $i++) { 
    for ($j=0; $j < 1; $j++) { 
      $word= mb_substr($matches[$i],$j,$j+1);
      echo "$word ";
    }
    echo "<br/>\n";
    break;
  }
    
  
  
}


?>