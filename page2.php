<?php
require_once 'navbare.php';
require_once 'config.php';
require_once 'model/Select.php';
require_once 'model/UserModel.php';
require_once 'model/Organisation.php';
$_SESSION['user_id'] = $user['id'];

require_once 'model/Update.php';
require_once 'model/ErrorMessages.php';

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


$select = new Select($pdo);
$new_update = new Update($pdo);
$model = new UserModel($pdo);
$user = $model->user($_SESSION['numero']);



if ($user['bani'] === 0) {

    function evenement($evn, $pdo)
    {
        $organisation = new Organisation($pdo);
        echo $organisation->test1($evn);
    } ?>
    <section class="les_evenements">
        <?php
        $liste = $select->allEvn($_SESSION['trie'], $_SESSION['order']);
        foreach ($liste as $v):
            $date1 = new DateTime();
            $date2 = new DateTime($v['ev_fin']);
            if ($date2 > $date1) {
        ?>
                <div> <?php evenement($v, $pdo); ?> </div>
        <?php }
        endforeach ?>
    </section>

<?php
} elseif ($user['bani'] === 1) { ?>
    <div class="centre1">
        <div class="centre2 import">
            <div class="danger">
                <h1>Vous ète bani</h1>
            </div>
        </div>
    </div>
<?php
} ?>
</body>


</html>