<?php
require_once('lib/header.php');

if(isset($_GET['remove']) && Auth::authenticated()){
  Database::removeGame((int)$_GET['remove']);
}

$games = Database::getGames(0, 20);

include('template/header.php');
include('template/games.php');
include('template/footer.php');
