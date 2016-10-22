<?php
require_once('lib/header.php');

//define variables here that will be accessible in the included files

//$players will be in the scope of all the included files below
$players = Database::getAllPlayers();
$playerCount = isset($_POST['playerCount']) ? $_POST['playerCount'] : 0;
$selectedPlayers = isset($_POST['selectedPlayers']) ? $_POST['selectedPlayers'] : [];

if($playerCount > count($players)){
  $errors = [
    'playerCount' => 'Too many players, Max ' . count($players) . ' players!'
  ];
}

if($playerCount < 1){
  $errors = [
    'playerCount' => 'You cant have less than 1 players :/'
  ];
}

if(count($selectedPlayers) > 0 && !isset($errors['playerCount'])){
  $errors = ['players'=> []];
  foreach ($selectedPlayers as $i => $id) {
    $playerExists = is_numeric(array_search($id, array_column($players, 'id')));
    $duplicates = count(array_keys($selectedPlayers, $id)) > 1;
    //the blank name has an id of 0
    $isBlank = (int)$id < 0;
    if(!$playerExists){
      $errors['players'][$i] = 'Doesnt exist in database!';
    }
    if ($duplicates)
    {
      $errors['players'][$i] = 'Player is a duplicate!';
    }
    if ($isBlank)
    {
      $errors['players'][$i] = 'You need to choose a player!';
    }
  }
  if(count($errors['players']) === 0){
    $_SESSION['players'] = $selectedPlayers;
    $_SESSION['new_game'] = true;
    header('Location: game.php');
    exit;
  }
}


include('template/header.php');
include('template/playerCount.php');

//show player dropdowns if we got a playerCount post
if(isset($_POST['playerCount']) && !isset($errors['playerCount'])){
  include('template/choosePlayers.php');
}

include('template/footer.php');
