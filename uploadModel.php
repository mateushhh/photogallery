<?php

//funkcja uploadFile wykonuje całą logike uploadu, zwraca wyniki i wykonuje upload na serwer

class UploadModel {
    public function uploadFile($targetDirectory, $file) {
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
            return "Plik " . htmlspecialchars(basename($file["name"])) . " został przesłany.";
        } 
        else {
            return "Wystąpił błąd podczas przesyłania pliku.";
        }
    }


    public function createWatermark($directory, $file, $watermarkText){
        $uploadedFile = "./images/".basename($file["name"]);
        $watermarkFile = "./images/watermark/".basename($file["name"]); 
        $thumbnailFile = "./images/thumbnails/".basename($file["name"]); 
    
        if (file_exists($uploadedFile) && is_file($uploadedFile)){
            if (!(file_exists($thumbnailFile) && is_file($thumbnailFile))){
                
                $image = imagecreatefromstring(file_get_contents($uploadedFile));
                $transparency = 50;
                $textColor = imagecolorallocatealpha($image, 0, 255, 0, $transparency);
                $fontPath = './fonts/Roboto-Black.ttf';
                $fontSize = 70;
                $watermarkX = 10;
                $watermarkY = imagesy($image)/2;
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
}
?>