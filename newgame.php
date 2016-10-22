<?php

include_once('includes/database.php');

 ?>
			<section class="mainContent">
					<form method="POST" action="index.php">
						<label for="playCount" class="label">How many players?</label>
						<input type="number" name="playCount" value="<?=$_POST['playCount']?>">
						<label for="playerName" class="label"></label>
						<button type="submit" name="start">Set Players</button>
					</form>


      <?php if(isset($_POST['playCount'])):

        //cast playCount to int to make sure its an integer
        //could add more checks on playerCount. Like a check for negative and too high numbers
        $playerCount = (int)$_POST['playCount'];
        $playerNames = Database::getPlayers();
        ?>
        <form method="POST" action="index.php">
          <label for="playCount" class="label">Enter player names</label>
          <input type="hidden" name="gameOn" value="1">
          <input type="hidden" name="playerCount" value="<?=$playerCount?>">
          <?php for($i = 0; $i < $playerCount; $i++): ?>
            <label for="players[]" class="label">Player <?=($i+1)?></label>
            <select name="players[]">
              <?php foreach($playerNames as $player): ?>
                <option value="<?=$player['id']?>"><?=$player['name']?></option>
              <?php endforeach; ?>
            </select>
          <?php endfor; ?>
          <button type="submit">NEW ROUND</button>
        </form>

      <?php endif; ?>

      </section>
