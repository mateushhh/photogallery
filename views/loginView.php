<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <title>Zaloguj się</title>
    <link rel="stylesheet" href="static/css/style.css" />
</head>

<body>

    <?php
    showUsers();
    ?>

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

    <div>
        <form action="/login" method="post" enctype="multipart/form-data">
            Podaj dane do logowania:<br />
            <input type="text" name="login" id="login" required="" placeholder="Login"><br>
            <input type="password" name="password" id="password" required="" placeholder="Hasło"><br>
            <input type="submit" value="Zaloguj" name="submit" />
        </form>
    </div>

    <?php
    if (isset($model['LoginError'])) {
        echo '<p id="error">' . $model['LoginError'] . '</p>';
    }
    ?>

</body>

</html>