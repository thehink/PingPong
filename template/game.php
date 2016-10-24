<section class="mainContent">
<h3 class="gameHeader">Click name if you are OUT</h3>
<?php foreach ($players as $i => $player): ?>
  <form class="gameForm" action="game.php" method="post">
    <input type="hidden" name="new_round" value="1">
    <input type="hidden" name="eliminated_player" value="<?=$player['id']?>">
    <button type="submit"><?=$player['firstname'] . ' ' . $player['lastname'][0]?></button>
  </form>

<?php endforeach; ?>
</section>
