<?php

require_once('database.php');

class Auth{

  public static function authenticated(){
    if(isset($_SESSION['pin']) && $_SESSION['pin'] === PIN_CODE){
      return true;
    }
    return false;
  }

  public static function authenticate($pin){
    if($pin === PIN_CODE){
      $_SESSION['pin'] = $pin;
      return true;
    }
    return false;
  }

}
