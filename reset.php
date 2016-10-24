<?php
require_once('lib/header.php');

echo 'Delete ALL the scores?!?!?! <form method="POST"><input type="button" name="Yes" value="Yes"></input></form>';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Yes'])) {
  Database::query('DELETE FROM games');
  Database::query('DELETE FROM results');
  echo "Done!";
}


