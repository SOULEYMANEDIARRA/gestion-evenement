<?php
class ModelCommende
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Achat d'un billet 
    public function achatBillet($billet, $champ, $evn_id)
    {
        $update = "UPDATE evenement SET $champ = :reste WHERE evn_id =:evn_id";
        $pdoStatement = $this->pdo->prepare($update);
        $pdoStatement->execute([
            'evn_id' => $evn_id,
            'reste' => $billet
        ]);
    }

    public function billets($evn_id)
    {
        $billet_acheter = 'SELECT * FROM billet_acheter WHERE id_user = :id_user AND id_evn = :id_evn';
        $pdoStatement = $this->pdo->prepare($billet_acheter);
        $pdoStatement->execute([
            'id_evn' => $evn_id,
            'id_user' => $_SESSION['user_id']
        ]);
       return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function firstBillet($evn_id,$valeur2,$champ2){
        $insert = "INSERT INTO billet_acheter (id_user, id_evn,$champ2) VALUES(:id_user, :id_evn, :champ)";
        $pdoStatement = $this->pdo->prepare($insert);
        $pdoStatement->execute([
            'id_user' => $_SESSION['user_id'],
            'id_evn' => $evn_id,
            'champ' => $valeur2
        ]);
    }

    public function updateBillet($evn_id,$reserve,$champ2){
        $update = "UPDATE billet_acheter SET $champ2 = :reserve WHERE id_user = :id_user AND id_evn = :id_evn";
        $pdoStatement = $this->pdo->prepare($update);
        $pdoStatement->execute([
            'id_user' => $_SESSION['user_id'],
            'id_evn' => $evn_id,
            'reserve' => $reserve
        ]);
    }

}
