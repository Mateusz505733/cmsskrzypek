<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Ustawienia katalogu na obrazy
$targetDir = "../uploads/";
$targetFile = $targetDir . basename($_FILES["image"]["name"]);
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Sprawdzenie typu pliku
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($imageFileType, $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type']);
    exit();
}

// Przesunięcie pliku do katalogu docelowego
if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
    echo json_encode(['success' => true, 'url' => $targetFile]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
}
?>