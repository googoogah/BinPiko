<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фотостудія</title>
    <link rel="stylesheet" href="style.css">
    
</head>
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
<body>
    <h1 style="text-align: center;">Ласкаво просимо до Обухів Енерго!</h1>
    <div class="welcome-section" style="text-align: center; margin: 20px;">
        <img src="obukhiv_energo.jpg" alt="Обухів Енерго" style="width: 50%; border-radius: 10px;">
        <p style="margin-top: 15px; font-size: 18px;">Обухів Енерго - провайдер якісних послуг для вашого бізнесу та дому. Ми гарантуємо надійність, професіоналізм та сучасні рішення.</p>
    </div>
    <div class="google-map" style="text-align: center; margin-top: 20px; margin-bottom: 140px;">
        <h2>Наше розташування</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2539.8218609202834!2d30.622445215738114!3d50.09776977942682!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4c74ab84f43c7%3A0xf1385c3786f9f3cb!2z0J7QsdC-0LzQtdC90L3Ri9C5INC_0LXRgC4sIE9idWhpdiwg0KPQvdGW0Lkg0LrQsNGI0LrQsNC90LAsINCa0LjQtdCy0L7QstCwLCAwODI3MA!5e0!3m2!1sen!2sua!4v1692976877884!5m2!1sen!2sua" width="600" height="450" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</body>
</html>
