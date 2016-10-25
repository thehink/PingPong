<?php

require_once('database.php');
require_once('utils.php');

class Player{

  public $id;
  public $firstname;
  public $lastname;

  private $db;

  function __construct(){
    //$this->db = Database::getDatabase();
  }

  public function update($gameId){
    $db = Database::getDatabase();

    $sth = $db->prepare('
    UPDATE players
    SET game_id = :game_id
    WHERE id = :id');

    return $sth->execute([
      'id' => $this->id,
      'game_id' => $gameId
    ]);
  }

  public static function updatePlayers($players, $gameId){
    foreach ($players as $player) {
      $player->update($gameId);
    }
  }

  public static function getPlayers(){
    $db = Database::getDatabase();

    $sth = $db->prepare('
        SELECT
          id,
          username,
          firstname,
          lastname,
          game_id
        FROM players');


      $sth->execute();
      return $stmt->fetchAll(PDO::FETCH_CLASS, "Player");
  }

  public static function getPlayersInGame($gameId){

  }

}
