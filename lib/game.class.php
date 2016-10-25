<?php

require_once('result.class.php');
require_once('player.class.php');

class Game{

  public $id;
  public $name;
  public $dateStarted;
  public $dateEnded;
  public $participants;
  public $players;

  function __construct($id = NULL){
    $this->getPlayers();
  }

  public function nextRound($eliminatedPlayerId){
    $playerCount = count($this->players);
    if($playerCount > 1){
      $this->eliminate($eliminatedPlayerId);
    }

    if($playerCount === 1){
      $this->completed();
    }
  }

  public function completed(){
    $player = $players[0];
    $points = ceil($this->participants * GAME_SCORE_MULTIPLIER * GAME_WIN_BONUS_MULTIPLIER);
    $player->updateGame(NULL);
    $this->addResult($player, $points, 1);
    array_splice($players, 0, 1);
  }

  public function eliminate($playerId){
    $playerCount = count($this->players);
    $playerKey = array_search($playerId, array_column($this->players, 'id'));
echo is_null($playerKey);
    //check if player is still in game
    if(!array_key_exists($playerKey, $this->players)){
      throw new Exception("Error, this player is not in the game anymore!");
    }

    $player = $this->players[$playerKey];
    $points = ceil(($this->participants - $playerCount + 1) * GAME_SCORE_MULTIPLIER);
    $player->updateGame(NULL);
    $this->addResult($player, $points, $playerCount);
    array_splice($players, $playerKey, 1);
  }

  public function addResult($player, $points, $place){
    return Result::addResult($this->id, $player->id, $points, $place);
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
      FROM players
      WHERE game_id = :game_id
      ');

      $sth->execute([
        'game_id' => $this->id
      ]);
      $sth->setFetchMode(PDO::FETCH_CLASS, 'Player');
      $this->players = $sth->fetchAll();
      return $this->players;
  }

  public function getResults(){
    return Result::getResultsByGame($this->id);
  }

  public static function getGameInProgress(){
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
        WHERE date_ended IS NULL');

    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Game');
    return $sth->fetch();
  }

  public static function newGame($name, $playerIds){
    $db = Database::getDatabase();
    $sth = $db->prepare('INSERT INTO games (
      name,
      participants,
      season
    ) VALUES (
      :name,
      :participants,
      :season
    )');

    $sth->execute([
      'name' => $name,
      'participants' => count($playerIds),
      'season' => 1
    ]);

    $insertId = $db->lastInsertId();

    Player::updatePlayers($playerIds, $insertId);

    return $insertId;
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
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Game');
    return $sth->fetch();
  }

  public static function getGames(){

  }

}
