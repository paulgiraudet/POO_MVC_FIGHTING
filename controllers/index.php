<?php


//à changer pour les différents chemins
// function loadClass($class){
    //     require $class . '.php';
    // }
    
    // spl_autoload_register('loadClass');
    
    require '../entities/Character.php';
    require '../models/CharacterManager.php';
    require '../models/Database.php';
    
    session_start();

$db = Database::DB();
$charManager = new CharacterManager($db);

if (isset($_POST['name'], $_POST['createChar']) && !empty($_POST['name'])) {

    $name = htmlspecialchars($_POST['name']);
    $char = new Character(['name' => $name, 'damage' => 0]);
    if ($charManager->exists($name)) {
        echo "Ce nom est déjà pris.";
    }
    else {
        $charManager->addChar($char);
    }
}
elseif (isset($_POST['name'], $_POST['useChar'])) {
    
    $name = htmlspecialchars($_POST['name']);
    if ($charManager->exists($name)) {
        $char = $charManager->selectChar($name);

        $_SESSION['fighter'] = $char;
    
    }
    else{
        echo "Ce personnage n'existe pas, veuillez le créer";
    }
}
elseif  (isset($_GET['name'])){

    if (is_string($_GET['name'])) {
        $name = htmlspecialchars($_GET['name']);
        if (isset($_SESSION['fighter'])) {
            // $char = $_SESSION['fighter'];
            
            if ($charManager->exists($name)) {
                $target = $charManager->selectChar($name);
                $_SESSION['fighter']->fight($target);
                $charManager->updateChar($target);

                if ($target->getDamage() >= 100) {
                    $charManager->deleteChar($target);
                }
            }
        }
    }
}

$chars = $charManager->getChars();


include "../views/indexVue.php";
 ?>
