<?php
require_once('lib/header.php');


$leaderboard = Database::getLeaderboard();

include('template/header.php');
include('template/leaderboard.php');
include('template/footer.php');
