<?php
include('header.php');

if(isset($_POST['gameOn'])){
  include('game.php');
}else{
  include('newgame.php');
}

include('footer.php');
