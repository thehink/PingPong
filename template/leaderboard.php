<section class="mainContent">
  <table class="score-table">
    <tr class="table-header">
      <th>Name</th>
      <th>Score</th>
      <th>Games Played</th>
      <th>First Place</th>
      <th>Second Place</th>
      <th>Third Place</th>
    </tr>

  <?php
  foreach ($leaderboard as $i => $player) {
    $row = '<tr>';
    $row .= sprintf('<td>%s %s</td>', $player['firstname'], mb_substr($player['lastname'],0,1));
    $row .= sprintf('<td>%s</td>', $player['totalScore']);
    $row .= sprintf('<td>%s</td>', $player['gamesPlayed']);
    $row .= sprintf('<td>%s</td>', $player['firstPlace']);
    $row .= sprintf('<td>%s</td>', $player['secondPlace']);
    $row .= sprintf('<td>%s</td>', $player['thirdPlace']);
    $row .= '</tr>';
    echo $row;
  }
   ?>

  </table>
</section>
