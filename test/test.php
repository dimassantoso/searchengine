<?php
  // echo "First :";
  // $file = fopen("test.txt","r");
  // $result = fgets($file);
  // echo $result;
  //fclose($fn);

$file = fopen("test.txt","r");
$firstLine = fgets($file);

$i=0;
while(!feof($file)){
  $text[$i] = fgets($file)."<br>";
  $i++;
}

fclose($file);
for ($i=0; $i < sizeof($text) ; $i++) { 
	echo $text[$i];
}

?>