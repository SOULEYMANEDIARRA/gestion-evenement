<?php
require_once 'model/UserModel.php';
require_once 'model/Select.php';
require_once 'model/EvnImages.php';
class Organisation
{
    private $pdo;
    private $model;
    private $new_select;
    private $images;


    public function __construct($pdo)
    {
        $model = new UserModel($pdo);
        $new_select = new Select($pdo);

        $this->pdo = $pdo;
        $this->model = $model;
        $this->new_select = $new_select;
        $this->images = new EvnImages($pdo);
    }

    // affichage avec le button voir plus
    public function test1($evn)
    {

        $day = $this->model->formatDate($evn['ev_date']);
        $day1 = $this->model->formatDate($evn['ev_fin']);
        $voir_pilus = $this->voirPlus($evn, 'commende.php');
        $first_image = $this->images->firsImage($evn['evn_id']);

        return <<<HTML
 <div class="centre1">
            <div class="centre2">
                <div class="evenement">
                    <div class="evn_image">
                        <img src="{$first_image}"/> 
                    </div>
                    <div class="evn_details">
                        <p><strong>Titre :</strong> {$evn['titre']}</p>
                        <p><strong>Lieu :</strong> {$evn['lieu']}</p>
                        <p><strong>Début :</strong> $day</p>
                        <p><strong>Fin :</strong> $day1</p>
                        <p><strong>Type :</strong> {$evn['ev_type']}</p>
                        $voir_pilus
                    </div>
                </div>
            </div>
        </div>
HTML;
    }
    // affichage pour achat
    public function test2($evn)
    {
        $commentaireeee = $this->hard1($evn);
        $day = $this->model->formatDate($evn['ev_date']);
        $day1 = $this->model->formatDate($evn['ev_fin']);
        $first_image = $this->images->firsImage($evn['evn_id']);
        $img = base64_encode($evn['ev_image']);
        if ($this->laDate($evn)) {
            return <<<HTML
        <div class="image2">
        <img src="{$first_image}"/> 
        </div>
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

HTML;
        } else {
            return <<<HTML
       <div class="hard">
            <div class="hard1">
                $commentaireeee
            </div>
       </div>
HTML;
        }
    }

    private function laDate($evn)
    {
        $date1 = new DateTime();
        $date2 = new DateTime($evn['ev_fin']);
        if ($date2 > $date1) {
            return true;
        }
        return false;
    }

    // Affichage pour les commentaires
    public function hard1($evn)
    {
        // les billets achetter de l'evn
        $billets = $this->new_select->billetAchete($evn['evn_id']);
        $day = $this->model->formatDate($evn['ev_date']);
        $day1 = $this->model->formatDate($evn['ev_fin']);
        $first_image = $this->images->firsImage($evn['evn_id']);
        $img = base64_encode($evn['ev_image']);
        return <<<HTML
         <div>
         <img src="{$first_image}"/> 
         </div>
        <div class="evn_details">
            <p><strong>Titre :</strong> {$evn['titre']} </p>
            <p><strong>Lieu :</strong> {$evn['lieu']}</p>
            <p><strong>Début :</strong> $day</p>
            <p><strong>Fin :</strong> $day1</p>
            <p><strong>Type :</strong> {$evn['ev_type']} // Prix :  {$evn['prive_public']}</p>
            <p><strong>Description:</strong> {$evn['ev_description']}</p>
            <p><strong>Vip achetter :</strong> {$billets[0]} // Prix : {$evn['prix_vip']}</p>
            <p><strong>Standart achetter :</strong> {$billets[1]} // Prix : {$evn['prix_standart']} </p>
            <p><strong>Early Bird achetter :</strong> {$billets[2]}  // Prix : {$evn['prix_early']}</p>
            <p><strong>L'auteur :</strong> {$evn['prenom']} {$evn['nom']}</p>
        </div>

HTML;
    }
    public static function lesCommenraires($commentaire , $evn_id, $pdo)
    {
        $images = new EvnImages($pdo);
        $profil = $commentaire['profil'];
        return <<<HTML
        <div class="comment">
            <div class="comment1">
            <img src="{$profil}"/> 
            <h3>   {$commentaire['prenom']} {$commentaire['nom']}</h3>
            </div>
            <div class="comment-content">
                <p> {$commentaire['commentaire']}</p>
                <small>Posté le {$commentaire['created_at']}</small>
            </div>
        </div>
HTML;
    }
    public static function voirPlus($evn, $page)
    {
        return <<<HTML
        <form action="{$page}" method="post">
          <button  name="voir_plus" value="{$evn['evn_id']}">Voir Plus</button>
        </form>
HTML;
    }

    public static function leH2($commentaires)
    {
        if (!empty($commentaires)) {
            return <<<HTML
          <h2>Commentaires</h2>
HTML;
        } else {
            return <<<HTML
        <h2>Pas de Commentaires</h2>
HTML;
        }
    }
}
