<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
include 'db.php'; //Підключення до бази даних
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фільтр Ліній</title>
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
        

        <div class="table-container">
<h1>Вивід даних з БД</h1>
        <div class="filter-form">
            <form method="GET" action="">
                <label for="line">Оберіть лінію:</label>
                <select id="line" name="line">
                    <option value="">Всі лінії</option>
                    <?php
                    $query = "SELECT line_number FROM `lines` ORDER BY line_number ASC";
                    $result = $conn->query($query);

                    while ($row = $result->fetch_assoc()) {
                        $lineNumber = $row['line_number'];
                        echo "<option value='$lineNumber'>Лінія $lineNumber</option>";
                    }
                    ?>
                </select>

                <label for="start_time">Початковий час:</label>
                <input type="datetime-local" id="start_time" name="start_time">

                <label for="end_time">Кінцевий час:</label>
                <input type="datetime-local" id="end_time" name="end_time">

                <button type="submit">Фільтрувати</button>
            </form>
        </div>
            <table>
                <thead>
                    <tr>
                        <th>Лінія</th>
                        <th>Час сканування</th>
                        <th>Сила струму (A)</th>
                        <th>Примітки</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $whereClauses = [];

                    if (!empty($_GET['line'])) {
                        $line = $conn->real_escape_string($_GET['line']);
                        $whereClauses[] = "ln.line_number = '$line'";
                    }

                    if (!empty($_GET['start_time']) && !empty($_GET['end_time'])) {
                        $start_time = $conn->real_escape_string($_GET['start_time']);
                        $end_time = $conn->real_escape_string($_GET['end_time']);
                        $whereClauses[] = "lr.scan_time BETWEEN '$start_time' AND '$end_time'";
                    }

                    $whereSQL = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

                    $query = "SELECT ln.line_number, lr.scan_time, lr.current_strength,  lr.remarks
                              FROM line_current_readings lr
                              JOIN `lines` ln ON lr.line_id = ln.id
                              JOIN statuses st ON lr.status_id = st.id
                              $whereSQL
                              ORDER BY lr.scan_time ASC";

                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>Лінія {$row['line_number']}</td>
                                <td>{$row['scan_time']}</td>
                                <td>{$row['current_strength']}</td>
                                <td>{$row['remarks']}</td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Дані не знайдено</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
