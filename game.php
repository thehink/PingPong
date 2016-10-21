<?php

if(!isset($_POST['gameOn']) || !isset($_POST['players'])){
  echo 'Why you here?';
  exit;
}

include_once('includes/database.php');
include_once('includes/score.php');

$playerIds = $_POST['players'];

if(!is_array($playerIds)){
  $playerIds = explode(',', $playerIds);
}


//player clicked a name so we should add the score and remove player from array

$playerCount = (int)$_POST['playerCount'];
$players = Database::getNamesByIds($playerIds);

if(isset($_POST['addScore'])){
  $playerIndex = (int)$_POST['addScore'];
  $player = $players[$playerIndex];

  array_splice($playerIds, $playerIndex, 1);
  array_splice($players, $playerIndex, 1);

//normal score
  $score = ($playerCount - count($players)) * 10;

  if(count($players) === 1){
    echo "Wohooo " . $players[0] . " has won<br>";
    $winner = $players[0];
    $winnerScore = $score + 30;
    echo $player . ' got ' . $score . ' points<br>';
    echo $winner . '(winner) got ' . $winnerScore . ' points<br>';
    echo '<a href="scoreboard.php">Show Scoreboard</a>';
    Score::addScore($winner, $winnerScore, 1);
    Score::addScore($player, $score, 0);
    exit;
  }

  Score::addScore($player, $score, 0);
  echo $player . ' got ' . $score . ' points<br>';
}

$playersTxt = join(',', $playerIds);

foreach ($players as $i => $name) {?>

  <form class="" action="/index.php" method="post">
    <input type="hidden" name="gameOn" value="1">
    <input type="hidden" name="playerCount" value="<?=$playerCount?>">
    <input type="hidden" name="addScore" value="<?=$i?>">
    <input type="hidden" name="players" value="<?=$playersTxt?>">
    <button type="submit"><?=$name?></button>
  </form>

<?php } ?>
