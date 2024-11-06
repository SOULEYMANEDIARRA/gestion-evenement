<?php
class Categorie
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function evenementSimilaires($type, $evn_id, $trie = 'evn_id', $order = 'ASC')
    {
        $stmt = $this->pdo->prepare("SELECT * FROM evenement e JOIN users u ON e.user_id = u.id WHERE ev_type = :ev_type AND evn_id != :evn_id ORDER BY $trie $order");
        $stmt->execute([
            'ev_type' => $type,
            'evn_id'  => $evn_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
