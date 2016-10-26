<?php
require_once('lib/header.php');

if(!Auth::authenticated()){
  include('login.php');
  exit;
}

//define variables here that will be accessible in the included files

//$players will be in the scope of all the included files below
$players = Database::getAllPlayers();
//get post variable player count or set it to 2 as default
$playerCount = isset($_POST['playerCount']) ? $_POST['playerCount'] : 2;
//selectedPlayers in array of ids => [1,2,3,4] empty as default
$selectedPlayers = isset($_POST['selectedPlayers']) ? $_POST['selectedPlayers'] : [];

//check so we dont have a too high playercount
if($playerCount > count($players)){
  $errors = [
    'playerCount' => 'Too many players, Max ' . count($players) . ' players!'
  ];
}

//check so we dont have a too low playercount
if(isset($_POST['playerCount']) && $playerCount < 2){
  $errors = [
    'playerCount' => 'You cant have less than 1 players :/'
  ];
}

//if we got selected
if(count($selectedPlayers) > 0 && !isset($errors['playerCount'])){
  $errors = ['players'=> []];

  $selectedPlayers = array_filter($selectedPlayers, function($id){
    return $id > -1;
  });

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

  //if we didnt found any errors they most be valid
  if(count($errors['players']) === 0){
    $_SESSION['players'] = $selectedPlayers;
    $_SESSION['new_game'] = true;

    //rederict to our game page with session variables above
    header('Location: game.php');
    exit;
  }
}

//show our templates
//the variables defined above will be in the scope of the templates
include('template/header.php');
include('template/playerCount.php');

//show player dropdowns if we got a playerCount post and dont have any playerCount errors
if(isset($_POST['playerCount']) && !isset($errors['playerCount'])){
  include('template/choosePlayers.php');
}

include('template/footer.php');
