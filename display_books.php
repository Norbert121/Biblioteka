<?php
// Połączenie z bazą danych
$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

// Pobranie listy książek z bazy danych
$sql = "SELECT id, title, author, status FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["author"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td>";
        echo "<a href='mark_as_read.php?id=" . $row["id"] . "'>Oznacz jako przeczytane</a> | ";
        echo "<a href='mark_as_unread.php?id=" . $row["id"] . "'>Oznacz jako nieprzeczytane</a> | ";
        echo "<a href='delete_book.php?id=" . $row["id"] . "'>Usuń</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Brak książek w bibliotece.</td></tr>";
}

$conn->close();
?>
