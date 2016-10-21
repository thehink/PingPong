<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="css/style.css">
    <title>Ping pong scores</title>
  </head>
  <body>
		<main class="mainWrapper">
			<header>
				<h2>Ping Pong Score Master <br><span>3000</span></h2>
			</header>
			<section class="mainContent">
				<?php if (!isset($_POST['start'])): ?>
					<form method="POST" action="gameOn.php">
						<label for="playCount" class="label">How many players?</label>
						<input type="number" name="playCount" value="Choose how many players...">
						<label for="playerName" class="label"></label>
						<!-- Select boxes -->
						<button type="submit" name="start">NEW ROUND</button>
					</form>
				<?php endif; ?>
			</section>
			<footer>
				<!-- Add leader board -->
			</footer>
			<?php
			include 'scoreSheetFunctions.php';
			include 'gameOn.php';
			$scores = getScores();


			if (isset($_POST['start'])) {
				echo 'How many players? <form method="POST" action="names.php"><input type="number" name="numPlayers"></input><button>submit</button></form>';
			}


			if (!empty($scores)) {
				foreach ($scores as $key => $value) {
					echo '<button>'.$key.'</button>';
				}
			}

			?>
		</main>
  </body>
</html>
