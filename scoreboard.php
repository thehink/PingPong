<?php
include_once('includes/score.php');
?>

<?php include('header.php'); ?>

<table>
  <tr>
    <th>Name</th>
    <th>Points</th>
    <th>Wins</th>
    <th>Games</th>
  </tr>

<?php

//get scores => format => ['Benjamin R' => ['score' => 2, 'wins' => 3]
$scores = Score::GetScores();

foreach ($scores as $id => $score) {
  echo '<tr>';
  echo '<td>'. $score['name'] . '</td>';
  echo '<td>'. $score['score'] . '</td>';
  echo '<td>'. $score['wins'] . '</td>';
  echo '<td>'. $score['games'] . '</td>';
  echo '</tr>';
}
 ?>

</table>

<?php include('footer.php'); ?>;
