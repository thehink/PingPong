<?php
include 'scores.txt';

function addScore($userName, $score) {
  $scores[$userName] += $score;
}

function getScores() {
  return file_get_contents('scores.txt');
}

function validateGameOptions() {
  
}
 ?>