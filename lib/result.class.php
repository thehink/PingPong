<?php

require_once('database.php');
require_once('utils.php');

class Result{

  public $id;
  public $gameId;
  public $playerId;
  public $score;
  public $participants;
  public $place;

  function __construct(){

  }

  public static function addResult($gameId, $playerId, $points, $place){
    $db = Database::getDatabase();
    $sth = $db->prepare('INSERT INTO results (
      game_id,
      player_id,
      points,
      place
    ) VALUES (
      :game_id,
      :player_id,
      :points,
      :place
    )');

    $sth->execute(  [
        'game_id' => $gameId,
        'player_id' => $playerId,
        'points' => $points,
        'place' => $place,
      ]);

      return $sth->lastInsertId();
  }

  public static function getResultsByGame($gameId){
    $db = Database::getDatabase();

    $sth = $db->prepare('
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
          ORDER BY results.points DESC
      ');

      $sth->execute([
        'game_id' => $gameId
      ]);

      return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function getLeaderboard($season = NULL){
    $db = Database::getDatabase();

    $sth = $db->prepare('
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
          ORDER BY totalScore DESC
      ');

      $sth->execute([
        'season' => isset($season) ? $season : 0
      ]);

      return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

}
