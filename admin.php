<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Видалення користувача
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id='$id' AND role='user'";
    $conn->query($sql);
}

// Додавання користувача
if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (name, password, role) VALUES ('$name', '$password', 'user')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green; text-align: center;'></p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Помилка: " . $conn->error . "</p>";
    }
}

// Отримання списку користувачів
$sql = "SELECT * FROM users WHERE role='user'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Попап */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            z-index: 1000;
        }

        /* Затінення фону */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Кнопка закриття */
        .popup-close {
            display: block;
            margin-top: 15px;
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .popup-close:hover {
            background-color: #0056b3;
        }

        .popup h2 {
            margin-bottom: 10px;
        }

        .popup p {
            font-size: 16px;
            margin-bottom: 15px;
        }
    </style>
</head>
<header>
    <nav class="navbar">
        <ul class="navbar-list">
            <li><a href="admin.php">Адмін панель</a></li>
            <li><a href="Schema_ad.php">Схема ліній передач</a></li>
            <li><a href="Diagrams_ad.php">Діаграми</a></li>
            <li><a href="Graphics_ad.php">Графіки</a></li>
            <li><a href="FilterBD.php">Перегляд БД</a></li>
            <li><a href="WorkBD_ad.php">Робота з БД</a></li>
            <li><button class="btn-about">About</button></li> <!-- Кнопка About -->
            <li><a href="auth.php?logout=true">Вихід</a></li>
        </ul>
    </nav>
</header>
<body>
    <div class="admin-panel">
        <div class="section">
            <h2 style="text-align: center;">Додати користувача</h2>
            <form method="POST">
                <label for="name">Ім'я:</label>
                <input type="text" name="name" id="name" required>

                <label for="password">Пароль:</label>
                <input type="password" name="password" id="password" required>

                <button type="submit" name="add_user">Додати</button>
            </form>
        </div>
        <div class="table-container">
            <h2 style="text-align: center;">Видалити користувача</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ім'я</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td>
                                <a href="admin.php?delete=<?php echo $row['id']; ?>">Видалити</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Попап -->
    <div class="popup-overlay"></div>
    <div class="popup">
        <h2>Version 2.0.1</h2>
        <p>Інформаційно-аналітична система обліку генерації, споживання та<br> 
        відключень електроенергії в умовах воєнного стану</p>
        <p><strong>ІАС Електрооблік (ІАСЕ)</strong></p>
        <button class="popup-close">Закрити</button>
    </div>

    <script>
        // Відкриття попапу
        document.querySelector('.btn-about').addEventListener('click', function () {
            document.querySelector('.popup-overlay').style.display = 'block';
            document.querySelector('.popup').style.display = 'block';
        });

        // Закриття попапу
        document.querySelector('.popup-close').addEventListener('click', function () {
            document.querySelector('.popup-overlay').style.display = 'none';
            document.querySelector('.popup').style.display = 'none';
        });

        // Закриття попапу при кліку на фон
        document.querySelector('.popup-overlay').addEventListener('click', function () {
            document.querySelector('.popup-overlay').style.display = 'none';
            document.querySelector('.popup').style.display = 'none';
        });
    </script>
</body>
</html>
