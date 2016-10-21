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
				<?php if (!isset($_POST['start'])): ?>
					<h2>Ping Pong Score Master <br><span>3000</span></h2>
					<form method="POST" action="gameOn.php">
						<button type="submit" name="start">NEW ROUND</button>
					</form>
				<?php endif; ?>
			</header>
			<?php
			include 'scoreSheetFunctions.php';
			include 'gameOn.php';
			$scores = getScores();


			if (isset($_POST['start'])) {
				echo 'How many players? <form method="POST" action="names.php"><input type="number" name="numPlayers"><br><br></input><button>submit</button></form>';
			}


			if (!empty($scores)) {
				foreach ($scores as $key => $value) {
					echo '<button>'.$key.'</button>';
				}
			}

			?>
		</main>
    <footer>
      <p>© <?php echo date("Y"); ?> WU16. <a href="README.md">Terms of service apply</a>
      <br>Please feel free to use Ping Pong Score Master 3000</p>
    </footer>
  </body>
</html>
