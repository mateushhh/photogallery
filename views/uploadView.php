<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <title>Dodaj Zdjęcie</title>
  <link rel="stylesheet" href="static/css/style.css" />
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

  <div>
    <form action="/upload" method="post" enctype="multipart/form-data">
      Wybierz plik (PNG lub JPG, max 1MB):<br />
      <input type="file" name="fileToUpload" id="fileToUpload" required="" /><br>
      <input type="text" name="watermark" id="watermark" required="" placeholder="Znak wodny"><br>
      <input type="text" name="title" id="title" required="" placeholder="Tytuł"><br>
      <input type="text" name="author" id="author" required="" placeholder="Autor">
      <input type="submit" value="Prześlij plik" name="submit" />
    </form>

    <?php
    if (isset($uploadData['uploadResult'])) {
      echo "<p>{$uploadData['uploadResult']}</p>";
    }
    ?>
  </div>

</body>

</html>