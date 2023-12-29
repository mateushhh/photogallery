<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./static/css/style.css">
    <title>Wyszukiwarka Zdjęć</title>
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

    <div id="searchbar">
        <input type="text" name="search" id="search" placeholder="Wyszukaj">
    </div>

    <div id="galleryContent">

    </div>

</body>

</html>