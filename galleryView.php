<?php

$currentPage = isset($_GET['currentPage']) ? $_GET['currentPage'] : 1;
$limit = 9;
$start = ($currentPage-1)*$limit;
$end = $start + $limit;
$numberOfImages = count($images);
$totalPages = ceil($numberOfImages / $limit);

echo '<div id="galleryContent">';

for ($i = $start; $i < $end and $i < $numberOfImages; $i++) {
        $currentImage = $thumbnailDir.$images[$i];
        $currentImageWatermark = $watermarkDir.$images[$i];
        if (file_exists($currentImage) and is_file($currentImage)){
            echo '<a href="'.$currentImageWatermark.'"><img src="' . $currentImage . '" alt="Zdjęcie numer: '. $i .'"></a>';
        }
    }

echo '</div>';
echo '<div id="galleryControls">';
    if ($currentPage > 1) {
        echo '<a href="./index.php?currentPage=' . ($currentPage-1) . '">Poprzednia strona</a>';
    }

    echo ' Strona ' . $currentPage . ' z ' . $totalPages . ' ';

    if ($currentPage < $totalPages) {
        echo '<a href="./index.php?currentPage=' . ($currentPage+1) . '">Następna strona</a>';
    }
    echo '</div>';

    ?>