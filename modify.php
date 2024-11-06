<?php
session_start();
$btn3 = $_SESSION['btn3'];
require_once 'config.php';
if ((isset($_POST['btn4'])  && (int) $_POST['btn4'] === $btn3) && (isset($_POST['commente']) && strlen(trim($_POST['commente']))) != 0) {
    $btn4 = (int) htmlentities($_POST['btn4']);
    $valeur2 = htmlentities($_POST['commente']);
    $update = "UPDATE commentaires SET commentaire = :valeur  WHERE id = :id";
    $pdosatement = $pdo->prepare($update);
    $pdosatement->execute([
        'id' => $btn4,
        'valeur' => $valeur2
    ]);
    header('location:commentaires.php');
}
$select = 'SELECT * FROM commentaires WHERE id = :id';
$pdoStatement = $pdo->prepare($select);
$pdoStatement->execute([
    'id' => $btn3
]);
$liste = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
$valeur = $liste[0]['commentaire']
?>
<form action="" method="post">
    <label for="commente">Modifier</label>
    <textarea name="commente" id="commente"><?php echo $valeur ?></textarea>
    <button name="btn4" value="<?php echo $btn3 ?>">Modifier</button>
</form>