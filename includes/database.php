<?php
/*
Class Database

usage:
include_once('database.php');

Database::getNames() -> [Array of names]
*/

class Database{
  static function readNamesFromTxt(){
    $namesText = file_get_contents('names.txt');
    $names = preg_split("/\\r\\n|\\r|\\n/", $namesText);
    return $names;
  }

  static function getPlayers(){
    $nameList = self::readNamesFromTxt();
    sort($nameList);

    $names = [];
    for ($i=0; $i < count($nameList); $i++) {
      array_push($names, [
        'id' => $i,
        'name' => $nameList[$i]
      ]);
    }
    return $names;
  }

  static function getPlayersByIds($arr){
    $names = self::getPlayers();
    $selectedNames = [];

    foreach ($arr as $i => $id) {
      if(array_key_exists($id, $names)){
        array_push($selectedNames, $names[$id]);
      }

    }
    return $selectedNames;
  }
}
