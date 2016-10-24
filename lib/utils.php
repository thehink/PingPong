<?php


class utils{
  public static function array_join_int($arr, $del){
    $in = array_map(function($int){
      return (int)$int;
    }, $arr);
    $in = join(', ', $in);
    return $in;
  }
}
