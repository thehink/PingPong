<?php
require_once('lib/header.php');
require_once('lib/game.php');

if(!Auth::authenticated()){
  include('login.php');
  exit;
}

$results = [];
$players = [];

if(isset($_SESSION['new_game']) && $_SESSION['new_game']){
  //we dont wanna start another new game when this page is reloaded
  $_SESSION['new_game'] = NULL;
  $selectedPlayers = $_SESSION['players']; //players were validated in index.php
  $name = 'PingPong Game';  //could make this an input in index.php

  //start new game instance by passing $name and $selectedPlayers to PingPongGame
  //gameId is NULL cause we dont want it to try look for an existing game in progress
  $game = new PingPongGame(NULL, $name, $selectedPlayers);
  //save gameId to session so we can access the game even after a reload of the page
  //could possibly tie this to a user login in the future
  $_SESSION['game_id'] = $game->gameId;

  //get the active players in the game instance
  $players = $game->getPlayers();
}

//if we have a game in progress session varable game_id should exist
if(isset($_SESSION['game_id'])){
  $gameId = (int)$_SESSION['game_id'];

  //start a gameInstance by providing an existing id. This will pull existing game info from database
  $game = new PingPongGame($gameId);

  //get active players of current game instance
  $players = $game->getPlayers();
}

//if someone clicked a name it will send a post request to this page with the variable new_round
if(isset($game) && isset($_POST['new_round'])){
  $eliminatedPlayerId = (int)$_POST['eliminated_player'];

  $playerStillInGame = in_array($eliminatedPlayerId, array_column($players, 'id'));

  if(!$playerStillInGame){
    throw new Exception("Error, this player is not in the game anymore!");
  }

  //eliminate player
  $game->eliminatePlayer($eliminatedPlayerId);

  //get players left in the game
  $players = $game->getPlayers();

  if(count($players) === 1){
    //only 1 left. that means someone won

    //call are game class to wrap things up
    $game->playerWin();

    //unset game_id because the game session is over.
    //session[players] is still available we can make use of it by starting a new game with the same players
    unset($_SESSION['game_id']);

    //these variables are needed for the template game.php
    $playerWon = true;
    $victoriousPlayer = $players[0];  //the last player must be the winner right?
    $players = $game->getPlayers();

    //rederict player to scoreboard of this game
    header('Location: scoreboard.php?game_id=' . $game->gameId);
    exit;
  }

  //make the $results variable available for the results.php template
}

if(isset($game)){
  $results = $game->getResults();
}


include('template/header.php');
include('template/game.php');
include('template/scoreboard.php');
include('template/footer.php');
