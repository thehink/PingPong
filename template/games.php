<section class="mainContent">

  <h3>Games In Progress</h3>
  <table class="score-table">
    <tr class="table-header">
      <th>Name</th>
      <th>Participants</th>
      <th>Started</th>
      <?=Auth::authenticated() ? '<th>Remove</th>' : ''?>;
    </tr>

  <?php


  foreach ($games as $i => $game) {
    if($game['date_ended']){
      continue;
    }
    $row = '<tr>';
    $row .= sprintf('<td><a href="scoreboard.php?game_id=%d">%s</a></td>', $game['id'], $game['name']);
    $row .= sprintf('<td>%s</td>', $game['participants']);
    $row .= sprintf('<td>%s</td>', $game['date_started']);
    $row .= Auth::authenticated() ? sprintf('<td><a href="games.php?remove=%d">Remove</a></td>', $game['id']) : '';
    $row .= '</tr>';
    echo $row;
  }
   ?>

  </table>

  <h3>History</h3>
  <table class="score-table">
    <tr class="table-header">
      <th>Name</th>
      <th>Participants</th>
      <th>Started</th>
      <?=Auth::authenticated() ? '<th>Remove</th>' : ''?>;
    </tr>

  <?php


  foreach ($games as $i => $game) {
    if(!$game['date_ended']){
      continue;
    }
    $row = '<tr>';
    $row .= sprintf('<td><a href="scoreboard.php?game_id=%d">%s</a></td>', $game['id'], $game['name']);
    $row .= sprintf('<td>%s</td>', $game['participants']);
    $row .= sprintf('<td>%s</td>', $game['date_started']);
    $row .= Auth::authenticated() ? sprintf('<td><a href="games.php?remove=%d">Remove</a></td>', $game['id']) : '';
    $row .= '</tr>';
    echo $row;
  }
   ?>

  </table>
</section>
