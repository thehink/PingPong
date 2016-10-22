<?php
require_once('database.php');

class PingPongGame{

  public $gameId;
  private $gameInfo;
  private $players = [];

  function __construct($gameId = NULL, $name = '', $players = []) {
    $this->gameId = $gameId;

    if($this->gameId !== NULL){
      $this->gameInfo = Database::getGame($gameId);
      if(!$this->gameInfo){
        throw new Exception('This game doesnt exist in database!');
      }
    }else{
      $this->gameId = Database::addGame($name, count($players));
      $this->gameInfo = Database::getGame($this->gameId);
      foreach ($players as $playerId) {
        $this->addPlayer($playerId);
      }
      $this->getPlayers();
    }
  }

  function getPlayers(){
    $this->players = Database::getPlayersByGame($this->gameId);
    return $this->players;
  }

  function addPlayer($playerId){
    $this->gameInfo['participants']++;
    $result = Database::updatePlayer($playerId, $this->gameId);
    return $result;
  }

  function removePlayer($playerId){
    $result = Database::updatePlayer($playerId, NULL);
    $this->getPlayers();
    return $result;
  }

  function eliminatePlayer($playerId){
    $this->getPlayers();
    $playerCount = count($this->players);
    $place = $playerCount;
    $points = ($this->gameInfo['participants'] - $playerCount + 1) * GAME_SCORE_MULTIPLIER;
    $this->removePlayer($playerId);
    Database::addGameResult($this->gameId, $playerId, $points, $place);
  }

  function playerWin(){
    $this->getPlayers();
    $points = $this->gameInfo['participants'] * GAME_SCORE_MULTIPLIER + GAME_WIN_BONUS;
    Database::addGameResult($this->gameId, $this->players[0]['id'], $points, 1);
    Database::updateGame($this->gameId, time());
    $this->removePlayer($this->players[0]['id']);
  }

  function getResults(){
    return Database::getGameResults($this->gameId);
  }

//playerId should be the player who got eliminated
  function newRound($playerId){

  }

  function addScore(){

  }

  public function newGame($name, $players){
    //$this->gameId = Database::newGame($name, count($players));
    //$this->gameId = Database::newGame($name, count($players));
  }

}
