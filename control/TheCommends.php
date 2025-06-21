<?php
require_once '/home/souleymane/Documents/Dev/PHP/mes_fichiers/model/ErrorMessages.php';
require_once '/home/souleymane/Documents/Dev/PHP/mes_fichiers/model/UserModel.php';
require_once '/home/souleymane/Documents/Dev/PHP/mes_fichiers/model/EvnImages.php';
require_once 'TheCommentaires.php';

class TheCommends
{
    private $pdo;
    private $organisation;
    private $select;
    private $commentaire;
    private $model;
    private $images;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->organisation = new Organisation($pdo);
        $this->select = new Select($pdo);
        $this->commentaire = new TheCommentaires($pdo);
        $this->model = new UserModel($pdo);
        $this->images = new EvnImages($pdo);
    }

    public function commentairesCommendes($evn_id, $condition_vip, $condition_standart, $condition_early, $coditio)
    {

        if ($coditio) {
            echo $this->commendes($evn_id, $condition_vip, $condition_standart, $condition_early);
        } else {
            echo $this->commentaire->evnCommentaires($evn_id, $_SESSION['user_id']);
        }
    }
    private function returnImage($index, $image)
    {
        return <<<HTML
            <img src="{$image}" class='thumbnail' alt='Miniature' onclick="openModal({$index})" />
HTML;
    }

    private function otherImage($evn_id)
    {
        $images = $this->images->otherImage($evn_id);
        $images_array = '';
        foreach ($images as $index => $image) {
            $images_array .= $this->returnImage($index, $image);
        }
        return $images_array;
    }

    public function commendes($evn_id, $condition_vip, $condition_standart, $condition_early)
    {
        $evn = $this->select->evenement($evn_id);

        $day = $this->model->formatDate($evn['ev_date']);
        $day1 = $this->model->formatDate($evn['ev_fin']);
        $img = $this->images->firsImage($evn_id);
        $other_images = $this->otherImage($evn_id);
        $message_vip = ErrorMessages::achat($condition_vip, 'vip');
        $message_standart = ErrorMessages::achat($condition_standart, 'standart');
        $message_early = ErrorMessages::achat($condition_early, 'early');

        return <<<HTML
        <div class="titre">
            <h1>Achat</h1>
         </div>
        <div class="centre1">
            <div class="centre2 ">
               <div class="evenement1">
                    <div class="picture">
                        <div class="image2">
                            <img src="{$img}"  alt="Photo de profif" />
                        </div>
                        <div class="other_image">
                         $other_images
                        </div>
                    </div>
                    <div class="evenement3">
                        <div class="evn_details">
                            <p><strong>Titre :</strong> {$evn['titre']}</p>
                            <p><strong>id :</strong> {$evn['evn_id']}</p>
                            <p><strong>Lieu :</strong> {$evn['lieu']}</p>
                            <p><strong>Début :</strong> $day</p>
                            <p><strong>Fin :</strong> $day1</p>
                            <p><strong>Type :</strong> {$evn['ev_type']}  {$evn['prive_public']}</p>
                            <p><strong>Vip disponible :</strong> {$evn['vip']}</p>
                            <p><strong>Standart disponible :</strong> {$evn['standart']}</p>
                            <p><strong>Early Bird disponible :</strong> {$evn['early']}</p>
                            <p><strong>Description:</strong> {$evn['ev_description']}</p>
                            <p><strong>L'auteur :</strong> {$evn['prenom']} {$evn['nom']}</p>  
                         </div>
                        <form action="" method="post">
                            <h3>Achettez vos billet</h3>
                            <label> VIP {$evn['prix_vip']} f <br><br> <input type="number" name="vip"> </label>
                            $message_vip 
                            <label> Standart {$evn['prix_standart']} f <br><br> <input type="number" name="standart"> </label>
                            $message_standart
                            <label> Early Bird {$evn['prix_early']}f <br><br> <input type="number" name="early"> </label>
                             $message_early
                            <input type="submit" name="commende" value="commende">
                            <br>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    HTML;
    }
}
