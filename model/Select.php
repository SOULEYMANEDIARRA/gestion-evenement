<?php
class Select
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // l'evenement d'un utlisateur
    public function evenement($evn_id,$trie = 'e.evn_id', $order = 'ASC')
    {
        $les_evenement = "SELECT * FROM evenement e JOIN users u ON e.user_id = u.id WHERE  e.evn_id = :evn_id AND u.bani =:bani ORDER BY $trie $order";
        $pdoStatement = $this->pdo->prepare($les_evenement);
        $pdoStatement->execute([
            'evn_id' => $evn_id,
            'bani' => 0
        ]);
        $evenement = $pdoStatement->fetchAll();
        return $evenement[0];
    }
    public function allEvn($trie = 'evn_id', $order = 'ASC'): array
    {
        $stm = $this->pdo->prepare("SELECT * FROM evenement e JOIN users u ON e.user_id = u.id WHERE u.bani = :bani ORDER BY $trie $order");
        $stm->execute([
            'bani' => 0
        ]);
        $all_env = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $all_env;
    }
    public function canComment($user_id, $evn_id): bool
    {
        $participant = 'SELECT * FROM billet_acheter b JOIN evenement e ON e.evn_id = b.id_evn WHERE b.id_user = :id_user AND e.evn_id = :evn_id';
        $pdoStatement = $this->pdo->prepare($participant);
        $pdoStatement->execute([
            'id_user' => $user_id,
            'evn_id' => $evn_id
        ]);
        $liste = $pdoStatement->fetchAll();
        if (empty($liste)) {
            return false;
        } else {
            return true;
        }
    }

    // les commentaire d'un evn
    public function evnCommentaires($evn_id)
    {
        $commentaires = 'SELECT * FROM commentaires c JOIN users u ON u.id = c.id_user WHERE id_evn = :id_evn';
        $pdoStatement = $this->pdo->prepare($commentaires);
        $pdoStatement->execute([
            'id_evn' => $evn_id
        ]);

        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function userReservation($trie = 'evn_id', $order = 'ASC')
    {
        $select = "SELECT * FROM billet_acheter b JOIN evenement e ON e.evn_id = b.id_evn WHERE id_user = :id_user ORDER BY $trie $order";
        $pdoStatement = $this->pdo->prepare($select);
        $pdoStatement->execute([
            'id_user' => $_SESSION['user_id']
        ]);
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function billetAchete($evn_id)
    {
        $tab = [0, 0, 0];
        $select = 'SELECT * FROM billet_acheter b JOIN evenement e ON e.evn_id = b.id_evn JOIN users u ON b.id_user = u.id WHERE id_evn = :id_evn';
        $pdoStatement = $this->pdo->prepare($select);
        $pdoStatement->execute([
            'id_evn' => $evn_id
        ]);
        $billets = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($billets)) {
            foreach ($billets as $billet) {
                $tab[0] += $billet['nbre_vip'];
                $tab[1] += $billet['nbre_standart'];
                $tab[2] += $billet['nbre_early'];
            }
        }
        return($tab);
    }
}
