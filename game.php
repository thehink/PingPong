<?php
require_once('lib/header.php');
require_once('lib/game.php');

$results = [];
$players = [];

if(isset($_SESSION['new_game']) && $_SESSION['new_game']){
  $_SESSION['new_game'] = NULL;
  $selectedPlayers = $_SESSION['players']; //players were validated in index.php
  $name = 'PingPong Game';  //could make this an input in index.php
  $game = new PingPongGame(NULL, $name, $selectedPlayers);
  $_SESSION['game_id'] = $game->gameId;
  $players = $game->getPlayers();
}

if(isset($_SESSION['game_id'])){
  $gameId = (int)$_SESSION['game_id'];
  $game = new PingPongGame($gameId);
  $players = $game->getPlayers();
}

if(isset($_POST['new_round'])){
  $eliminatedPlayerId = (int)$_POST['eliminated_player'];

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
