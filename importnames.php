<?php
require_once('lib/header.php');

$namesText = file_get_contents('names.txt');
$names = preg_split("/\\r\\n|\\r|\\n/", $namesText);


foreach ($names as $name) {
  $nameSplit = explode(' ', $name);
  print_r($nameSplit);
  $username = mb_strtolower(mb_substr($nameSplit[0], 0, 3) . mb_substr($nameSplit[1], 0, 3));
  echo $username . '<br>';


  Database::query('INSERT IGNORE INTO players (username, firstname, lastname) VALUES(:username, :firstname, :lastname)', [
    'username' => $username,
    'firstname' => $nameSplit[0],
    'lastname' => $nameSplit[1]
  ]);
}
