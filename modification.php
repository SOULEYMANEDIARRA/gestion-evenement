<?php
session_start();
require_once 'config.php';
require_once 'model/Update.php';
require_once 'model/Select.php';
require_once 'model/UserModel.php';
require_once 'model/ErrorMessages.php';
require_once 'model/EvnImages.php';

$new_model = new UserModel($pdo);
$new_update = new Update($pdo);
$new_select = new Select($pdo);

$evn_id = $_SESSION['evn_id'];
$public = false;
$prive = false;
$mariage = false;
$concert = false;
$aniv = false;
$date_valide = false;
?>
<?php
$champ = ['id', 'titre', 'lieu', 'vip', 'standart', 'early', 'ev_description', 'ev_type', 'prive_public', 'prix_vip', 'prix_standart', 'prix_early'];
$new_update->miseAJour($evn_id, $champ);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
    $new_update->pictureUpdate0($evn_id, EvnImages::insetImage());
}


if ((isset($_POST['ev_date']) && isset($_POST['ev_fin']) && (!empty(trim($_POST['ev_date'])) && !empty(trim($_POST['ev_fin']))))) {
    $date_valide = $new_update->dateUpdate('ev_date', 'ev_fin', $evn_id);
}

if (isset($_POST['soumetre']) && $date_valide) {
    header('location:mes_evn.php');
}

$evn = $new_select->evenement($evn_id);

?>
<?php ?>
<div class="inscription centre1 div1_new">
    <div class="centre2 div2_new">
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" value="<?php echo $evn['titre'] ?>">
                </div>
                <div class="input-group">
                    <label for="lieu">Lieu</label>
                    <input type="text" name="lieu" id="lieu" value="<?php echo $evn['lieu'] ?>">
                </div>
                <div class="input-group">
                    <label for="ev_date">Date</label>
                    <input type="datetime-local" name="ev_date" id="ev_date" value="<?php echo $evn['ev_date'] ?>">
                </div>
                <div class="input-group">
                    <label for="ev_fin">Fin</label>
                    <input type="datetime-local" name="ev_fin" id="ev_fin" value="<?php echo $evn['ev_fin'] ?>">
                </div>

                <div class="radio-group">
                    <p>Type d'événement :</p>
                    <label><input type="radio" name="prive_public" value="prive" <?php echo ErrorMessages::checkbox1($evn['prive_public'], 'prive') ?>> Privé</label>
                    <label><input type="radio" name="prive_public" value="public" <?php echo ErrorMessages::checkbox1($evn['prive_public'], 'public') ?>> Public</label>
                </div>

                <div class="radio-group">
                    <p>Catégorie :</p>
                    <label><input type="radio" name="ev_type" value="mariage" <?php echo ErrorMessages::checkbox1($evn['ev_type'], 'mariage') ?>> Mariage</label>
                    <label><input type="radio" name="ev_type" value="concert" <?php echo ErrorMessages::checkbox1($evn['ev_type'], 'concert') ?>> Concert</label>
                    <label><input type="radio" name="ev_type" value="aniv" <?php echo ErrorMessages::checkbox1($evn['ev_type'], 'aniv') ?>> Anniversaire</label>
                </div>

                <div class="billets">
                    <div class="input-group">
                        <label for="vip">VIP</label>
                        <input type="number" id="vip" name="vip" value="<?php echo $evn['vip'] ?>">
                    </div>
                    <div class="input-group">
                        <label for="prix_vip">Prix VIP</label>
                        <input type="number" id="prix_vip" name="prix_vip" value="<?php echo $evn['prix_vip'] ?>">
                    </div>
                    <div class="input-group">
                        <label for="standart">Standard</label>
                        <input type="number" id="standart" name="standart" value="<?php echo $evn['standart'] ?>">
                    </div>
                    <div class="input-group">
                        <label for="prix_standart">Prix Standard</label>
                        <input type="number" id="prix_standart" name="prix_standart" value="<?php echo $evn['prix_standart'] ?>">
                    </div>
                    <div class="input-group">
                        <label for="early">Early Bird</label>
                        <input type="number" id="early" name="early" value="<?php echo $evn['early'] ?>">
                    </div>
                    <div class="input-group">
                        <label for="prix_early">Prix Early Bird</label>
                        <input type="number" id="prix_early" name="prix_early" value="<?php echo $evn['prix_early'] ?>">
                    </div>
                </div>

                <div class="input-group">
                    <label for="ev_description">Description</label>
                    <textarea name="ev_description" id="ev_description"><?php echo $evn['ev_description'] ?></textarea>
                </div>

                <div class="file-input-container">
                    <label for="images">Image de l'événement</label>
                    <input required type="file" id="images" name="images[]" accept="image/*" multiple>
                    <span class="file-name">Aucun fichier choisi</span>
                </div>
                <br>
                <input type="submit" value="Soumettre" name="soumetre">
            </form>
        </div>
    </div>
</div>
</body>

</html>