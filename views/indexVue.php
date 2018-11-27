<?php
  include("template/header.php");

  ?>

<form action="" method="post">
<p>Nom : <input type="text" name="name" maxlength="50" />
<input type="submit" value="Créer ce personnage" name="createChar" />
<input type="submit" value="Utiliser ce personnage" name="useChar" /></p>
</form>
<?php
  
foreach ($chars as $char) {
  echo '<a href="?name=' . $char->getName() . '">' . $char->getName() . ' - ' .  $char->getDamage() .' /100 </a></br>';
}

include("template/footer.php")
  ?>
