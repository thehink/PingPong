<?php
$num = 1;
$classMates = ['', 'Robert N', 'Lars K', 'Joakim R', 'Benjamin R', 'Marie E', 'Maria GN',
               'Axel B', 'Amin E-R', 'André H', 'Carl Å', 'Christian B', 'Katarina C',
               'Erica G', 'Jeremy D', 'Kristjan F', 'Mathias K', 'Signe B', 'Staffan M',
               'Victor O', 'Max S', 'Johannes T', 'Vincent K'];
asort($classMates);

if (isset($_POST['numPlayers'])) {
  echo '<form method="POST" action="/gameOn.php">';
  for ($i=0; $i < $_POST['numPlayers']; $i++) {
    echo 'Player '.$num.' <select><br>';
    foreach ($classMates as $mate) {
      echo '<option value="'.$mate.'">'.$mate.'</option>';
    }
    echo '</select><br>';
    $num++;
  }

  echo '<input type="submit" name="names" value="Send"></input></form>';
}

 ?>
