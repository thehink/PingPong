<section class="mainContent">
  <table class="score-table">
    <tr class="table-header">
      <th>Place</th>
      <th>Name</th>
      <th>Score</th>
    </tr>

  <?php
  foreach ($results as $i => $player) {
    $row = '<tr>';
    $row .= sprintf('<td>%s</td>', $player['place']);
    $row .= sprintf('<td>%s %s</td>', $player['firstname'], mb_substr($player['lastname'],0,1));
    $row .= sprintf('<td>%s</td>', $player['points']);
    $row .= '</tr>';
    echo $row;
  }

   ?>

  </table>
</section>
