<?php
require_once '/home/souleymane/Documents/Dev/PHP/mes_fichiers/model/Organisation.php';
require_once '/home/souleymane/Documents/Dev/PHP/mes_fichiers/model/Select.php';
require_once '/home/souleymane/Documents/Dev/PHP/mes_fichiers/model/ErrorMessages.php';


class TheCommentaires
{
    private $pdo;
    private $organisation;
    private $select;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->organisation = new Organisation($pdo);
        $this->select = new Select($pdo);
    }

    public function evnCommentaires($sesion, $user_id)
    {
        $evn = $this->select->evenement($sesion);
        $formualire = null;
        $canComment = $this->select->canComment($user_id, $evn['evn_id']);
        if ($canComment) {
            $formualire = $this->formulaire();
        }
        $commentaires = $this->select->evnCommentaires($sesion);
        $content_hard1 =  $this->organisation->hard1($evn);
        $content1_hard2 =  Organisation::leH2($commentaires);
        $balises = $this->generatCommentaire($evn, $commentaires, $evn['evn_id']);
        return <<<HTML
               <div class="titre">
                  <h1>Les Commentaires</h1>
                </div>
                <div class="centre1">
                    <div class="centre2 comment2">
                        <div>
                            <div class="hard">
                                <div class="hard1">
                                    $content_hard1
                                </div>
                                <div class="hard2">
                                $content1_hard2
                                    <div class="comments-section">
                                    $balises
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                          $formualire
                        </div>
                    </div>
                </div>
HTML;
    }
    public function allcommentaires($sesion, $user_id)
    {
        $evn = $this->select->evenement($sesion);
        $formualire = null;
        $canComment = $this->select->canComment($user_id, $evn['evn_id']);
        if ($canComment) {
            $formualire = $this->formulaire();
        }
        $commentaires = $this->select->evnCommentaires($sesion);
        $content_hard1 =  $this->organisation->hard1($evn);
        $balises = $this->generatAllCommentaires($commentaires, $evn['evn_id']);
        return <<<HTML
<div class="titre">
     <h1>Les Commentaires</h1>
 </div>
    <div class="centre1">
        <div class="centre2 hard0 ">
            <div class="">
               <div class="hard">
                    <div class="hard1">
                        $content_hard1
                    </div>
                    <div class="hard2">
                        <h2>Commentaires</h2>
                        <div class="comments-section">
                           $balises
                        </div>
                    </div>
                </div>
            </div>
            <div class="div_commentaires">
              $formualire
            </div>
        </div>
    </div>
HTML;
    }
    public function generatCommentaire($evn, $commentaires, $evn_id)
    {
        $balise = '';
        if (count($commentaires) <= 3) {
            foreach ($commentaires as $commentaire) {
                $balise .= Organisation::lesCommenraires($commentaire, $evn_id, $this->pdo);
            }
        } else {
            for ($i = 0; $i <= 2; $i++) {
                $balise .= Organisation::lesCommenraires($commentaires[$i], $evn_id, $this->pdo);
            }
            $balise .= Organisation::voirPlus($evn, 'allCommentairs.php');
        }

        return $balise;
    }
    public function generatAllCommentaires($commentaires, $evn_id)
    {
        $balise = '';
        foreach ($commentaires as $commentaire) {
            $balise .= Organisation::lesCommenraires($commentaire, $evn_id, $this->pdo);
        }
        return $balise;
    }
    public function formulaire()
    {
        return <<<HTML
                <form action="" method="post" class="comment-form">
                    <label for="comment">Commentaire</label>
                     <textarea name="comment" id="comment" rows="5" placeholder="Écris ton commentaire ici..."></textarea>
                    <button type="submit">Envoyer</button>
                </form>
HTML;
    }
}
