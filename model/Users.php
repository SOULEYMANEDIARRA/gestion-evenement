<?php
class Users
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function allUsert(): array
    {
        $stm = $this->pdo->prepare('SELECT * FROM users WHERE admit =:admit');
        $stm->execute([
            'admit' => 0
        ]);
        $users = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function banir()
    {
        $user_id = (int) htmlentities($_POST['btn2']);
        $update = "UPDATE users SET bani = :valeur  WHERE id = :id";
        $pdosatement = $this->pdo->prepare($update);
        $pdosatement->execute([
            'id' => $user_id,
            'valeur' => 0,
        ]);
    }
    public function deBenir(){
        $user_id = (int) htmlentities($_POST['btn']);
        $update = "UPDATE users SET bani = :valeur  WHERE id = :id";
        $pdosatement = $this->pdo->prepare($update);
        $pdosatement->execute([
            'id' => $user_id,
            'valeur' => 1
        ]);
    }
}
