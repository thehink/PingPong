<?php
/*
Class Scores

usage:
include_once('score.php');

Database::getScores() -> [Array of scores]

'Another one' => [
  'score' => 12,
  'wins' => 1
]
*/

class Score{

//should get these things from file in the future

  public static function getScores(){
    $scores = json_decode(file_get_contents('scores.json'), true);
    uasort($scores, function($a, $b){
      return $b['score'] > $a['score'];
    });
    return $scores;
  }

  public static function addScore($name, $points, $wins){
    $scores = self::getScores();
    if(!array_key_exists($name, $scores)){
      $scores[$name] = [
        'score' => 0,
        'wins' => 0,
        'games' => 0
      ];
    }

    $scores[$name]['score'] += $points;
    $scores[$name]['wins'] += $wins;
    $scores[$name]['games'] += 1;

    self::saveScore($scores);
  }

  public static function saveScore($scores){
    file_put_contents('scores.json', json_encode($scores));
  }

  public static function resetScores(){
    file_put_contents('scores.json', '{}');
  }
}
