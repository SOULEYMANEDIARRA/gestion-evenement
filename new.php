<?php
require_once 'navbare.php';
require_once 'config.php';
require_once 'model/Insert.php';
require_once 'model/ErrorMessages.php';
require_once 'model/UserModel.php';
require_once 'model/EvnImages.php';

$new_insert = new Insert($pdo);
$error_messages = new ErrorMessages($pdo);
$new_model = new UserModel($pdo);

$user_id = $_SESSION['user_id'];
$text = null;
$date_valide = null;

if (isset($_POST['ev_description']) && trim($_POST['ev_description']) != 0) {
    $text = htmlentities($_POST['ev_description']);
}
function vreifier($val1, $val2)
{
    if (isset($val1) && trim($val1) != 0 && $val1 == $val2) {
        return true;
    } else {
        return false;
    }
}
 $condition_public = vreifier($_POST['prive_public'], 'public');
 $condition_prive =  vreifier($_POST['prive_public'], 'prive');
 $condition_mariage =  vreifier($_POST['ev_type'], 'mariage');
 $condition_concert =  vreifier($_POST['ev_type'], 'concert');
 $condition_aniv =  vreifier($_POST['ev_type'], 'aniv');
function condition($debut)
{
    if ($debut) {
        echo 'checked';
    }
}
?>
<div class="titre">
    <h1>Creer un Evenement</h1>
</div> <?php

        $tab = ['ev_date', 'titre', 'lieu', 'prive_public', 'ev_type', 'vip', 'standart', 'early', 'ev_description', 'ev_fin', 'prix_vip', 'prix_standart', 'prix_early'];
        $champ = Insert::verifyArray($tab, 'soumetre');
        if ($champ) {
            $date_valide = UserModel::dateVerify('ev_date', 'ev_fin');
        }
        if ($date_valide && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {

            $date = htmlentities($_POST['ev_date']);
            $date2 = htmlentities($_POST['ev_fin']);
            $array =  [
                'ev_date' =>  $ev_date = date('Y-m-d H:i:s', strtotime($date)),
                'ev_fin'  =>  $ev_fin = date('Y-m-d H:i:s', strtotime($date2)),
                'prix_vip' =>   $prix_vip = (int) htmlentities($_POST['prix_vip']),
                'prix_standart' =>   $prix_standart = (int) htmlentities($_POST['prix_standart']),
                'prix_early' =>  $prix_early = (int) htmlentities($_POST['prix_early']),
                'titre' =>    $titre = htmlentities($_POST['titre']),
                'lieu' =>   $lieu = htmlentities($_POST['lieu']),
                'prive_public' =>  $prive_public = htmlentities($_POST['prive_public']),
                'ev_type' =>   $ev_type = htmlentities($_POST['ev_type']),
                'vip' =>  $vip = (int)htmlentities($_POST['vip']),
                'standart' =>   $standart = (int)htmlentities($_POST['standart']),
                'early' =>   $early = (int)htmlentities($_POST['early']),
                'ev_description' =>   $ev_description = htmlentities($_POST['ev_description']),
                'ev_image' =>  EvnImages::insetImage(),
                'user_id' => $user_id
            ];
            $new_insert->insertInto($array, 'evenement');
            header('location:mes_evn.php');
        }
        ?>
<div class="centre2 div2_new">
    <div class="inscription centre1 div1_new">
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateImages()">
                <div class="input-group">
                    <label for="titre">Titre</label>
                    <input required type="text" id="titre" name="titre" <?php values('titre') ?>>
                </div>
                <div class="input-group">
                    <label for="lieu">Lieu</label>
                    <input required type="text" name="lieu" id="lieu" <?php values('lieu') ?>>
                </div>
                <div class="input-group">
                    <label for="ev_date">Date</label>
                    <input required type="datetime-local" name="ev_date" id="ev_date" <?php values('ev_date') ?>>
                </div>
                <div class="input-group">
                    <label for="ev_fin">Fin</label>
                    <input required type="datetime-local" name="ev_fin" id="ev_fin" <?php values('ev_fin') ?>>
                </div>

                <div class="radio-group">
                    <p>Type d'événement :</p>
                    <label><input required type="radio" name="prive_public" value="prive" <?php condition($condition_prive) ?>> Privé</label>
                    <label><input required type="radio" name="prive_public" value="public" <?php condition($condition_public) ?>> Public</label>
                </div>

                <div class="radio-group">
                    <p>Catégorie :</p>
                    <label><input required type="radio" name="ev_type" value="mariage" <?php condition($condition_mariage) ?>> Mariage</label>
                    <label><input required type="radio" name="ev_type" value="concert" <?php condition($condition_concert) ?>> Concert</label>
                    <label><input required type="radio" name="ev_type" value="aniv" <?php condition($condition_aniv) ?>> Anniversaire</label>
                </div>

                <div class="billets">
                    <div class="input-group">
                        <label for="vip">VIP</label>
                        <input required type="number" id="vip" name="vip" <?php values('vip') ?>>
                    </div>
                    <div class="input-group">
                        <label for="prix_vip">Prix VIP</label>
                        <input required type="number" id="prix_vip" name="prix_vip" <?php values('prix_vip') ?>>
                    </div>
                    <div class="input-group">
                        <label for="standart">Standard</label>
                        <input required type="number" id="standart" name="standart" <?php values('standart') ?>>
                    </div>
                    <div class="input-group">
                        <label for="prix_standart">Prix Standard</label>
                        <input required type="number" id="prix_standart" name="prix_standart" <?php values('prix_standart') ?>>
                    </div>
                    <div class="input-group">
                        <label for="early">Early Bird</label>
                        <input required type="number" id="early" name="early" <?php values('early') ?>>
                    </div>
                    <div class="input-group">
                        <label for="prix_early">Prix Early Bird</label>
                        <input required type="number" id="prix_early" name="prix_early" <?php values('prix_early') ?>>
                    </div>
                </div>

                <div class="input-group">
                    <label for="ev_description">Description</label>
                    <textarea required name="ev_description" id="ev_description"><?php echo $text ?></textarea>
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
<script>
    function validateImages() {
        const input = document.getElementById('images');
        const files = input.files;
        if (files.length > 8) {
            alert("Vous pouvez sélectionner jusqu'à huit images seulement.");
            return false;
        }
        return true;
    }
</script>
</body>

</html>