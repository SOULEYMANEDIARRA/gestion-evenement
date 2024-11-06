<?php
require_once 'library/vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\RoundBlockSizeMode;

class Codeqr
{
    public static function qrcode($info_billet)
    {
        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $info_billet ,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            // logoPath: __DIR__.'/assets/symfony.png',
            logoResizeToWidth: 50,
            logoPunchoutBackground: true,
            labelText: 'This is the label',
            labelFont: new OpenSans(20),
            labelAlignment: LabelAlignment::Center
        );
        
        $result = $builder->build();
        
        // Générer le code QR
        // $result = Builder::create()
        //     ->writer(new PngWriter())
        //     ->data($info_billet)  // Utilisez ici les données à encoder
        //     ->size(300)
        //     ->margin(10)
        //     ->build();

        // Chemin de sauvegarde du QR code
        $path = 'qr-code.png';

        // Enregistrer l'image dans un fichier
        file_put_contents($path, $result->getString()); // Sauvegarder le contenu de l'image dans un fichier
        return $path;
    }
}
