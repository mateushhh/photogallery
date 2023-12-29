<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./static/css/style.css">
    <title>Galeria Zdjęć</title>
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

    <form action="/" method="post">
        <div id="galleryContent">
            <?php
            $imageInfo = $model['imageInfo'];
            $start = $model['galleryData']['start'];
            $end = $model['galleryData']['end'];
            $images = $model['galleryData']['images'];

            for ($i = $start; $i < $end && $i < count($images); $i++) {
                $currentImage = $model['galleryData']['thumbnailDir'] . $images[$i];
                $currentImageWatermark = $model['galleryData']['watermarkDir'] . $images[$i];

                if (file_exists($currentImage) && is_file($currentImage)) {
                    echo '<div class="photo">';
                    echo '<a href="' . $currentImageWatermark . '"><img src="' . $currentImage . '" alt="Zdjęcie numer: ' . $i . '"></a>';
                    echo '<div>';
                    echo 'Tytuł: ' . $imageInfo[$i]['title'] . '<br>';
                    echo 'Autor: ' . $imageInfo[$i]['author'] . '<br>';
                    echo 'Plik: ' . $imageInfo[$i]['file_name'] . '<br>';
                    $isChecked = in_array($images[$i], $_SESSION['selected_photos'] ?? []);
                    echo 'Zapisz zdjęcie <input type="checkbox" name="selected_photos[' . $i . ']" value="' . $images[$i] . '" ' . ($isChecked ? 'checked' : '') . '>';
                    echo '</div></div>';
                }
            }
            ?>
            <input type="submit" value="Zapamiętaj wybrane">
        </div>
    </form>

    <div id="galleryControls">
        <?php if ($model['galleryData']['currentPage'] > 1): ?>
            <a href="?action=/&currentPage=<?php echo ($model['galleryData']['currentPage'] - 1); ?>">Poprzednia
                strona</a>
        <?php endif; ?>

        Strona
        <?php echo $model['galleryData']['currentPage']; ?>
        z
        <?php echo $model['galleryData']['totalPages']; ?>

        <?php if ($model['galleryData']['currentPage'] < $model['galleryData']['totalPages']): ?>
            <a href="?action=/&currentPage=<?php echo ($model['galleryData']['currentPage'] + 1); ?>">Następna
                strona</a>
        <?php endif; ?>
    </div>



</body>

</html>