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
}


foreach ($players as $i => $player) {?>
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
