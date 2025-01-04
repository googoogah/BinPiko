<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
include 'db.php'; // Файл підключення до бази даних
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Схема ліній передач</title>
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
    <h1>Схема ліній передач</h1>
    <form method="GET" action="">
        <label for="time">Оберіть час:</label>
        <select id="time" name="time">
            <?php
            $query = "SELECT DISTINCT scan_time FROM line_current_readings ORDER BY scan_time ASC";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                $scanTime = $row['scan_time'];
                echo "<option value='" . $scanTime . "'>" . $scanTime . "</option>";
            }
            ?>
        </select>
        <button type="submit">Відобразити стан</button>
    </form>

    <div class="container">
        <div class="map-container">
            <svg>
                <line x1="230" y1="180" x2="400" y2="260" class="line normal" id="line1"></line>
                <line x1="700" y1="173" x2="500" y2="140" class="line normal" id="line2"></line>
                <line x1="240" y1="457" x2="500" y2="140" class="line normal" id="line3"></line>
                <line x1="180" y1="400" x2="320" y2="550" class="line normal" id="line4"></line>
            </svg>
            <img src="obukhiv_map.png" alt="Карта Обухова">
        </div>

        <div class="info-panel" id="infoPanel">
            <div class="info-title">Інформація про лінію</div>
            <div class="info-item"><span>Струм:</span> <span id="current_strength_val">-</span></div>
            <div class="info-item"><span>Примітки:</span> <span id="remarks_val">-</span></div>
        </div>
    </div>

    <?php
    $lineData = [];
    $lineStatuses = []; 

    if (isset($_GET['time'])) {
        $time = $_GET['time'];

        $query = "SELECT ln.line_number, st.status_name, lr.current_strength, lr.remarks
                  FROM line_current_readings lr 
                  JOIN `lines` ln ON lr.line_id = ln.id 
                  JOIN statuses st ON lr.status_id = st.id 
                  WHERE lr.scan_time = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $time);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $lineNumber = $row['line_number'];
            $status = $row['status_name'];
            $current_strength = $row['current_strength'];
            $remarks = $row['remarks'];
            $statusClass = '';

            switch ($status) {
                case 'Нормальний':
                    $statusClass = 'normal';
                    break;
                case 'Перевантаження':
                    $statusClass = 'overload';
                    break;
                case 'Нестача':
                    $statusClass = 'underload';
                    break;
                case 'Розрив':
                    $statusClass = 'disconnected';
                    break;
                default:
                    $statusClass = 'normal';
            }

            $lineData[$lineNumber] = [
                'current_strength' => $current_strength,
                'remarks' => $remarks
            ];
            $lineStatuses[$lineNumber] = $statusClass;
        }

        $stmt->close();
    }
    ?>

    <script>
        var lineInfo = <?php echo json_encode($lineData, JSON_UNESCAPED_UNICODE); ?>;
        var lineStatuses = <?php echo json_encode($lineStatuses, JSON_UNESCAPED_UNICODE); ?>;

        // Застосовуємо класи статусу до кожної лінії
        Object.keys(lineStatuses).forEach(function(lineNum) {
            var lineElement = document.getElementById('line' + lineNum);
            if (lineElement) {
                lineElement.setAttribute('class', 'line ' + lineStatuses[lineNum]);
            }
        });

        function showLineInfo(lineNumber) {
            if (lineInfo[lineNumber]) {
                document.getElementById('current_strength_val').textContent = lineInfo[lineNumber]['current_strength'];
                document.getElementById('remarks_val').textContent = lineInfo[lineNumber]['remarks'];
            } else {
                document.getElementById('current_strength_val').textContent = '-';
                document.getElementById('remarks_val').textContent = '-';
            }
        }

        function clearLineInfo() {
            document.getElementById('current_strength_val').textContent = '-';
            document.getElementById('remarks_val').textContent = '-';
        }

        // Додаємо слухачі подій для ліній
        ['1','2','3','4'].forEach(function(num) {
            var lineElement = document.getElementById('line' + num);
            if (lineElement) {
                lineElement.addEventListener('mouseover', function() {
                    showLineInfo(num);
                });
                lineElement.addEventListener('mouseout', function() {
                    clearLineInfo();
                });
            }
        });
    </script>
</main>
</body>
</html>
