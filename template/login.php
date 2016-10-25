<section class="mainContent">
					<form method="POST" action="login.php" id="playerCountForm">
						<label for="pin" class="label">Password</label>
						<input type="text" name="pin" value="">
            <?=isset($loginError) ? $loginError : ''?>
						<button type="submit" name="start">Access</button>
					</form>
</section>
