<?php

require_once('database.php');
require_once('utils.php');

class Player{

  public $id;
  public $username;
  public $firstname;
  public $lastname;
  public $gameId;

  private $db;

  function __construct(){
    //$this->db = Database::getDatabase();
  }

  public function updateGame($gameId){
    $db = Database::getDatabase();
    $this->gameId = $gameId;

    $sth = $db->prepare('
    UPDATE players
    SET game_id = :game_id
    WHERE id = :id');

    return $sth->execute([
      'id' => $this->id,
      'game_id' => $gameId
    ]);
  }

  public static function updatePlayers($playerIds, $gameId){
/*
    $playerIds = array_map($players, function($player){
      return $player->id;
    });*/
    $db = Database::getDatabase();

    $playerIdsJoined = utils::array_join_int($playerIds, ',');

    $sth = $db->prepare('
      UPDATE players
      SET game_id = :game_id
      WHERE id IN (' . $playerIdsJoined . ')
    ');

    return $sth->execute([
      'game_id' => $gameId,
      //'player_ids' => $playerIdsJoined
    ]);
  }

  public static function getPlayers(){
    $db = Database::getDatabase();

    $sth = $db->prepare('
        SELECT
          id,
          username,
          firstname,
          lastname,
          game_id as gameId
        FROM players');

      $sth->execute();
      return $stmt->fetchAll(PDO::FETCH_CLASS, "Player");
  }
}
