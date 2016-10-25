<?php
require_once('lib/header.php');
require_once('lib/game.class.php');

$game = Game::getGameInProgress();

if(isset($_POST['pin'])){
  //Try to auth
  $authed = Auth::authenticate($_POST['pin']);

//if authed redirict to index.php
  if($authed){
    header('Location: index.php');
    exit;
  }

//else define error
  $loginError = 'Wrong pin code!';

}

include('template/header.php');


if($game){
  $results = $game->getResults();
  include('template/scoreboard.php');
}

include('template/login.php');
include('template/footer.php');
