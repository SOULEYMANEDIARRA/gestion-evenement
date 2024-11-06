<?php
class EvnImages
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function firsImage($evn_id): string
    {
        // Récupérer la première image de la base de données
        $stmt = $this->pdo->prepare("SELECT ev_image FROM evenement WHERE evn_id = :evn_id LIMIT 1");
        $stmt->execute([
            'evn_id' => $evn_id
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Afficher la première image
        if ($row) {
            // Décoder la chaîne JSON en tableau
            $imagePaths = json_decode($row['ev_image'], true);

            // Afficher la première image si elle existe
            if (!empty($imagePaths)) {
                $firstImagePath = $imagePaths[0]; // Récupérer le premier chemin d'image
                // Vérifier si le fichier existe avant de l'afficher
                if (file_exists($firstImagePath)) {
                    return $firstImagePath;
                } else {
                    echo "<div style='color:red;'>Image non trouvée: $firstImagePath</div>";
                }
            } else {
                echo "Aucune image à afficher.";
            }
        } else {
            echo "Aucune image à afficher.";
        }
    }
    public function otherImage($evn_id)
    {
        $stmt = $this->pdo->prepare("SELECT ev_image FROM evenement WHERE evn_id = :evn_id");
        $stmt->execute([
            'evn_id' => $evn_id
        ]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $other_image = [];
        // Afficher toutes les images sauf la première
        if (!empty($results)) {

            $imagePaths = json_decode($results[0]['ev_image'], true);

            // Vérifier qu'il y a au moins deux images pour pouvoir exclure la première
            if (!empty($imagePaths) && count($imagePaths) > 1) {
                // Ignorer le premier élément et afficher les suivants
                for ($i = 1; $i < count($imagePaths); $i++) {
                    $imagePath = $imagePaths[$i];

                    // S'assurer que le fichier existe avant de l'afficher
                    if (file_exists($imagePath)) {
                        $other_image[] = $imagePath;
                    } else {
                        echo "<div style='color:red;'>Image non trouvée: $imagePath</div>";
                    }
                }
            } else {
                echo "Aucune image supplémentaire à afficher.";
            }
        } else {
            echo "Aucune image à afficher.";
        }
        return $other_image;
    }
    public static function insetImage()
    {
        $maxFileSize = 5 * 1024 * 1024; // 5 Mo
        $uploadDir = 'uploads/';
        // Vérification que le dossier existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $files = $_FILES['images'];
        $uploadedFiles = [];
        $errorMessages = [];

        // Parcourir chaque fichier sélectionné
        foreach ($files['tmp_name'] as $index => $tmpName) {
            // Vérifier l'erreur du fichier
            if ($files['error'][$index] !== UPLOAD_ERR_OK) {
                $errorMessages[] = "Erreur lors du téléchargement du fichier $index.";
                continue;
            }

            // Vérifier la taille du fichier
            if ($files['size'][$index] > $maxFileSize) {
                $errorMessages[] = "Le fichier {$files['name'][$index]} est trop volumineux.";
                continue;
            }

            // Vérifier que le fichier est une image
            $fileType = mime_content_type($tmpName);
            if (strpos($fileType, 'image') === false) {
                $errorMessages[] = "{$files['name'][$index]} n'est pas une image valide.";
                continue;
            }

            // Vérifier que le fichier est réellement une image
            if (getimagesize($tmpName) === false) {
                $errorMessages[] = "{$files['name'][$index]} n'est pas une image valide.";
                continue;
            }

            // Générer un nom de fichier unique
            $fileName = uniqid('img_', true) . '.' . pathinfo($files['name'][$index], PATHINFO_EXTENSION);
            $targetPath = $uploadDir . $fileName;

            // Déplacer le fichier vers le dossier de destination
            if (move_uploaded_file($tmpName, $targetPath)) {
                $uploadedFiles[] = $targetPath;
            } else {
                $errorMessages[] = "Erreur lors du téléchargement de {$files['name'][$index]}.";
            }
        }
        if (!empty($uploadedFiles)) {
            $jsonFiles = json_encode($uploadedFiles);
            return $jsonFiles;
        }
    }

    public static function profil()
    {
        $maxFileSize = 5 * 1024 * 1024; // 5 Mo
        $uploadDir = 'uploads/';
        // Vérification que le dossier existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $files = $_FILES['profil'];

        $tmpName = $files['tmp_name'];
        // Vérifier l'erreur du fichier
        if ($files['error'] !== UPLOAD_ERR_OK) {
            return "Erreur lors du téléchargement du fichier .";
        }

        // Vérifier la taille du fichier
        if ($files['size'] > $maxFileSize) {
            return "Le fichier {$files['name']} est trop volumineux.";;
        }

        // Vérifier que le fichier est une image
        $fileType = mime_content_type($tmpName);
        if (strpos($fileType, 'image') === false) {
            return "{$files['name']} n'est pas une image valide.";;
        }

        // Vérifier que le fichier est réellement une image
        if (getimagesize($tmpName) === false) {
            return "{$files['name']} n'est pas une image valide.";;
        }

        // Générer un nom de fichier unique
        $fileName = uniqid('img_', true) . '.' . pathinfo($files['name'], PATHINFO_EXTENSION);
        $targetPath = $uploadDir . $fileName;

        // Déplacer le fichier vers le dossier de destination
        if (move_uploaded_file($tmpName, $targetPath)) {
            return $targetPath;
        }
    }
}
