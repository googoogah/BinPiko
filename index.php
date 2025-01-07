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
            <li><a href="index.php">Головна сторінка</a></li>
            <li><a href="Schema.php">Схема ліній передач</a></li>
            <li><a href="Diagrams.php">Діаграми</a></li>
            <li><a href="Graphic.php">Графіки</a></li>
            <li><a href="Database.php">Робота з БД</a></li>
            <li><button class="btn-about">About</button></li> <!-- Кнопка About -->
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
