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

  private $db;

  function __construct(){

  }

  public static function addResult($gameId, $playerId, $points, $place){
    $db->prepare('INSERT INTO results (
      game_id,
      player_id,
      points,
      place
    ) VALUES (
      :game_id,
      :player_id,
      :points,
      :place
    )'0);
  }

  public static function getResult(){

  }

  public static function getResultsByGame(){

  }

  public static function getLeaderboard($season = NULL){

  }

}
