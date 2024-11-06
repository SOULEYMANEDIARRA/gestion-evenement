<?php

require_once 'UserModel.php';
require_once 'ErrorMessages.php';
require_once 'EvnImages.php';

$new_model = new UserModel($pdo);

class Update
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function miseAJour($evn_id, $array)
    {
        $tab =  $this->verification($array);
        if (!empty($tab)) {
            foreach ($tab as $k => $v) {
                $update = "UPDATE evenement SET $k = :valeur  WHERE evn_id = :evn_id";
                $pdosatement = $this->pdo->prepare($update);
                $pdosatement->execute([
                    'evn_id' => $evn_id,
                    'valeur' => $v
                ]);
            }
        }
    }
    public function miseAJourUsers($id, $array)
    {
        $tab =  $this->verification($array);
        if (!empty($tab)) {
            foreach ($tab as $k => $v) {
                $update = "UPDATE users SET $k = :valeur  WHERE id = :id";
                $pdosatement = $this->pdo->prepare($update);
                $pdosatement->execute([
                    'id' => $id,
                    'valeur' => $v
                ]);
            }
        }
    }
    // verifie si toute les sont remplie 
    public function verification($tab): array
    {
        $update = [];
        foreach ($tab as $v) {
            if (isset($_POST[$v]) && strlen(trim($_POST[$v])) != 0) {
                $value = htmlentities($_POST[$v]);
                $update[$v] = $value;
            }
        }
        return $update;
    }

    public function pictureUpdate0($id, $valeur)
    {
            $update = "UPDATE evenement SET ev_image = :valeur  WHERE evn_id = :evn_id";
            $pdosatement = $this->pdo->prepare($update);
            $pdosatement->execute([
                'evn_id' => $id,
                'valeur' => $valeur
            ]);
    }

    public function pictureUpdate($champ, $table, $id)
    {
        if (!empty(isset(($_FILES[$champ]['tmp_name'])) && $_FILES[$champ]['tmp_name'])) {
            $valeur = file_get_contents(htmlentities($_FILES[$champ]['tmp_name']));
            $update = "UPDATE $table SET $champ = :valeur  WHERE evn_id = :evn_id";
            $pdosatement = $this->pdo->prepare($update);
            $pdosatement->execute([
                'evn_id' => $id,
                'valeur' => $valeur
            ]);
        }
    }
    public function dateUpdate($date1, $date2, $evn_id): bool
    {
        $day = UserModel::dateTreatment($date1, $date2);
        if ($day[0]) {
            $valeur = date('Y-m-d H:i:s', strtotime($day[1]));
            $valeur2 = date('Y-m-d H:i:s', strtotime($day[2]));
            $update = "UPDATE evenement SET ev_date = :valeur , ev_fin = :valeur2 WHERE evn_id = :evn_id";
            $pdosatement = $this->pdo->prepare($update);
            $pdosatement->execute([
                'evn_id' => $evn_id,
                'valeur' => $valeur,
                'valeur2' => $valeur2
            ]);
            return true;
        } else {
            echo ErrorMessages::dateInvalide();
            return false;
        }
    }

    public function profilUpdate1()
    {
        $champ = ['prenom', 'nom'];
        $this->miseAJourUsers($_SESSION['user_id'], $champ);

        if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profil'])) {
            $sql = "UPDATE users SET profil = :profil WHERE  id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'profil' => EvnImages::profil(),
                'id' => $_SESSION['user_id'],
            ]);
        }
    }
}
