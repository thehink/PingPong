<?php
require("config.php");

class Database{

  private static $connection;

  public static init(){
    self::$connection = new PDO('mysql:dbname='. DB_NAME .';host='. DB_HOST .';charset=utf8', DB_USER, DB_PASSWORD);
    self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public static getDatabase(){
    return self::$connection;
  }
}

Database::init();
