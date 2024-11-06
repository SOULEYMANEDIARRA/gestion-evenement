<?php
require_once 'library/vendor/autoload.php';
require_once 'Codeqr.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EnvoiEmail
{
    public static function envoi($info_billet)
    {

        try {
            $path = Codeqr::qrcode($info_billet);
            $mail = new PHPMailer(true);
            // Configuration SMTP
            $mail->isSMTP();
            $mail->Host       = 'localhost';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'user@example.com';  // Remplacez par votre utilisateur SMTP réel
            $mail->Password   = 'secret';            // Remplacez par votre mot de passe SMTP
            $mail->Port       = 1025;                // Le port du serveur SMTP, ici 1025 (exemple pour un serveur local comme MailHog)

            // Destinataire
            $mail->setFrom('user@example.com', 'Expéditeur');
            $mail->addAddress('destinataire@example.com');  // Remplacez par l'adresse email du destinataire

            // Sujet et corps de l'email
            $mail->Subject = 'Voici votre code QR';
            $mail->isHTML(true);
            $mail->Body    = '<h1>Ceci est votre billet en format QR code </h1>';
            $mail->Body   .= '<img src="cid:qrimage">';  // Référence à l'image intégrée

            // Ajouter le code QR comme image intégrée
            $mail->addEmbeddedImage($path, 'qrimage', 'qr-code.png', 'base64', 'image/png');

            // Envoyer l'email
            $mail->send();
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
        }
    }
}
