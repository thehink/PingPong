<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Ping pong scores</title>
  </head>
  <body>
    <header>
      <?php if (!isset($_POST['start'])): ?>
      <h2>Welcome to Ping Pong Score Tracker 3000</h2>
      <h3>Press START to begin a new round!</h3>
      <form method="POST">
        <button type="submit" name="start">START</button>
      </form>
    <?php endif; ?>
    </header>
    <?php
    include 'scoreSheetFunctions.php';
    include 'gameOn.php';
    $scores = getScores();


    if (isset($_POST['start'])) {
      echo 'How many players? <form method="POST" action="names.php"><input type="number" name="numPlayers"></input><button>submit</button></form>';
    }


    if (!empty($scores)) {
      foreach ($scores as $key => $value) {
        echo '<button>'.$key.'</button>';
      }
    }

    ?>
  </body>
</html>
