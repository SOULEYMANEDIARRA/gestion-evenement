<?php
require_once 'navbare.php';
require_once 'config.php';
require_once 'model/Users.php';

$new_user = new Users($pdo);
?>
<div class="titre">
    <h1>Les utlisateurs</h1>
</div>
<?php
if (isset($_POST['btn'])) {
    $new_user->deBenir();
}
if (isset($_POST['btn2'])) {
    $new_user->banir();
}
$users = $new_user->allUsert(); ?>
<div class="comments-section">
    <?php
    foreach ($users as $v) {
        $bani = $v['bani'];
        $prenom = $v['prenom'];
        $nom = $v['nom'];
        $numero = $v['numero'];
        $id = $v['id'];
        $profil = $v['profil'];
        if ($bani === 0) { ?>
            <div class="comment user1">
                <div class="comment1">
                    <img src="<?php echo ($profil) ?>" class="profil2" alt="Photo de profif" /><br>
                    <p>
                        <?php echo "$prenom  $nom $numero" ?>
                    </p>
                </div>
                <div class="comment-content">
                    <form action="" method="post">
                        <button name="btn" value="<?php echo $id ?>"> Bannir </button>
                    </form>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="comment user1">
                <div class="comment1">
                    <img src="<?php echo ($profil) ?>" class="profil2" alt="Photo de profif" /><br>
                    <p>
                        <?php echo "$prenom  $nom $numero" ?>
                    </p>
                </div>
                <div class="comment-content">
                    <form action="" method="post">
                        <button name="btn2" value="<?php echo $id ?>"> Débanir </button>
                    </form>
                </div>
            </div>
    <?php }
    } ?>
</div>

</body>

</html>