<section class="mainContent">
  <table class="score-table">
    <tr class="table-header">
      <th>Place</th>
      <th>Name</th>
      <th>Score</th>
    </tr>

  <?php

  foreach ($results as $i => $player) {
    echo '<tr>';
    echo '<td>'. $player['place'] . '</td>';
    echo '<td>'. $player['firstname'] . ' ' . mb_substr($player['lastname'],0,1) . '</td>';
    echo '<td>'. $player['points'] . '</td>';
    echo '</tr>';
  }
   ?>

  </table>
</section>
