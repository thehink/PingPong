<section class="mainContent">
  <table class="score-table">
    <tr class="table-header">
      <th>Name</th>
      <th>Total Score</th>
      <th>Games Played</th>
      <th>First Place</th>
      <th>Second Place</th>
      <th>Third Place</th>
    </tr>

  <?php

  foreach ($leaderboard as $i => $player) {
    echo '<tr>';
    echo '<td>'. $player['firstname'] . ' ' . $player['lastname'][0] . '</td>';
    echo '<td>'. $player['totalScore'] . '</td>';
    echo '<td>'. $player['gamesPlayed'] . '</td>';
    echo '<td>'. $player['firstPlace'] . '</td>';
    echo '<td>'. $player['secondPlace'] . '</td>';
    echo '<td>'. $player['thirdPlace'] . '</td>';
    echo '</tr>';
  }
   ?>

  </table>
</section>
