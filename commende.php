<?php
require_once 'navbare.php';
require_once 'config.php';
require 'vendor/autoload.php';
require_once 'model/ErrorMessages.php';
require_once 'model/UserModel.php';
require_once 'model/ModelCommende.php';
require_once 'model/Select.php';
require_once 'model/Categorie.php';
require_once 'model/EnvoiEmail.php';
require_once 'model/Organisation.php';
require_once 'control/TheCommends.php';
require_once 'model/EvnImages.php';

if (isset($_GET['trie'])) {
    $value = ($_GET['trie']);
    switch ($value) {
        case "a_z":
            $_SESSION['trie'] = 'titre';
            $_SESSION['order'] = 'ASC';
            break;
        case "z_a":
            $_SESSION['trie'] = 'titre';
            $_SESSION['order'] = 'DESC';
            break;
        case "categorie":
            $_SESSION['trie'] = 'ev_type';
            $_SESSION['order'] = 'ASC';
            break;
        case "date":
            $_SESSION['trie'] = 'ev_date';
            $_SESSION['order'] = 'ASC';
            break;
        default:
            $_SESSION['trie'] = 'evn_id';
            $_SESSION['order'] = 'ASC';
    }
}

$commendess = new TheCommends($pdo);
$model = new UserModel($pdo);
$categorie = new Categorie($pdo);
$organisation = new Organisation($pdo);
$new_select = new Select($pdo);
$commende = new ModelCommende($pdo);
$images = new EvnImages($pdo);

if (isset($_POST['voir_plus'])) {
    $_SESSION['voir_plus'] = $_POST['voir_plus'];
}
$evn_id =  $_SESSION['voir_plus'];
$condition_vip = 0;
$condition_standart = 0;
$condition_early = 0;

$evn = $new_select->evenement($evn_id);
$_SESSION['categorie'] = $evn['ev_type'];
?>

<?php
$user = $model->user1($_SESSION['user_id']);
function commende($champ, $commende, $user, $evn_id, $champ2, $new_select)
{
    $billet_restant = (int) htmlentities($_POST[$champ]);
    if ($billet_restant > 0) {

        $liste = $new_select->evenement($evn_id);
        $billet = $liste[$champ];

        if ($billet >= $billet_restant) {
            for ($i = 0; $i <= $billet_restant; $i++) {
                $commende->achatBillet($billet, $champ, $evn_id);
                $heure = new DateTime();
                $h2 = $heure->format('d-m-Y H:i:s');
                $info_billet = $user['prenom'] . '' . $user['nom'] . '' . $champ . '' . 'N' . '' . $billet . '' . $h2;
                EnvoiEmail::envoi($info_billet);
                $billet--;
            }

            $liste = $commende->billets($evn_id);
            if (empty($liste)) {
                $commende->firstBillet($evn_id, $billet_restant, $champ2);
            } else {
                $reserve = $liste[0][$champ2];
                $reserve += $billet_restant;
                $commende->updateBillet($evn_id, $reserve, $champ2);
            }
            return 3;
        }
        if ($billet < $billet_restant && $billet > 0) {
            return 1;
        } elseif ($billet == 0) {
            return 2;
        }
    }
}


if (isset($_POST['vip']) && strlen($_POST['vip'])) {
    $condition_vip = commende('vip', $commende, $user, $evn_id, 'nbre_vip', $new_select);
}
if (isset($_POST['standart']) && strlen($_POST['standart'])) {
    $condition_standart = commende('standart', $commende, $user, $evn_id, 'nbre_standart', $new_select);
}
if (isset($_POST['early']) && strlen($_POST['early'])) {
    $condition_early = commende('early', $commende, $user, $evn_id, 'nbre_early', $new_select);
}

$coditio = null;
$date1 = new DateTime();
$date2 = new DateTime($evn['ev_fin']);
if ($date2 > $date1) {
    $coditio = true;
} else {
    $coditio = false;
}

$commendess->commentairesCommendes($evn_id, $condition_vip, $condition_standart, $condition_early, $coditio);

$similaires = $categorie->evenementSimilaires($_SESSION['categorie'], $evn_id, $_SESSION['trie'], $_SESSION['order']);
?>
<?php if (!empty($similaires)) { ?>
    <h2>Evenement Similaires</h2>
    <section class="les_evenements">
        <?php
        foreach ($similaires as $similaire): ?>
            <div> <?php echo $organisation->test1($similaire) ?> </div>
        <?php
        endforeach ?>
    </section>
<?php }
$imagePaths = $images->otherImage($evn_id)
?>
<div id="imageModal" class="modal">
    <div class="modal-content">
        <button class="close" onclick="closeModal()">X</button>
        <button class="prev" onclick="prevImage()">&#10094;</button>
        <img id="largeImage" src="" alt="Grande Image">
        <button class="next" onclick="nextImage()">&#10095;</button>
    </div>
</div>

<script>
    let currentIndex = 0;
    const imagePaths = <?php echo json_encode($imagePaths); ?>;

    // Ouvre le modal avec l'image cliquée
    function openModal(index) {
        currentIndex = index;
        document.getElementById("largeImage").src = imagePaths[currentIndex];
        document.getElementById("imageModal").style.display = "flex";
    }

    // Ferme le modal
    function closeModal() {
        document.getElementById("imageModal").style.display = "none";
    }

    // Affiche l'image précédente
    function prevImage() {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : imagePaths.length - 1;
        document.getElementById("largeImage").src = imagePaths[currentIndex];
    }

    // Affiche l'image suivante
    function nextImage() {
        currentIndex = (currentIndex < imagePaths.length - 1) ? currentIndex + 1 : 0;
        document.getElementById("largeImage").src = imagePaths[currentIndex];
    }
</script>
</body>

</html>