<?php
class Evn
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // les evenements d'un utlisateur
    public function userEvn(int $id, $trie ='evn_id', $order ='ASC')
    {
        $smt = $this->pdo->prepare("SELECT * FROM evenement WHERE user_id = :user_id ORDER BY $trie $order");
        $smt->execute([
            'user_id' => $id
        ]);
        $user_evn = $smt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($user_evn)) {
            return false;
        }
        return $user_evn;
    }

    // suppression d'un evenements
    public function deleteEvn($evn_id){
        $btn2 = htmlentities($evn_id);
        $pdosatement = $this->pdo->prepare('DELETE FROM evenement WHERE evn_id = :evn_id');
        $pdosatement->execute([
            'evn_id' => $btn2
        ]);
    }
}
