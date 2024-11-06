<?php
require_once 'model/ErrorMessages.php';

class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function user($number): array
    {
        $stm = $this->pdo->prepare('SELECT * FROM users WHERE numero = :number AND  bani = :bani');
        $stm->execute([
            'number' => $number,
            'bani' => 0
        ]);
        $user = $stm->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $user[0]['id'];
        return $user[0];
    }

    public function user1($id): array
    {
        $stm = $this->pdo->prepare('SELECT * FROM users WHERE id = :id AND  bani = :bani');
        $stm->execute([
            'id' => $id,
            'bani' => 0
        ]);
        $user = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $user[0];
    }
    public function formatDate($date)
    {

        $date = new DateTime($date);
        // Utiliser IntlDateFormatter pour formater la date en français
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::SHORT);
        $formatter->setPattern('EEEE d MMMM y, HH:mm');

        // Afficher la date formatée
        $day = $formatter->format($date);
        return $day;
    }
    public static function dateTreatment($date1, $date2): array
    {
        $tab = [false];
        $date1 = htmlentities($_POST[$date1]);
        $date2 = htmlentities($_POST[$date2]);
        $time1 = new DateTime($date1);
        $time2 = new DateTime($date2);
        $x = $time2->format('Y');
        if ($time1 < $time2 && ($x < 2100)) {
            $tab[0] = true;
        }
        $tab[] = $date1;
        $tab[] = $date2;
        return $tab;
    }

    public static function dateVerify($date1, $date2)
    {
        $date0 = new DateTime();
        $date1 = new DateTime(htmlentities($_POST[$date1]));
        $date2 = new DateTime(htmlentities($_POST[$date2]));
        $time = $date2->format('Y');
        if ($date0 <= $date1 && $date1 <= $date2 && $time < 2100) {
            return true;
        } else {
            echo  ErrorMessages::dateInvalide();
            return false;
        }
    }
}
