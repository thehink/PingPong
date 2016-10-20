<?php
$num = 1;

if (isset($_POST['numPlayers'])) {
  echo '<form method="POST" action="/gameOn.php">';
  for ($i=0; $i < $_POST['numPlayers']; $i++) {
    echo 'Player '.$num.' <input type="text"></input><br>';
    $num++;
  }

  echo '<input type="submit" name="names" value="Send"></input></form>';
}

 ?>