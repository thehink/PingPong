<?php
require_once('database.php');

class PingPongGame{

  public $gameId;
  public $gameInfo;
  public $players = [];

  function __construct($gameId = NULL, $name = '', $playerIds = []) {
    $this->gameId = $gameId;

    if($this->gameId !== NULL){
      $this->gameInfo = Database::getGame($gameId);
      if(!$this->gameInfo){
        throw new Exception('This game doesnt exist in database!');
      }
    }else{
      $this->gameId = Database::addGame($name, count($playerIds));
      $this->gameInfo = Database::getGame($this->gameId);
      $this->addPlayers($playerIds);
    }
    $this->getPlayers();
  }

  function nextRound($eliminatedPlayerId){
    $eliminatedPlayerId = (int)$eliminatedPlayerId;
    $playerStillInGame = array_search($eliminatedPlayerId, array_column($this->players, 'id'));

    if(!is_int($playerStillInGame)){
      throw new Exception("Error, this player is not in the game anymore!");
    }

    $playerCount = count($this->players);

    if($playerCount > 1){
      $this->eliminatePlayer($eliminatedPlayerId);
      array_splice($this->players, $playerStillInGame, 1);
    }

    if(count($this->players) === 1){
      $this->gameFinished();
      return 1;
    }

    return 0;
  }

  function eliminatePlayer($playerId){
    $playerCount = count($this->players);
    $points = ceil(($this->gameInfo['participants'] - $playerCount + 1) * GAME_SCORE_MULTIPLIER);
    Database::updatePlayer($playerId, NULL);
    Database::addGameResult($this->gameId, $playerId, $points, $playerCount);
  }

  function gameFinished(){
    $this->getPlayers();
    $points = ceil($this->gameInfo['participants'] * GAME_SCORE_MULTIPLIER * GAME_WIN_BONUS_MULTIPLIER);
    Database::addGameResult($this->gameId, $this->players[0]['id'], $points, 1);
    Database::updateGame($this->gameId, time());
    Database::updatePlayer($this->players[0]['id'], NULL);
  }

  function getPlayers(){
    $this->players = Database::getPlayersByGame($this->gameId);
    return $this->players;
  }


//mass player add
  function addPlayers($playerIds){
    $this->gameInfo['participants'] += count($playerIds);
    $result = Database::updatePlayers($playerIds, $this->gameId);
    return $result;
  }

  function addPlayer($playerId){
    $this->gameInfo['participants']++;
    $result = Database::updatePlayer($playerId, $this->gameId);
    return $result;
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
