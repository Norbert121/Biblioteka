<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $bookId = $_GET["id"];

    // Połączenie z bazą danych
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    // Usunięcie książki z bazy danych zabezpieczając przed atakiem SQL Injection
    $sql = "DELETE FROM books WHERE id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $bookId);
        if ($stmt->execute() === TRUE) {
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

