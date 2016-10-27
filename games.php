<?php
require_once('lib/header.php');

if(isset($_GET['remove']) && Auth::authenticated()){
  if(isset($_SESSIION['game_id']) && $_SESSIION['game_id'] === (int)$_GET['remove']){
    unset($_SESSIION['game_id']);    
  }
  Database::removeGame((int)$_GET['remove']);
}

$games = Database::getGames(0, 20);

include('template/header.php');
include('template/games.php');
include('template/footer.php');
