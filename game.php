<?php

if(!isset($_POST['gameOn']) || !isset($_POST['players'])){
  echo 'Why you here?';
  exit;
}

include_once('includes/database.php');
include_once('includes/score.php');

$playerIds = $_POST['players'];

//player clicked a name so we should add the score and remove player from array
$playerCount = (int)$_POST['playerCount'];
$players = Database::getPlayersByIds($playerIds);

if(isset($_POST['addScore'])){
  $playerIndex = (int)$_POST['addScore'];
  $player = $players[$playerIndex];

  array_splice($playerIds, $playerIndex, 1);
  array_splice($players, $playerIndex, 1);

//normal score
  $score = ($playerCount - count($players)) * 10;

  if(count($players) === 1){
    $winner = $players[0];
    $winnerScore = $score + 30;
    echo "Wohooo " . $winner['name'] . " has won<br>";
    echo $player['name'] . ' got ' . $score . ' points<br>';
    echo $winner['name'] . '(winner) got ' . $winnerScore . ' points<br>';
    echo '<a href="scoreboard.php">Show Scoreboard</a>';
    Score::addScore($winner, $winnerScore, 1);
    Score::addScore($player, $score, 0);
    exit;
  }

  Score::addScore($player, $score, 0);
  echo $player['name'] . ' got ' . $score . ' points<br>';
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
