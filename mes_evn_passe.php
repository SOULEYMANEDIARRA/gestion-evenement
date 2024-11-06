<?php
require_once 'navbare.php';
require_once 'config.php';
require_once 'model/UserModel.php';
require_once 'model/Env.php';
$model = new UserModel($pdo);
$new_evn = new Evn($pdo);

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
function evenement($evn, $model, $pdo)
{

    $day = $model->formatDate($evn['ev_date']);
    $day1 = $model->formatDate($evn['ev_fin']);
    $images = new EvnImages($pdo);
    $first_image = $images->firsImage($evn['evn_id']);
?>
    <div class="centre1 ">
        <div class="centre2 ">
            <div class="evenement">
                <div class="evn_image">
                    <img src="<?php echo $first_image ?>">
                </div>
                <div class="evn_details">
                    <p><strong>Titre :</strong> <?php echo $evn['titre']; ?></p>
                    <p><strong>Lieu :</strong> <?php echo $evn['lieu']; ?></p>
                    <p><strong>Début :</strong> <?php echo $day; ?></p>
                    <p><strong>Fin :</strong> <?php echo $day1; ?></p>
                    <p><strong>Type :</strong> <?php echo $evn['ev_type'] . ' / ' . $evn['prive_public']; ?></p>
                    <p><strong>Vip disponible :</strong> <?php echo $evn['vip']; ?></p>
                    <p><strong>Standart disponible :</strong> <?php echo $evn['standart']; ?></p>
                    <p><strong>Early disponible :</strong> <?php echo $evn['Early']; ?></p>
                    <p><strong>Description:</strong> <?php echo $evn['ev_description']; ?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="titre">
    <h1>Historique de mes evenement</h1>
</div>
<section class="les_evenements ">
    <?php
    $liste = $new_evn->userEvn($_SESSION['user_id'], $_SESSION['trie'], $_SESSION['order']);
    foreach ($liste as $v):
        $date1 = new DateTime();
        $date2 = new DateTime($v['ev_fin']);
        if ($date2 < $date1) {    ?>
            <div> <?php evenement($v, $model, $pdo); ?> </div>
    <?php
        }
    endforeach ?>
</section>
</body>

</html>