<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wynjmnij Skrzypka</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Wyjątkowa oprawa muzyczna</h1>
        <nav>
            <ul class="menu">
                <li><a href="?page=stronaglowna">Strona Główna</a></li>
                <li><a href="?page=onas">O Nas</a></li>
                <li><a href="?page=uslugi">Usługi</a></li>
                <li><a href="?page=kontakt">Kontakt</a></li>
                <li><a href="?page=log">Login</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <?php
        // Sprawdzenie, czy parametr 'page' jest ustawiony w URL
        $page = isset($_GET['page']) ? $_GET['page'] : 'stronaglowna';
        
        // Użycie include do załadowania odpowiedniego pliku
        $file ='kontent/'. $page . '.php';
        
        if (file_exists($file)) {
            include $file;
        } else {
            echo "<p>Nie znaleziono strony.</p>";
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Mateusz Śmidoda</p>
    </footer>
</body>
</html>