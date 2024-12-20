<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php?page=log");
    exit();
}
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php?page=log');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<link rel="stylesheet" href="../css/styleedytor.css">
    <title>Edytor</title>
    <script src="https://cdn.tiny.cloud/1/3gjfx29yg5xjtn7c9cw20bpzifsfyl0bayu92tvlcjcxsd59/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        let currentFileName = 'stronaglowna.php'; // Domyślny plik do edycji

        tinymce.init({
            selector: '#editor',  // Wybór elementu, który ma być edytowany
            plugins: 'lists link image table code', // Wtyczki do użycia
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code',
            height:500, // Wysokość edytora
            setup: function(editor) {
                // Ładowanie pliku 'stronaglowna.php' po inicjalizacji edytora
                loadFromServer(currentFileName);
            }
        });

        function saveContent() {
            const content = tinymce.get('editor').getContent();
            fetch('save.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ fileName: currentFileName, content: content })
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                alert('Zapisano pomyślnie!');
            })
            .catch(error => {
                console.error('Error saving file:', error);
                alert('Nie udało się zapisać pliku.');
            });
        }

        function loadFile(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    tinymce.get('editor').setContent(e.target.result);
                };
                reader.readAsText(file);
            }
        }

        function loadFromServer(fileName) {
            currentFileName = fileName; // Ustaw aktualny plik
            fetch(`../kontent/${fileName}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(data => {
                    tinymce.get('editor').setContent(data);
                })
                .catch(error => {
                    console.error('Error loading file:', error);
                    alert('Nie udało się załadować pliku.');
                });
        }
    </script>
    <script>
        function uploadImage() {
    const fileInput = document.getElementById('imageUpload');
    const file = fileInput.files[0];

    if (file) {
        const formData = new FormData();
        formData.append('image', file);

        fetch('upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Wstawienie obrazu do edytora
                const imageUrl = data.url; // URL przesłanego obrazu
                tinymce.get('editor').insertContent(`<img src="${imageUrl}" alt="Uploaded Image"/>`);
                alert('Obraz został wgrany i dodany do edytora!');
            } else {
                alert('Wystąpił błąd podczas wgrywania obrazu.');
            }
        })
        .catch(error => {
            console.error('Error uploading image:', error);
            alert('Nie udało się wgrać obrazu.');
        });
    } else {
        alert('Proszę wybrać obraz do wgrania.');
    }
}
        </script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administracyjny</title>
</head>
<body>
<h1>Edytor Stron</h1>

<h2>Wybierz plik do edycji</h2>
<button onclick="loadFromServer('stronaglowna.php')">Główna</button>
<button onclick="loadFromServer('onas.php')">O nas</button>
<button onclick="loadFromServer('uslugi.php')">Usługi</button>
<button onclick="loadFromServer('kontakt.php')">Kontakt</button>

<h2>Dodaj grafikę</h2>
<form id="uploadForm" enctype="multipart/form-data">
    <input type="file" id="imageUpload" accept="image/*" />
    <button type="button" onclick="uploadImage()">Wgraj obraz</button>
</form>

<form id="contentForm">
    <textarea id="editor"></textarea><br>
    <button type="button" onclick="saveContent()">Zapisz</button>
</form>
    </br>
    <a href="logout.php"><button>Wyloguj się</button></a>
</body>
</html>