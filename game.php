<?php

if(!isset($_POST['gameOn']) || !isset($_POST['players'])){
  echo 'Why you here?';
  exit;
}

include_once('includes/database.php');
include_once('includes/score.php');

$playerIds = $_POST['players'];
$playerCount = (int)$_POST['playerCount'];

//get the players by the ids supplied in the post request.
//This should be keepen track of in the database in the future
$players = Database::getPlayersByIds($playerIds);
$errors = ['players'=> []];

foreach ($playerIds as $key => $id) {
  $playerExists = is_numeric(array_search($id, array_column($players, 'id')));
  $duplicates = count(array_keys($playerIds, $id)) > 1;
  //the blank name has an id of 0
  $isBlank = (int)$id === 0;

  if(!$playerExists){
    $errors['players'][$key] = '<span class="nameFieldErrorMessage">Doesnt exist in database!</span><br><br>';
  }

  if ($duplicates)
  {
    $errors['players'][$key] = '<span class="nameFieldErrorMessage">Player is a duplicate!</span><br><br>';
  }

  if ($isBlank)
  {
    $errors['players'][$key] = '<span class="nameFieldErrorMessage">You need to choose a player!</span><br><br>';
  }
}

//stop execution of this if errors found
if(count($errors['players']) > 0){
  //the variable $errors will now be defined in newgame.php so we can check for errors there
  include('newgame.php');
  return;
}

//player clicked a name so we should add the score and remove player from array
if(isset($_POST['addScore'])){
  //get the index of the player who lost
  $playerIndex = (int)$_POST['addScore'];
  $player = $players[$playerIndex];

//remove the player who lost from the current tables of players
  array_splice($playerIds, $playerIndex, 1);
  array_splice($players, $playerIndex, 1);

//normal score (TotalPlayerCount - PlayersLeft) * 10
  $score = ($playerCount - count($players)) * 10;

//only 1 player left in array of players. So that player has to be the winner.
  if(count($players) === 1){
    $winner = $players[0];
    $winnerScore = $score + 30; //bonus score for winner is defined here
    echo "Wohooo " . $winner['name'] . " has won<br>";
    echo $winner['name'] . '(winner) got ' . $winnerScore . ' points<br>';

    //add score of winner
    Score::addScore($winner, $winnerScore, 1);

    //add score for second place
    Score::addScore($player, $score, 0);
    $players = [];
  }

  //add score for any other place
  Score::addScore($player, $score, 0);
  echo $player['name'] . ' got ' . $score . ' points for ' . (count($playerIds)+1) . ' place<br>';
} ?>

<h3>Click name if you are OUT</h3>
<?php foreach ($players as $i => $player) {?>
  <form class="" action="index.php" method="post">
    <input type="hidden" name="gameOn" value="1">
    <input type="hidden" name="playerCount" value="<?=$playerCount?>">
    <input type="hidden" name="addScore" value="<?=$i?>">
    <?php foreach ($players as $i2 => $player2) { ?>
    <input type="hidden" name="players[]" value="<?=$player2['id']?>">
    <?php } ?>
    <button type="submit"><?=$player['name']?></button>
  </form>

<?php } ?>
