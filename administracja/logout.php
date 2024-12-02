<?php
session_start();
// Usunięcie danych sesji
session_unset();
session_destroy();
// Przekierowanie do strony logowania
header("Location: ../index.php");
exit();
?>