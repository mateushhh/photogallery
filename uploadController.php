<?php
// uploadController dostaje dane z index.php
// przesyła je do funkcji z uploadModel gdzie sprawdzany jest rezultat uploadu
// wyświetla używając uploadView

require 'uploadModel.php';

$uploadModel = new UploadModel();
$targetDirectory = "./images/";
$watermarkText = $_POST["watermark"];

if ($_SERVER["REQUEST_METHOD"] === "POST" and isset($_FILES["fileToUpload"])) {
    $file = $_FILES["fileToUpload"];
    $uploadResult = $uploadModel->uploadFile($targetDirectory, $file);
}

$uploadModel->createWatermark($targetDirectory, $file, $watermarkText);

require 'uploadView.php';

?>