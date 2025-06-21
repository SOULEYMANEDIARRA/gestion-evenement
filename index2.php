<?php
session_start();
require_once 'config.php';
require_once 'model/EvnImages.php';
$numero_valide = false;

// Verifiction du numero
$tab = ['nom', 'prenom', 'new_password', 'numero'];
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

if (isset($_POST['soumetre']) && $champ) {
    if ((strlen($_POST['numero']) === 8 && ($debut <= (int) $_POST['numero'] || (int) $_POST['numero'] <= $fin))) {
        $numero = (int) htmlentities($_POST['numero']);
        $select = 'SELECT * FROM users WHERE numero = :numero';
        $pdosatement = $pdo->prepare($select);
        $pdosatement->execute([
            'numero' => $numero
        ]);
        $tab = $pdosatement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($tab)) {
            $numero_valide = true;
        } else {
?>
            <div class="danger">
                <p>Ce numero est deja sur la platforme </p>
            </div>
        <?php
        }
    } else {
        ?>
        <div class="danger">
            <p>Numero invalide </p>
        </div>
<?php
    }
}

//  INSERTION DANS LA BDD
if ($numero_valide && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profil'])) {
    $nom = htmlentities($_POST['nom']);
    $prenom = htmlentities($_POST['prenom']);
    $new_password = htmlentities($_POST['new_password']);
    $imageData = EvnImages::profil();

    $insert = 'INSERT INTO users (nom, prenom, numero, password , profil ) VALUES (:nom, :prenom, :numero, :password, :profil )';
    $pdoStatement = $pdo->prepare($insert);
    $pdoStatement->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'numero' => $numero,
        'password' => $new_password,
        'profil' => $imageData
    ]);
    $_SESSION['numero'] = $numero;
    header('location:page2.php');
}
?>
<div class=" centre1">
    <div class="connexion2 centre2">
        <div class="connexion3">
            <h2>S'inscrire</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nom">Votre nom</label>
                    <input type="text" name="nom" id="nom" placeholder="Nom">
                </div>
                <div>
                    <label for="prenom">Votre prenom</label>
                    <input type="text" name="prenom" id="prenom" placeholder="Prenom">
                </div>
                <div>
                    <label for="numero">Votre numero</label>
                    <input type="number" name="numero" id="numero" placeholder="Numero">
                </div>
                <div>
                    <label for="new_password">Votre password</label>
                    <input type="password" name="new_password" id="new_password" placeholder="Mot de pass">
                </div>
                <div class="file-input-container">
                    <label for="profil">Votre photo de profil</label>
                    <input type="file" name="profil" id="profil" accept="image/*">
                    <span class="file-name">Aucun fichier choisi</span>
                </div>
                <br>
                <input type="submit" value="S'inscrire" name="soumetre">
            </form>
            <p><a href="connexion.php">Se connecte</a></p>
            <p><a href="index.php">Retour</a></p>
        </div>
    </div>
</div>
</body>

</html>