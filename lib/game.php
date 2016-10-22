<?php
require_once('database.php');

class PingPongGame{

  private $gameId;
  private $gameInfo;
  private $players;

  function __construct($gameId = NULL, $players = []) {
    $this->gameId = $gameId;

    if($this->gameId){
      $this->$gameInfo = Database::getGame($gameId);
      if(!$game){
        throw new Exception('You tried to play a game that doesnt exist in database!');
      }
    }else{
      Database::addGame($gameId, );
      $this->$gameId = Database::addGame($gameId, count($players));
      foreach ($players as $value) {
        
      }
    }

    $this->players = Database::getPlayersByGame($gameId);

  }

  function addPlayers($players){

  }

  function newRound($loser){

  }

  public function newGame($name, $players){
    //$this->gameId = Database::newGame($name, count($players));
    //$this->gameId = Database::newGame($name, count($players));
  }

}
