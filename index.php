<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Car Gallery</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <nav>
      <a href="./index.php">Home</a>
      <a href="./login.php">Zaloguj</a>
      <a href="./register.php">Rejestracja</a>
      <a href="./logout.php">Wyloguj</a>
    </nav>

    <div>
    <form action="index.php" method="post" enctype="multipart/form-data">
      Wybierz plik (PNG lub JPG, max 1MB):<br />
      <input type="file" name="fileToUpload" id="fileToUpload" required="" /><br>
      <input type="text" name="watermark" id="watermark" required="" placeholder="Znak wodny"><br>
      <input type="text" name="title" id="title" placeholder="Tytuł"><br>
      <input type="text" name="author" id="author" placeholder="Autor">
      <input type="submit" value="Prześlij plik" name="submit" />
    </form>

    <?php require_once 'uploadController.php'; ?>
    </div>

    <div>
      <?php require_once 'galleryController.php'; ?>
    </div>


  </body>
</html>
