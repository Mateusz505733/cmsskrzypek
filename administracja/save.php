<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Odczytaj dane z JSON
    $data = json_decode(file_get_contents("php://input"), true);
    
    $fileName = $data['fileName'];
    $content = $data['content'];

    // Ścieżka do folderu kontent
    $filePath = "../kontent/" . basename($fileName);

    // Zapisz zawartość do pliku
    if (file_put_contents($filePath, $content) !== false) {
        echo json_encode(["success" => true]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Nie udało się zapisać pliku."]);
    }
} else {
    http_response_code(405);
}
?>