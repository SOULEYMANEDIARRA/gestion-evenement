<?php
require_once 'navbare.php';
require_once 'config.php';
require_once 'model/UserModel.php';
require_once 'model/ErrorMessages.php';
require_once 'model/Insert.php';
require_once 'model/Select.php';
require_once 'model/Organisation.php';

$organisation = new Organisation($pdo);
$model = new UserModel($pdo);
$new_select = new Select($pdo);
$new_insert = new Insert($pdo);

if (isset($_POST['voir_plus'])) {
    $_SESSION['voir_plus'] = $_POST['voir_plus'];
}

if (isset($_POST['comment']) && !empty(trim($_POST['comment']))) {
    $commentaire = htmlentities($_POST['comment']);
    $tab = [
        'id_user' =>   $_SESSION['user_id'],
        'id_evn' =>  $_SESSION['voir_plus'],
        'commentaire' =>   $commentaire
    ];
    $new_insert->insertInto($tab, 'commentaires');
}
?>
<?php

require_once 'control/TheCommentaires.php';
$commentaires = new TheCommentaires($pdo);
echo  $commentaires->evnCommentaires($_SESSION['voir_plus'], $_SESSION['user_id']);
?>
</body>

</html>