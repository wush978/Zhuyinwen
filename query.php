<?php

  $query_value = $_GET["query"];
  $database = unserialize(file_get_contents('./termlist.phpdata'));
  print_r($database[$query_value]);
?>