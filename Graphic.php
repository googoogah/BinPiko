<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
include 'db.php'; // Підключення до бази даних
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додаткові послуги</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <header>
        <nav class="navbar">
        <ul class="navbar-list">
            <li><a href="index.php">Головна сторінка</a></li>
            <li><a href="Schema.php">Схема ліній передач</a></li>
            <li><a href="Diagrams.php">Діаграми</a></li>
            <li><a href="Graphic.php">Графіки</a></li>
            <li><a href="Database.php">Робота з БД</a></li>
            <li><a href="auth.php?logout=true">Вихід</a></li>
        </ul>
        </nav>
    </header>

    <main>

        <div class="image-container1">
<h1>Графіки перепадів напруги по лініям</h1>

        <div class="selection-container">
            <form method="GET" action="">
                <label for="line">Оберіть лінію:</label>
                <select id="line" name="line">
                    <?php
                    $query = "SELECT line_number FROM `lines` ORDER BY line_number ASC";
                    $result = $conn->query($query);

                    while ($row = $result->fetch_assoc()) {
                        $lineNumber = $row['line_number'];
                        $selected = (isset($_GET['line']) && $_GET['line'] == $lineNumber) ? 'selected' : '';
                        echo "<option value='$lineNumber' $selected>Лінія $lineNumber</option>";
                    }
                    ?>
                </select>
                <button type="submit">Показати</button>
            </form>
        </div>
            <?php
            if (isset($_GET['line'])) {
                $selectedLine = $_GET['line'];
                $imagePath = "БЕК/time_series_line_$selectedLine.png"; // Шлях до зображення

                if (file_exists($imagePath)) {
                    echo "<img src='$imagePath' alt='Лінія $selectedLine'>";
                } else {
                    echo "<p>Зображення для лінії $selectedLine відсутнє.</p>";
                }
            } else {
                echo "<p>Оберіть лінію для відображення зображення.</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>
