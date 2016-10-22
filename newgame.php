<?php

include_once('includes/database.php');

 ?>
			<section class="mainContent">
					<form method="POST" action="index.php">
						<label for="playCount" class="label">How many players?</label>
						<input type="number" name="playerCount" value="<?=$_POST['playCount']?>">
						<label for="playerName" class="label"></label>
						<button type="submit" name="start">Set Players</button>
					</form>


      <?php if(isset($_POST['playerCount'])):

        //cast playCount to int to make sure its an integer
        //could add more checks on playerCount. Like a check for negative and too high numbers
        $playerCount = (int)$_POST['playerCount'];
        $playerNames = Database::getPlayers();

        //we use this part if we got an error to keep track of the previously selected option
        $playerArray = [];
        if(isset($_POST['players'])){
          $playerArray = $_POST['players'];
        }

        ?>
        <form method="POST" action="index.php">
          <label for="playCount" class="label">Enter player names</label>
          <input type="hidden" name="gameOn" value="1">
          <input type="hidden" name="playerCount" value="<?=$playerCount?>">
          <?php for($i = 0; $i < $playerCount; $i++):
            //if we got an error the variable $error will defined in game.php and included here
            $errorExists = isset($errors) && isset($errors['players']) && isset($errors['players'][$i]);
            ?>
            <label for="players[]" class="label">Player <?=($i+1)?></label>
            <select name="players[]">
              <?php foreach($playerNames as $player): ?>
                <option <?=isset($playerArray[$i]) && $player['id'] == $playerArray[$i] ? 'selected="selected"' : ''?> value="<?=$player['id']?>"><?=$player['name']?></option>
              <?php endforeach; ?>
            </select>
            <?=($errorExists ? $errors['players'][$i] : '')?>
          <?php endfor; ?>
          <button type="submit">NEW ROUND</button>
        </form>

      <?php endif; ?>

      </section>
