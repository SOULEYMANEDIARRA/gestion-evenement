<?php
class ErrorMessages
{
    public static function numeroInvalide()
    {
        return <<<HTML
            <div class="danger">
                <p>Numero invalide</p>
            </div>
HTML;
    }
    public static function notOnPlatform()
    {
        return <<<HTML
            <div class="danger">
                <p>Vous n'etes pas sur la platforme</p>
            </div>
HTML;
    }
    public static function incorrectPassmord()
    {
        return <<<HTML
            <div class="danger">
                <p>Mot de passe incorrect </p>
            </div>
HTML;
    }
    public static function notComment()
    {
        return <<<HTML
            <div class="danger">
                <p>Vous ne pouvez pas commentez cette evenement  </p>
            </div>
HTML;
    }
    public static function dateInvalide()
    {
        return <<<HTML
            <div class="danger">
                <p>Date invalide</p>
            </div>
HTML;
    }
    public static function nonRemplie()
    {
        return <<<HTML
        <div class="danger">
            <p>Vous devez rensegner toute les champ</p>
        </div>
HTML;
    }
    public static function achat($condition, $champ)
    {
        if ($condition === 1) {
            return  <<<HTML
        <div class="danger">
            <p>Insuffisaante $champ</p>
        </div>
HTML;
        } elseif ($condition === 2) {
            return <<<HTML
        <div class="danger">
            <p>terminé $champ</p>
        </div>
HTML;
        } elseif ($condition === 3) {

            return <<<HTML
        <div class="succes">
            <p>Achat Effectué avec succes</p>
        </div>
HTML;
        }
    }
    public static function checkbox1($prive_public, $champ)
    {

        if ($prive_public === $champ) {
            return 'checked';
        }
        return '';
    }
    public static function checkbox2($ev_type, $champ)
    {
        if ($ev_type === $champ) {
            return 'checked';
        }
        return '';
    }
}
