<?php
require_once('lib/header.php');
require_once('lib/game.php');

$results = [];

if(isset($_GET['game_id'])){
  $gameId = (int)$_GET['game_id'];
  $game = new PingPongGame($gameId);
  $results = $game->getResults();
}

include('template/header.php');
include('template/scoreboard.php');
include('template/footer.php');
