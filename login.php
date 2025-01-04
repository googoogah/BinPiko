<?php
session_start();
include 'db.php';

$error_message = ""; // Змінна для повідомлення про помилку

if (isset($_POST['login'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['name'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_id'] = $row['id'];

            if ($row['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error_message = "Невірний пароль.";
        }
    } else {
        $error_message = "Користувача не знайдено.";
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизація</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <h1>Авторизація</h1>
        <form action="login.php" method="POST">
            <label for="name">Ім'я:</label>
            <input type="text" name="name" id="name" required>
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit" name="login">Увійти</button>
        </form>
        <?php if (!empty($error_message)): ?>
            <p style="color: red; margin-top: 10px;"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
