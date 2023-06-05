<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $author = $_POST["author"];

    // Połączenie z bazą danych
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    // Wstawienie nowej książki do bazy danych zabezpieczając przed atakiem SQL Injection
    $sql = "INSERT INTO books (title, author, status) VALUES (?, ?, 'unread')";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $title, $author);
        if ($stmt->execute() === TRUE) {
            $_SESSION['book_added'] = true;
            header("Location: index.php");
            exit;
        } else {
            echo "Błąd: " . $stmt->error;
        }
    } else {
        echo "Błąd: " . $conn->error;
    }

    $conn->close();
}
?>
