<?php
require("config.php");
require("utils.php");

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

  public static function getAllPlayers(){
    return self::fetchAll('
      SELECT
        id,
        username,
        firstname,
        lastname,
        game_id
      FROM players');
  }

  public static function getPlayers($players){
    $in = utils::array_join_int($players, ', ');

    return self::fetchAll('
      SELECT
        username,
        firstname,
        lastname,
        game_id
      FROM players
      WHERE id IN (' . $in . ')');
  }

  public static function getPlayersByGame($gameId){
    return self::fetchAll('
      SELECT
        id,
        username,
        firstname,
        lastname,
        game_id
      FROM players
      WHERE game_id = :game_id',
    [
      'game_id' => $gameId
    ]);
  }


  public static function getGame($gameId){
    return self::fetch('
      SELECT
        id,
        name,
        date_started,
        date_ended,
        participants
      FROM games
      WHERE id = :id LIMIT 1',
    [
      'id' => $gameId
    ]);
  }

  public static function addGame($name, $participants){
    return self::insert('
    INSERT INTO games (
      name,
      participants
    ) VALUES (
      :name,
      :participants
    )',
    [
      'name' => $name,
      'participants' => $participants
    ]);
  }

  public static function updateGame($gameId, $time){
    return self::query('
      UPDATE games
      SET date_ended = NOW()
      WHERE id = :id',
    [
      'id' => $gameId
    ]);
  }

  public static function updatePlayer($playerId, $gameId){
    return self::query('
      UPDATE players
      SET game_id = :game_id
      WHERE id = :id',
    [
      'id' => $playerId,
      'game_id' => $gameId
    ]);
  }

  public static function updatePlayers($playerIds, $gameId){
    $in = utils::array_join_int($playerIds, ', ');

    return self::query('
      UPDATE players
      SET game_id = :game_id
      WHERE id IN (' . $in . ')',
    [
      'game_id' => $gameId
    ]);
  }

  public static function addGameResult($gameId, $playerId, $points, $place){
    return self::insert('
      INSERT INTO results (
        game_id,
        player_id,
        points,
        place
      ) VALUES (
        :game_id,
        :player_id,
        :points,
        :place
      )',
    [
      'game_id' => $gameId,
      'player_id' => $playerId,
      'points' => $points,
      'place' => $place,
    ]);
  }

  public static function getGameResults($gameId){
    return self::fetchAll("
          SELECT
            players.username,
            players.firstname,
            players.lastname,
            results.points,
            results.place,
            results.time
          FROM results
          INNER JOIN players
          ON players.id = results.player_id
          WHERE results.game_id = :game_id
          ORDER BY results.points DESC",
    [
      'game_id' => $gameId
    ]);
  }

  public static function getLeaderboard(){
    return self::fetchAll('
        SELECT
          players.id,
          players.username,
          players.firstname,
          players.lastname,
          COUNT(results.game_id) as gamesPlayed,
          SUM(results.points) as totalScore,
          SUM(CASE WHEN results.place = 1 then 1 else 0 end) as firstPlace,
          SUM(CASE WHEN results.place = 2 then 1 else 0 end) as secondPlace,
          SUM(CASE WHEN results.place = 3 then 1 else 0 end) as thirdPlace
        FROM results
        INNER JOIN players
        ON players.id = results.player_id
        GROUP BY results.player_id
        ORDER BY totalScore DESC');
  }

}

Database::init();
