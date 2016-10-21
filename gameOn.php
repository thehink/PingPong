<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Game ON!</title>
    <link rel="stylesheet" href="/css/style.css" media="screen" title="no title">
  </head>
  <body>
    <?php if(isset($_POST['start'])): ?>
    <header>
      <form class="" action="/" method="post">
        <button type="submit" name="backButton">To main page</button>
      </form>
    </header>
  <?php endif; ?>

    <?php

    // if (isset($_POST['numPlayers'])) {
    //   for ($i=0; $i < $_POST['numPlayers']; $i++) {
    //     # code...
    //   }
    // }


    ?>
  </body>
</html>