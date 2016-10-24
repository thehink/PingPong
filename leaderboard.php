<?php
require_once('lib/header.php');


//get leaderboard array with the leaderboard database query defined in Database::getLeaderboard method
$leaderboard = Database::getLeaderboard();

//show our templates
include('template/header.php');
//leaderboard.php will show the data in $leaderboard variable defined above
include('template/leaderboard.php');
include('template/footer.php');
