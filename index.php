<!DOCTYPE html>
<html>
<head>
    <title>System zarządzania domową biblioteką</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <?php
    session_start();
    if (isset($_SESSION['book_added']) && $_SESSION['book_added']) {
        echo "<script type='text/javascript'>alert('Książka dodana!');</script>";
        $_SESSION['book_added'] = false;
    }
    ?>
    <h1>System zarządzania domową biblioteką</h1>
    <form action="add_book.php" method="POST">
        <label>Tytuł:</label>
        <input type="text" name="title" required>
        <br>
        <label>Autor:</label>
        <input type="text" name="author" required>
        <br>
        <input type="submit" value="Dodaj książkę">
    </form>

    <h2>Twoje książki:</h2>
    <table>
        <tr>
            <th>Tytuł</th>
            <th>Autor</th>
            <th>Status</th>
            <th>Akcje</th>
        </tr>
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

        // Pobranie książek z bazy danych
        $sql = "SELECT * FROM books";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["author"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td class='actions'>";
                if ($row["status"] == "read") {
                    echo "<a href='mark_as_unread.php?id=" . $row["id"] . "'>Oznacz jako nieprzeczytane</a>";
                } else {
                    echo "<a href='mark_as_read.php?id=" . $row["id"] . "'>Oznacz jako przeczytane</a>";
                }
                echo " | ";
                echo "<a href='delete_book.php?id=" . $row["id"] . "'>Usuń</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Brak książek w bibliotece.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
    </div>
</body>
</html>

