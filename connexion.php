<?php
session_start();
require_once 'model/connexion.php';
require_once 'model/ErrorMessages.php';
require_once 'config.php';
$connexion = new  Connexion($pdo);
$numero_valide = null;
//  Connexion
$tab = ['password', 'numero'];
function tableau($tab)
{
    foreach ($tab as $v) {
        if (!isset($_POST[$v]) && !empty(trim($_POST[$v]))) {
            return false;
        }
    }
    return true;
}
$champ = tableau($tab);
if ($champ && $_POST['connecter']) {
    if (strlen($_POST['numero']) === 8 && ($debut <= (int) $_POST['numero'] || (int) $_POST['numero'] <= $fin)) {
        $numero = (int) htmlentities($_POST['numero']);
        $password = htmlentities($_POST['password']);
        $numero_valide = true;
    } else {
        echo  ErrorMessages::numeroInvalide();
    }
}
if ($numero_valide) {
    if ($connexion->userInscrit($numero)) {
        if ($connexion->verifypassword($numero, $password)) {
            $_SESSION['numero'] = $numero;
            header('location:page2.php');
        } else {
            echo   ErrorMessages::incorrectPassmord();
        }
    } else {
        echo ErrorMessages::notOnPlatform();
    }
}
?>
<hr>
<div class="connexion1 centre1">
    <div class="centre2 connexion2 ">
        <div class="connexion3">
            <h2>Bienvenue à nouveau</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="numero">Votre numero</label>
                <br>
                <input type="number" name="numero" id="numero" placeholder="Votre numero" required <?php values('numero') ?>>
                <br>
                <br>
                <label for="password">Votre mot de pass</label>
                <br>
                <input type="password" name="password" id="password" placeholder="mot de pass" required>
                <br>
                <br>
                <div class="button">
                    <input type="submit" name="connecter" value="connecter">
                </div>
            </form>
            <p>Vous n'avez pas de compte ? <a href="index2.php">Inscrivez-vous</a></p>
            <p><a href="index.php">Retour</a></p>
        </div>
    </div>
</div>
</body>

</html>