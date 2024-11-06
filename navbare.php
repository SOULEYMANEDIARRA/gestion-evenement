<?php
session_start();
require_once 'config.php';
require_once 'model/Select.php';
require_once 'model/UserModel.php';
require_once 'model/Organisation.php';
require_once 'model/Update.php';
require_once 'model/ErrorMessages.php';


$select = new Select($pdo);
$new_update = new Update($pdo);
$new_update->profilUpdate1();

$model = new UserModel($pdo);
$user = $model->user($_SESSION['numero']);

$_SESSION['profil'] = $user['profil'];
$_SESSION['admit']  = $user['admit'];
$_SESSION['trie'] = 'evn_id';
$_SESSION['order'] = 'ASC';
$_SESSION['user_id'] = $user['id'];

?>
<header>
    <section>
        <div class="header_div1">
            <p class="">LOGO </p>
            <div class="tri" id="span">
                <p>Trier</p>
                <p class="tri1" id="span2">^</p>
            </div>
        </div>
        <div class="gauche" id="test2">
            <p> <a href="page2.php">Acceuil</a></p>
            <p> <a href="historique.php">Historique</a></p>
            <p><a href="new.php"> Créer Événement </a></p>
            <p><a href="mes_evn.php">Mes Événements</a></p>
            <p> <a href="mes_evn_passe.php">Événements Passés </a></p>
            <p> <a href="mes_reservation.php">Réservations</a></p>
            <p> <a href="reservation_passe.php">Réservations Passées</a></p>

            <?php if ($_SESSION['admit']  === 1) { ?>
                <p><a href="utlisateurs.php">Les utlisateurs</a></p>
            <?php
            } ?>
        </div>
        <div class="droite">
            <div class="droite">
                <img src="menus.png" alt="" class="menu" id="test1">
                <img src=" <?php echo $user['profil'] ?>" id="profil" alt="">
            </div>
        </div>
    </section>
    <div id="trie" class="magie0">
        <form action="" class="trie">
            <h4>rier par</h4>
            <button name="trie" value="a_z">A-Z</button>
            <button name="trie" value="z_a">Z-A</button>
            <button name="trie" value="categorie">categorie</button>
            <button name="trie" value="date">Date de creation </button>
        </form>
    </div>
</header>
<?php


$firsname = $user['prenom'];
$lastname = $user['nom'];
?>
<div class="div_none" id="none">
    <div class="none1" id="none1_id">
    </div>
    <div class="none4">
        <div class="div2_profil" id="none2_id">
            <div>
                <div class="titre">
                    <h1>Mon Profil</h1>
                </div>
                <img src=" <?php echo $user['profil'] ?>" class="profil" alt="Photo de profif">
                <br>
                <h3><?php echo "Bonjour $firsname $lastname !" ?> </h3>
                <br>
                <p id="button1">Gérer votre compte </p>
                <br>
            </div>
        </div>
        <div class="div2_profil" id="none3_id">
            <div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="new_nom">Prenom</label>
                        <input type="text" name="nom" id="new_nom" value="<?php echo $firsname ?>">
                    </div>
                    <br>
                    <div>
                        <label for="new_prenom">Nom</label>
                        <input type="text" name="prenom" id="new_prenom" value="<?php echo $lastname ?>">
                    </div>
                    <br>
                    <div class="file-input-container">
                        <label for="fvffffff">Photo de profil</label>
                        <input type="file" id="fvffffff" name="profil" accept="image/*">
                        <span class="file-name">Aucun fichier choisi</span>
                    </div>
                    <br>
                    <input type="submit" value="Modifier" name="Modifier">
                </form>
            </div>
        </div>
    </div>
</div>

</body>


</html>