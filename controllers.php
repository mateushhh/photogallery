<?php
require_once 'business.php';

function gallery(&$model)
{
    $thumbnailDir = './images/thumbnails/';
    $watermarkDir = './images/watermark/';

    function getPhotos($directory)
    {
        return array_values(array_diff(scandir($directory), array('..', '.', 'thumbnails', 'watermark')));
    }

    $currentPage = isset($_GET['currentPage']) ? $_GET['currentPage'] : 1;
    $limit = 6;
    $start = ($currentPage - 1) * $limit;
    $end = $start + $limit;

    $images = getPhotos($thumbnailDir);

    foreach ($images as $file_name) {

        $photoInfo = get_photo_info($file_name);

        if ($photoInfo) {
            $author = $photoInfo['author'];
            $title = $photoInfo['title'];

            $model['imageInfo'][] = [
                'author' => $author,
                'title' => $title,
                'file_name' => $file_name
            ];
        }
    }

    $model['galleryData'] = [
        'currentPage' => $currentPage,
        'limit' => $limit,
        'start' => $start,
        'end' => $end,
        'numberOfImages' => count($images),
        'totalPages' => ceil(count($images) / $limit),
        'images' => $images,
        'thumbnailDir' => $thumbnailDir,
        'watermarkDir' => $watermarkDir,
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['selected_photos'])) {
            foreach ($_POST['selected_photos'] as $index => $selectedPhoto) {
                $_SESSION['selected_photos'][$index] = $selectedPhoto;
            }
        }
    }

    return 'galleryView';
}

function savedGallery(&$model)
{
    $thumbnailDir = './images/thumbnails/';
    $watermarkDir = './images/watermark/';

    if (isset($_SESSION['selected_photos'])) {
        $selectedPhotos = $_SESSION['selected_photos'];
    } else {
        $selectedPhotos = [];
    }

    $model['selectedPhotosInfo'] = [];

    foreach ($selectedPhotos as $file_name) {
        $photoInfo = get_photo_info($file_name);

        if ($photoInfo) {
            $author = $photoInfo['author'];
            $title = $photoInfo['title'];

            $model['selectedPhotosInfo'][] = [
                'author' => $author,
                'title' => $title,
                'file_name' => $file_name,
                'thumbnailDir' => $thumbnailDir,
                'watermarkDir' => $watermarkDir,
            ];
        }
    }

    return 'savedGalleryView';
}

function removeSavedPhoto(&$model)
{

}

function upload(&$model)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["fileToUpload"])) {
        $file = $_FILES["fileToUpload"];
        $targetDirectory = "./images/";
        $watermarkText = $_POST["watermark"];
        $title = $_POST["title"];
        $author = $_POST["author"];

        $uploadResult = uploadFile($targetDirectory, $file, $title, $author);
        createWatermark($targetDirectory, $file, $watermarkText);

        $model['uploadData'] = [
            'uploadResult' => $uploadResult,
            'targetDirectory' => $targetDirectory,
            'watermarkText' => $watermarkText,
        ];

        return 'uploadView';
    }

    return 'uploadView';
}

function uploadFile($targetDirectory, $file, $title, $author)
{
    //var_dump($file);
    $targetFile = $targetDirectory . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (file_exists($targetFile)) {
        return "Plik już istnieje.";
    }
    if ($file["size"] > 1000000) {
        return "Plik jest zbyt duży (max 1MB).";
    }
    if ($imageFileType != "jpg" && $imageFileType != "png") {
        return "Dozwolone są tylko pliki JPG i PNG.";
    }
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        save_photo_data($author, $title, basename($file["name"]));
        return "Plik " . htmlspecialchars(basename($file["name"])) . " został przesłany.";
    } else {
        return "Wystąpił błąd podczas przesyłania pliku.";
    }
}

function createWatermark($directory, $file, $watermarkText)
{
    $uploadedFile = "./images/" . basename($file["name"]);
    $watermarkFile = "./images/watermark/" . basename($file["name"]);
    $thumbnailFile = "./images/thumbnails/" . basename($file["name"]);
    if (file_exists($uploadedFile) && is_file($uploadedFile)) {
        if (!(file_exists($thumbnailFile) && is_file($thumbnailFile))) {
            $image = imagecreatefromstring(file_get_contents($uploadedFile));
            $transparency = 50;
            $textColor = imagecolorallocatealpha($image, 0, 255, 0, $transparency);
            $fontPath = './fonts/Roboto-Black.ttf';
            $fontSize = 70;
            $watermarkX = 10;
            $watermarkY = imagesy($image) / 2;
            imagettftext($image, $fontSize, 0, $watermarkX, $watermarkY, $textColor, $fontPath, $watermarkText);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            imagepng($image, $watermarkFile);
            $thumbnail = imagecreatetruecolor(200, 125);
            $originalImage = imagecreatefromstring(file_get_contents($uploadedFile));
            imagecopyresampled($thumbnail, $originalImage, 0, 0, 0, 0, 200, 125, imagesx($originalImage), imagesy($originalImage));
            imagejpeg($thumbnail, $thumbnailFile);
            imagedestroy($image);
            imagedestroy($originalImage);
            imagedestroy($thumbnail);
        }
    }
}

function register(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['login'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if (user_exists($login)) {
            $model['LoginError'] = 'Użytkownik o podanym loginie już istnieje.';
        } elseif ($password1 === $password2) {
            if (register_user($login, $password1)) {
                header('Location: /login');
                exit();
            } else {
                $model['LoginError'] = 'Wystąpił błąd przy tworzeniu konta.';
            }
        } else {
            $model['LoginError'] = 'Hasła nie są identyczne.';
        }
    }

    return 'registerView';
}

function login(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['login'];
        $password = $_POST['password'];

        if (validate_login($login, $password)) {
            $_SESSION['user'] = $login;

            header('Location: /');
            exit();
        } else {
            $model['LoginError'] = 'Nieprawidłowy login lub hasło.';
        }
    }

    return 'loginView';
}

function logout(&$model)
{
    session_destroy();

    header('Location: /');
    exit();
}

function search(&$model)
{
    return 'searchView';
}
