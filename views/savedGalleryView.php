<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./static/css/style.css">
    <title>Zapisane Zdjęcia</title>
</head>

<body>
    <nav>
        <a href="/">Galeria</a>
        <a href="/upload">Upload</a>
        <a href="/search">Wyszukiwarka</a>
        <a href="/savedGalleryView">Zapisane</a>
        <?php
        if (isset($_SESSION['user'])) {
            echo '<a href="/logout">Wyloguj</a>';
        } else {
            echo '<a href="/login">Zaloguj</a>';
            echo '<a href="/register">Rejestracja</a>';
        }
        ?>
    </nav>

    <div id="galleryContent">
        <?php
        foreach ($model['selectedPhotosInfo'] as $index => $selectedPhoto) {
            $currentImage = $selectedPhoto['thumbnailDir'] . $selectedPhoto['file_name'];
            $currentImageWatermark = $selectedPhoto['watermarkDir'] . $selectedPhoto['file_name'];

            echo '<div class="photo">';
            echo '<a href="' . $currentImageWatermark . '"><img src="' . $currentImage . '" alt="' . $selectedPhoto['title'] . '"></a>';
            echo '<div>';
            echo 'Tytuł: ' . $selectedPhoto['title'] . '<br>';
            echo 'Autor: ' . $selectedPhoto['author'] . '<br>';
            echo 'Plik: ' . $selectedPhoto['file_name'] . '<br>';
            echo '</div></div>';
        }
        ?>
    </div>
</body>

</html>