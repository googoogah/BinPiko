<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
include 'db.php'; // Підключення до бази даних

// Видалення запису
if (isset($_POST['delete_record'])) {
    $id = $_POST['record_id'];
    $sql = "DELETE FROM line_current_readings WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Додавання запису
if (isset($_POST['add_record'])) {
    $line_id = $_POST['line_id'];
    $scan_time = $_POST['scan_time'];
    $current_strength = $_POST['current_strength'];
    $status_id = $_POST['status_id'];
    $remarks = $_POST['remarks'];

    $sql = "INSERT INTO line_current_readings (line_id, scan_time, current_strength, status_id, remarks) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdss", $line_id, $scan_time, $current_strength, $status_id, $remarks);
    $stmt->execute();
}

// Редагування запису
if (isset($_POST['edit_record'])) {
    $id = $_POST['record_id'];
    $line_id = $_POST['line_id'];
    $scan_time = $_POST['scan_time'];
    $current_strength = $_POST['current_strength'];
    $status_id = $_POST['status_id'];
    $remarks = $_POST['remarks'];

    $sql = "UPDATE line_current_readings SET line_id = ?, scan_time = ?, current_strength = ?, status_id = ?, remarks = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdssi", $line_id, $scan_time, $current_strength, $status_id, $remarks, $id);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Керування БД</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <ul class="navbar-list">
            <li><a href="admin.php">Адмін панель</a></li>
            <li><a href="Schema_ad.php">Схема ліній передач</a></li>
            <li><a href="Diagrams_ad.php">Діаграми</a></li>
            <li><a href="Graphics_ad.php">Графіки</a></li>
            <li><a href="FilterBD.php">Перегляд БД</a></li>
            <li><a href="WorkBD_ad.php">Робота з БД</a></li>
            <li><a href="auth.php?logout=true">Вихід</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Керування даними</h1>

        <div class="form-container">
            <h2>Додати запис</h2>
            <form method="POST">
                <label for="line_id">ID Лінії:</label>
                <input type="number" id="line_id" name="line_id" required>

                <label for="scan_time">Час сканування:</label>
                <input type="datetime-local" id="scan_time" name="scan_time" required>

                <label for="current_strength">Сила струму (A):</label>
                <input type="number" step="0.01" id="current_strength" name="current_strength" required>

                <label for="status_id">Статус:</label>
                <input type="number" id="status_id" name="status_id" required>

                <label for="remarks">Примітки:</label>
                <input type="text" id="remarks" name="remarks">

                <button type="submit" name="add_record">Додати</button>
            </form>
        </div>

        <div class="table-container">
            <h2>Існуючі записи</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Лінія</th>
                        <th>Час сканування</th>
                        <th>Сила струму (A)</th>
                        <th>Статус</th>
                        <th>Примітки</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT lr.id, ln.line_number, lr.scan_time, lr.current_strength, lr.status_id, lr.remarks
                              FROM line_current_readings lr
                              JOIN `lines` ln ON lr.line_id = ln.id
                              ORDER BY lr.scan_time ASC";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>Лінія {$row['line_number']}</td>
                                <td>{$row['scan_time']}</td>
                                <td>{$row['current_strength']}</td>
                                <td>{$row['status_id']}</td>
                                <td>{$row['remarks']}</td>
                                <td>
                                    <form method='POST' style='display:inline-block;'>
                                        <input type='hidden' name='record_id' value='{$row['id']}'>
                                        <button type='submit' name='delete_record'>Видалити</button>
                                    </form>
                                </td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Дані не знайдено</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
