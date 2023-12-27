<?php

//uruchamia funkcje z galleryModel.php - która zczytuje zawartość folderu ./images

class GalleryModel {
    public function getPhotos($directory) {
        $images = array_values(array_diff(scandir($directory),array('..','.','thumbnails','watermark')));
        return $images;
    }
}
?>