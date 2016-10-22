<?php
require("config.php");

class Database{

  private static $connection;

//create database connection
  public static function init(){
    self::$connection = new PDO('mysql:dbname='. DB_NAME .';host='. DB_HOST .';charset=utf8', DB_USER, DB_PASSWORD);
    self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public static function getDatabase(){
    return self::$connection;
  }

  public static function query($statement, $values = []){
    $preparedStatement = self::$connection->prepare($statement);
    return $preparedStatement->execute($values);
  }

  public static function insert($statement, $values = []){
    $sth = self::$connection->prepare($statement);
    $sth->execute($values);
    return self::$connection->lastInsertId();
  }

  public static function fetch($statement, $values = []){
    $sth = self::$connection->prepare($statement);
    $sth->execute($values);
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public static function fetchAll($statement, $values = []){
    $sth = self::$connection->prepare($statement);
    $sth->execute($values);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public static function getPlayers($players){
    $in = array_map(function($id){
      return (int)$id;
    }, $players);
    $in = join(', ', $in);

    return self::fetchAll('SELECT username, firstname, lastname, game_id FROM players WHERE id IN (' . $in . ')');
  }

  public static function getPlayersByGame($gameId){
    return self::fetchAll('SELECT username, firstname, lastname, game_id FROM players WHERE game_id = :game_id',
    [
      'game_id' => $gameId
    ]);
  }


  public static function getGame($gameId){
    return self::fetch('SELECT name, date_started, date_ended, participants FROM games WHERE id = :id LIMIT 1',
    [
      'id' => $gameId
    ]);
  }

  public static function addGame($name, $participants){
    return self::insert('INSERT INTO games (name, participants) VALUES (:name, :participants)',
    [
      'name' => $name,
      'participants' => $participants
    ]);
  }

  public static function addParticipants($players){
    return self::query('INSERT INTO games (name, participants) VALUES (:name, :participants)',
    [
      'name' => $gameId,
      'participants' => $participants
    ]);
  }

}

Database::init();
