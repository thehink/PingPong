<?php
require_once('lib/header.php');

Database::query('DELETE FROM games');
Database::query('DELETE FROM results');

echo "Done!";
