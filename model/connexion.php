<?php
class Connexion
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // verifie si le numero de l'utilisateur est  dans la BDD
    public function userInscrit(int $number)
    {
        $stm = $this->pdo->prepare('SELECT * FROM users WHERE numero = :number');
        $stm->execute([
            'number' => $number
        ]);
        $user_data = $stm->fetchAll(PDO::FETCH_ASSOC);
        if (empty($user_data)) {
            return false;
        }
        return $user_data[0];
    }

    // verifie le mot de pass de l'utlisateur 
    public function verifypassword(int $number, string $password): bool
    {
        $user_data = $this->userInscrit($number);
        if ($user_data && $user_data['password'] === $password) {
            return true;
        }
        return false;
    }
}
