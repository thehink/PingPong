<script>
'use strict';
//print out the players from php
const players = <?=json_encode($players)?>;
let selectedPlayers = <?=isset($_SESSION['players']) ? json_encode($_SESSION['players']) : '[]' ?>
</script>
<section class="mainContent" id="playersFormWrapper">
					<form method="POST" action="index.php" id="playerCountForm">
						<h3 class="playerCountHeader">How many players?</h3>
						<input type="number" name="playerCount" value="<?=$playerCount?>">
            <?=isset($errors) && isset($errors['playerCount']) ? '<span class="nameFieldErrorMessage">'.$errors['playerCount'].'</span>' : ''?>
						<label for="playerName" class="label"></label>
						<button type="submit" name="start">Set Players</button>
					</form>
</section>
<!--Include javascript for select players -->
<script src="js/main.js" charset="utf-8"></script>
