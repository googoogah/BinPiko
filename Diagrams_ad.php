<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
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
 
        <div class="gallery-container">
<h1>СТОВПЧАСТІ ДІАГРАМИ СИЛИ СТРУМУ</h1>
        
            <?php
            $directory = 'БЕК/bars'; // Відносний шлях до папки з картинками від htdocs
            $images = glob($directory . "/*.png"); // Отримуємо всі PNG файли

            if (!empty($images)) {
                echo "<img id='galleryImage' src='{$images[0]}' alt='Графік'>";
            } else {
                echo "<p>Немає доступних зображень для відображення.</p>";
            }
            ?>

            <div class="gallery-controls">
                <button id="prevBtn">Попередня</button>
                <button id="nextBtn">Наступна</button>
            </div>
        </div>
    </main>

    <script>
        const images = <?php echo json_encode($images, JSON_UNESCAPED_SLASHES); ?>;
        let currentIndex = 0;

        const galleryImage = document.getElementById('galleryImage');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            galleryImage.src = images[currentIndex];
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % images.length;
            galleryImage.src = images[currentIndex];
        });
    </script>
</body>
</html>
