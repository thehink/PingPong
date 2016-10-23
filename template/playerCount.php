<section class="mainContent">
					<form method="POST" action="index.php">
						<label for="playCount" class="label">How many players?</label>
						<input type="number" name="playerCount" value="<?=$playerCount?>">
            <?=isset($errors) && isset($errors['playerCount']) ? '<span class="nameFieldErrorMessage">'.$errors['playerCount'].'</span>' : ''?>
						<label for="playerName" class="label"></label>
						<button type="submit" name="start">Set Players</button>
					</form>
</section>
