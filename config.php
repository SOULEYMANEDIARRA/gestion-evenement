<?php
// systemctl stop apache2.service

$debut = 50000000;
$fin = 99999999;

date_default_timezone_set('Africa/Bamako');
$DB_DNS = 'localhost';
$DB_NAME = 'evn';
$DB_USER = 'root';
$DB_PASS = '';
try {
    $pdo = new PDO('mysql:host=' . $DB_DNS . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $pe) {
    die('Erreur => ' . $pe->getMessage());
}
$debut = 50000000;
$fin = 99999999;
function values($input)
{
    if (isset($_POST[$input])) { ?>
        value="<?php echo $_POST[$input] ?>"
<?php }
}

$requet = 'CREATE TABLE IF NOT EXISTS users (
id INT NOT NULL AUTO_INCREMENT ,
nom VARCHAR(100) NOT NULL ,
prenom VARCHAR(100) NOT NULL , 
numero INT NOT NULL , 
password` VARCHAR(100) NOT NULL ,
profil LONGBLOB NOT NULL , 
bani INT NOT NULL DEFAULT 0 ,
admit` INT NOT NULL DEFAULT  ,
PRIMARY KEY (id)) ENGINE = InnoDB';


$créer = 'CREATE TABLE IF NOT EXISTS evenement (
evn_id INT NOT NULL AUTO_INCREMENT ,
titre VARCHAR(100) NOT NULL ,
lieu VARCHAR(100) NOT NULL , 
ev_date DATETIME NOT NULL ,
ev_fin DATETIME NOT NULL ,
prive_public VARCHAR(100) NOT NULL ,
ev_type VARCHAR(100) NOT NULL ,
vip INT NOT NULL ,
prix_vip INT NOT NULL , 
standart INT NOT NULL , 
prix_standart INT NOT NULL ,
early INT NOT NULL ,
prix_early INT NOT NULL ,
ev_description TEXT NOT NULL ,
ev_image LONGBLOB NOT NULL , 
PRIMARY KEY (evn_id),
user_id INT,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE = InnoDB';
$pdosatement = $pdo->prepare($créer);
$pdosatement->execute();

$billet_acheter = 'CREATE TABLE IF NOT EXISTS billet_acheter(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL ,
    id_evn INT NOT NULL ,
    nbre_vip INT ,
    nbre_standart INT ,
    nbre_early INT ,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_evn) REFERENCES evenement(evn_id) ON DELETE CASCADE
    )';
$pdosatement = $pdo->prepare($billet_acheter);
$pdosatement->execute();
$commentaire = 'CREATE TABLE IF NOT EXISTS commentaires(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL ,
    id_evn INT NOT NULL ,
    commentaire TEXT,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_evn) REFERENCES evenement(evn_id) ON DELETE CASCADE
    )';
$pdosatement = $pdo->prepare($commentaire);
$pdosatement->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- 
    <link rel="stylesheet" href="page2.css">
    <link rel="stylesheet" href="form.css"> -->
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/new.css">
    <script src="script/script.js" defer></script>
</head>

<body id="body">