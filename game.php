<?php
require_once('lib/header.php');
require_once('lib/game.php');

if(isset($_POST['new_game']) && isset($_POST['players'])){
  $name = 'PingPong Game';
  $players = $_POST['players'];
  $game = new PingPongGame($name, $players);
}

if(isset($_SESSION['game_id'])){
  $gameId = (int)$_SESSION['game_id'];
  $game = new PingPongGame($gameId);
}

if(isset($_POST['new_round'])){

}
