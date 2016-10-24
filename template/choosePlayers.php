<section class="mainContent">
  <form method="POST" action="index.php">
          <h3 class="playerNamesHeader">Enter player names</h3>
          <input id="playerCount" type="hidden" name="playerCount" value="<?=$playerCount?>">
          <div id="selectContainer"></div> <!-- container for js form generation -->
          <?php for($i = 0; $i < $playerCount; $i++):
            //if we got an error the variable $error will defined in game.php and included here
            $errorExists = isset($errors) && isset($errors['players']) && isset($errors['players'][$i]);
            ?>
            <label for="selectedPlayers[]" class="label">Player <?=($i+1)?></label>
            <select name="selectedPlayers[]">
              <option value="-1"></option>
              <?php foreach($players as $player): ?>
                <option <?=isset($selectedPlayers[$i]) && $player['id'] == $selectedPlayers[$i] ? 'selected="selected"' : ''?> value="<?=$player['id']?>"><?=$player['firstname'] . ' ' . $player['lastname'][0]?></option>
              <?php endforeach; ?>
            </select>
            <?=($errorExists ? '<span class="nameFieldErrorMessage">' . $errors['players'][$i] . '</span><br><br>' : '')?>
          <?php endfor; ?>
          <button type="submit">NEW ROUND</button>
        </form>
    </section>
