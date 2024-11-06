<?php
require_once 'model/UserModel.php';
require_once 'model/ErrorMessages.php';

class Insert
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Insertion d'un tableau de donné dans la BDD
    public function insertInto(array $tab, string $table)
    {
        $colums = array_keys($tab);
        $columnsString = implode(', ', $colums);
        $placeholders = ':' . implode(', :', $colums);
        $insert = "INSERT INTO $table ($columnsString) VALUES ($placeholders)";
        $pdoStatement = $this->pdo->prepare($insert);
        $pdoStatement->execute($tab);
    }

    // Verifie si toute les champ sont remplie
    public static function verifyArray($tab, $button)
    {
        if (isset($_POST[$button])) {

            foreach ($tab as $v) {
                if ((isset($_POST[$v]) && strlen(trim($_POST[$v])) == 0) || !isset($_POST[$v])) {
                    echo ErrorMessages::nonRemplie();
                    return false;
                }
            }
            return true;
        }
    }
}
