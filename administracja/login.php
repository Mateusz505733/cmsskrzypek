<?php
session_start();

// Przykładowe dane użytkowników (w praktyce powinny być w bazie danych)
$users = [
    "user" => "user123",
];

// Sprawdzenie, czy formularz został przesłany
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['loggedin'] = true;
    // Weryfikacja danych użytkownika
    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        header("Location: edytor.php");
        exit();
    } else {
        echo "<script>alert('Błędna nazwa użytkownika lub hasło.'); window.location.href='../index.php?page=log';</script>";
    }
}
?>
