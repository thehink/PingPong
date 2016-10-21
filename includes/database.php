<?php
/*
Class Database

usage:
include_once('database.php');

Database::getNames() -> [Array of names]
*/

class Database{
  private static $players = [
    'Robert N',
    'Lars K',
    'Joakim R',
    'Benjamin R',
    'Marie E',
    'Maria GN',
    'Axel B',
    'Amin E-R',
    'André H',
    'Carl Å',
    'Christian B',
    'Katarina C',
    'Erica G',
    'Jeremy D',
    'Kristjan F',
    'Mathias K',
    'Signe B',
    'Staffan M',
    'Victor O',
    'Max S',
    'Johannes T',
    'Vincent K',
    'Harry E (Revolutionist)'
  ];

  static function readNamesFromTxt(){

  }

  static function getNames(){
    asort(self::$players);
    return self::$players;
  }

  static function getNamesByIds($arr){
    $names = self::getNames();
    $selectedNames = [];

    foreach ($arr as $i => $id) {
      array_push($selectedNames, $names[$id]);
    }
    return $selectedNames;
  }
}
