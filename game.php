<?php
require_once('lib/header.php');
require_once('lib/game.class.php');

if(!Auth::authenticated()){
  include('login.php');
  exit;
}


$game = Game::getGameInProgress();

if(!$game && isset($_SESSION['new_game'])){
  unset($_SESSION['new_game']);
  $playersIds = $_SESSION['players']; //should be validated

  $name = 'Ping Pong Game';
  $gameId = Game::newGame($name, $playersIds);
  $game = Game::getGame($gameId);
}

if($game && isset($_POST['new_round'])){
  $eliminatedPlayerId = (int)$_POST['eliminated_player'];
  $status = $game->nextRound($eliminatedPlayerId);

  if($status === 1){
    header('Location: scoreboard.php?game_id=' . $game->id);
    exit;
  }

  $game->getPlayers();
}

include('template/header.php');

if($game){
  $results = $game->getResults();
  include('template/game.php');
  include('template/scoreboard.php');
}

include('template/footer.php');
