<?php
    // uruchamia funkcje z galleryModel.php - która zczytuje zawartość folderu ./images
    // wyświetla zdjęcia używając galleryView.php
    
    require_once 'galleryModel.php';

    $thumbnailDir = './images/thumbnails/';
    $watermarkDir = './images/watermark/';
    $GalleryModel = new GalleryModel();
    $images = $GalleryModel->getPhotos($thumbnailDir);

    include 'galleryView.php';

?>