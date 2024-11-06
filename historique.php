<?php
require_once 'navbare.php';
require_once 'config.php';
require_once 'model/Select.php';
require_once 'model/UserModel.php';

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

$new_select = new Select($pdo);
$model = new UserModel($pdo);
?>
<div class="titre">
    <h1>Histotique des evenement</h1>
</div>

<?php
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
                    <p><strong>Type :</strong> <?php echo $evn['ev_type']; ?></p>
                    <form action="comment.php" method="post">
                        <br>
                        <button class="but1" name="voir_plus" value="<?php echo $evn['evn_id'] ?>">Les commentaires</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }

?>
<section class="les_evenements">
    <?php
    $liste = $new_select->allEvn($_SESSION['trie'], $_SESSION['order']);
    foreach ($liste as $v):
        $date1 = new DateTime();
        $date2 = new DateTime($v['ev_fin']);
        if ($date2 < $date1) {
    ?>
            <div> <?php evenement($v, $model, $pdo); ?> </div>
    <?php }
    endforeach ?>
</section>
<?php
?>
</body>

</html>