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

  public static function addScore($player, $points, $wins){
    $scores = self::getScores();
    if(!array_key_exists($player['id'], $scores)){
      $scores[$player['id']] = [
        'name' => $player['name'],
        'score' => 0,
        'wins' => 0,
        'games' => 0
      ];
    }

    $scores[$player['id']]['score'] += $points;
    $scores[$player['id']]['wins'] += $wins;
    $scores[$player['id']]['games'] += 1;

    self::saveScore($scores);
  }

  public static function saveScore($scores){
    file_put_contents('scores.json', json_encode($scores));
  }

  public static function resetScores(){
    file_put_contents('scores.json', '{}');
  }
}
