<?php
require_once 'navbare.php';
require_once 'config.php';
require_once 'model/Env.php';
require_once 'model/UserModel.php';
require_once 'model/EvnImages.php';
$evn_list = new Evn($pdo);
$model = new UserModel($pdo);
?>
<?php
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

if (isset($_POST['btn'])) {
    $_SESSION['evn_id'] = $_POST['btn'];
    header('location:modification.php');
}
if (isset($_POST['btn2'])) {
    $evn_list->deleteEvn($_POST['btn2']);
}
?>
<div class="titre">
    <h1>Mes Évènement</h1>
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
                    <p><strong>Type :</strong> <?php echo $evn['ev_type'] . '/' . $evn['prive_public']; ?></p>
                    <p><strong>Description:</strong> <?php echo $evn['ev_description']; ?></p>
                    <p><strong>Vip disponible :</strong> <?php echo $evn['vip'] ?> // Prix : <?php echo $evn['prix_vip'] ?></p>
                    <p><strong>Standart disponible :</strong> <?php echo $evn['standart'] ?> // Prix : <?php echo $evn['prix_standart'] ?></p>
                    <p><strong>Early Bird disponible :</strong> <?php echo $evn['early'] ?> // Prix : <?php echo $evn['prix_early'] ?> </p>
                    <form action="" method="post" class="but_form">
                        <button class="but2" value="<?php echo $evn['evn_id'] ?>" name="btn">Modifier</button>
                        <button class="but2" value="<?php echo $evn['evn_id'] ?>" name="btn2">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
$liste = $evn_list->userEvn($_SESSION['user_id'], $_SESSION['trie'], $_SESSION['order']);
if (!empty($liste)) { ?>
    <section class="les_evenements">
        <?php
        $already = true;
        foreach ($liste as $v):
            $date1 = new DateTime();
            $date2 = new DateTime($v['ev_fin']);
            if ($date2 > $date1) { ?>
                <div> <?php evenement($v, $model, $pdo); ?> </div>
        <?php
                $already = true;
            }
        endforeach; 
        if ($already){ ?>
                <p>Vous n'avez pas d'evenement en cour <a href="new.php">Cliquez-ici</a> pour Créer un evenement </p>
        <?php
        }
        ?>
        
    </section>
<?php
} else {
?>
    <p>Vous n'avez pas Créer d'evenement <a href="new.php">Cliquez-ici</a> pour Créer votre premier evenement </p>
<?php
}
?>
</body>

</html>