<?php

class Game{

  public $id;
  public $name;
  public $dateStarted;
  public $dateEnded;
  public $participants;
  public $players;

  function __construct(){
    $this->players = $this->getPlayers();
  }

  public function round(){

  }

  public function eliminate($player){
    $player->update(NULL);
    $this->addResult($player, 0, 1);
  }

  public function addResult($player, $score, $place){

  }

  public function getPlayers(){
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

  public static function newGame(){

  }

  public static function getGame($gameId){
    $db = Database::getDatabase();

    $sth = $db->prepare('
        SELECT
          id,
          name,
          date_started,
          date_ended,
          participants,
          season
        FROM games
        WHERE id = :id');


    $sth->execute([
      'id' => $gameId
    ]);
    return $stmt->fetch(PDO::FETCH_CLASS, "Game");
  }

  public static function getGames(){

  }

}
