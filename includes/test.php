<?php



$creds = Array();
$dbfile = fopen('db.txt', 'r') or die("Unable to open DB credentials file!");
$file = fread($dbfile, filesize("db.txt")); 
$file = explode(PHP_EOL, $file);
foreach($file as $i){
    $temp = explode('=', $i);
    $creds += Array($temp[0] => $temp[1]);
}
var_dump($creds);
fclose($dbfile);
print $creds["servername"];

?>